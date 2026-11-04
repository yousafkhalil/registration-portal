<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStudentRequest;
use App\Http\Requests\UpdateStudentDetailsRequest;
use App\Models\User;
use App\Services\StudentRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationController extends Controller
{
    protected StudentRegistrationService $service;

    public function __construct(StudentRegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * Show Public Registration Form
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/student/details');
        }

        return view('auth.register');
    }

    /**
     * Web Registration Handler
     */
    public function register(RegisterStudentRequest $request)
    {
        try {
            $result = $this->service->registerStudent($request->validated());

            if (!empty($result['user']['id'])) {
                $user = User::find($result['user']['id']);
                if ($user) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    if (!empty($result['token'])) {
                        session(['sanctum_token' => $result['token']]);
                    }
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return redirect('/student/challan')->with([
                'message'    => 'Registration successful! Your Convocation Fee Challan is ready.',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['general' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show Login Form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/student/details');
        }

        return view('auth.login');
    }

    /**
     * Web Login Handler
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', strtolower(trim($credentials['email'])))->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            $token = $user->createToken('web-session')->plainTextToken;
            session(['sanctum_token' => $token]);

            $targetUrl = $user->isAdmin() ? route('admin.dashboard') : url('/student/details');

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'Login successful!',
                    'token'        => $token,
                    'is_admin'     => $user->isAdmin(),
                    'redirect_url' => $targetUrl
                ]);
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/student/details');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    /**
     * Show Student Details Edit Form
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $details = $this->service->getStudentDetails($user->id);
        $studentRegistration = $details['data'];

        return view('Student.edit_details', compact('user', 'studentRegistration'));
    }

    /**
     * Update Student Details
     */
    public function update(UpdateStudentDetailsRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        try {
            $result = $this->service->updateStudentDetails($user->id, $request->validated());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return back()->with([
                'message'    => 'Student registration details successfully updated!',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Update failed: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['general' => 'Update failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show Printable Bank Fee Challan / Voucher
     */
    public function showChallan(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $targetUserId = $user->id;
        if ($user->isAdmin() && $request->has('student_id')) {
            $targetUserId = (int)$request->query('student_id');
        }

        $challanData = $this->service->getChallanDetails($targetUserId);
        if (!$challanData['success']) {
            $fallbackRoute = $user->isAdmin() ? 'admin.students' : 'student.details.edit';
            return redirect()->route($fallbackRoute)->with('error', $challanData['message']);
        }

        return view('Student.challan', $challanData);
    }

    /**
     * Show Fee Payment Options Page (Online Payment or Upload Bank Receipt)
     */
    public function showPayment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $challanData = $this->service->getChallanDetails($user->id);
        if (!$challanData['success']) {
            return redirect()->route('student.details.edit')->with('error', $challanData['message']);
        }

        return view('Student.payment', $challanData);
    }

    /**
     * Process In-App Online Payment
     */
    public function payOnline(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'gateway' => 'required|string',
        ]);

        try {
            $result = $this->service->payOnline($user->id, $request->all());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return redirect()->route('student.payment')->with([
                'message'    => $result['message'],
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }

    /**
     * Submit Bank Deposit Receipt (Offline Challan Proof)
     */
    public function uploadReceipt(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'deposit_date'   => 'required|date',
            'transaction_id' => 'nullable|string|max:100',
            'receipt_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $result = $this->service->submitBankDepositReceipt(
                $user->id,
                $request->all(),
                $request->file('receipt_file')
            );

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return redirect()->route('student.payment')->with([
                'message'    => $result['message'],
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['receipt' => $e->getMessage()]);
        }
    }

    /**
     * Web Logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
