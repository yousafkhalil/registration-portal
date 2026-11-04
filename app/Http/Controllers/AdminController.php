<?php

namespace App\Http\Controllers;

use App\Services\StudentRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected StudentRegistrationService $service;

    public function __construct(StudentRegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * Admin Dashboard with overview metrics
     */
    public function dashboard()
    {
        $stats = $this->service->getAdminDashboardStats();
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Students List with filters & quick verification
     */
    public function students(Request $request)
    {
        $filters = [
            'status'     => $request->query('status'),
            'department' => $request->query('department'),
            'search'     => $request->query('search'),
            'per_page'   => 20,
        ];

        $students = $this->service->getAdminStudentsList($filters);
        $stats = $this->service->getAdminDashboardStats();

        return view('admin.students.index', compact('students', 'filters', 'stats'));
    }

    /**
     * View Single Student Profile & Permission / Fee Structure Form
     */
    public function show(int $id)
    {
        $registration = $this->service->getRegistrationById($id);
        if (!$registration) {
            return redirect()->route('admin.students')->with('error', 'Student registration not found.');
        }

        return view('admin.students.show', compact('registration'));
    }

    /**
     * Super Admin Approve Payment
     */
    public function approvePayment(Request $request, int $id)
    {
        try {
            $admin = Auth::user();
            $adminNotes = $request->input('admin_notes');

            $result = $this->service->approvePayment($id, $admin->id, $adminNotes);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return back()->with([
                'message'    => $result['message'],
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['admin' => 'Approval failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Super Admin Reject Payment
     */
    public function rejectPayment(Request $request, int $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $admin = Auth::user();
            $reason = $request->input('rejection_reason');
            $adminNotes = $request->input('admin_notes');

            $result = $this->service->rejectPayment($id, $admin->id, $reason, $adminNotes);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return back()->with([
                'message'    => $result['message'],
                'alert-type' => 'warning'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['admin' => 'Rejection failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Super Admin Mark as Pending Verification (Fee Pending)
     */
    public function markPendingPayment(Request $request, int $id)
    {
        try {
            $admin = Auth::user();
            $adminNotes = $request->input('admin_notes');

            $result = $this->service->markPendingPayment($id, $admin->id, $adminNotes);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return back()->with([
                'message'    => $result['message'],
                'alert-type' => 'info'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['admin' => 'Mark pending failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Super Admin Universal Status Update
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'payment_status'   => 'required|in:paid,unpaid,pending_verification',
            'rejection_reason' => 'nullable|string|max:500',
            'admin_notes'      => 'nullable|string|max:1000',
        ]);

        try {
            $admin = Auth::user();
            $status = $request->input('payment_status');
            $reason = $request->input('rejection_reason');
            $notes = $request->input('admin_notes');

            $result = $this->service->updatePaymentStatus($id, $admin->id, $status, $reason, $notes);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            $alertType = $status === 'paid' ? 'success' : ($status === 'unpaid' ? 'warning' : 'info');

            return back()->with([
                'message'    => $result['message'],
                'alert-type' => $alertType
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['admin' => 'Status update failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Super Admin Permission Form: Update Fee Structure & Status Override
     */
    public function updateFeeStructure(Request $request, int $id)
    {
        $request->validate([
            'base_fee'          => 'nullable|numeric|min:0',
            'is_custom_waiver'  => 'nullable',
            'fee_amount'        => 'nullable|numeric|min:0',
            'payment_status'    => 'nullable|in:paid,unpaid,pending_verification',
            'due_date'          => 'nullable|date',
            'guests_count'      => 'nullable|integer|min:0|max:2',
            'admin_notes'       => 'nullable|string|max:1000',
            'rejection_reason'  => 'nullable|string|max:500',
        ]);

        try {
            $admin = Auth::user();
            $result = $this->service->updateFeeStructure($id, $admin->id, $request->all());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json($result);
            }

            return back()->with([
                'message'    => $result['message'],
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['admin' => 'Fee update failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Show Convocation Settings & Configuration Form
     */
    public function settings()
    {
        $settings = \App\Models\ConvocationSetting::current();
        $focalPersons = \App\Models\ConvocationFocalPerson::orderBy('sort_order', 'asc')->get();
        $programs = \App\Models\AcademicProgram::orderBy('sort_order', 'asc')->get();

        return view('admin.settings', compact('settings', 'focalPersons', 'programs'));
    }

    /**
     * Update Convocation Settings (Saved in database table)
     */
    public function updateSettings(Request $request)
    {
        $settings = \App\Models\ConvocationSetting::current();
        $data = $request->except(['_token']);

        if (!empty($data['convocation_date'])) {
            $data['convocation_date_formatted'] = date('l, d F Y', strtotime($data['convocation_date']));
        }
        if (!empty($data['registration_deadline'])) {
            $data['registration_deadline_formatted'] = date('d F Y', strtotime($data['registration_deadline']));
        }

        $settings->update($data);

        // Automatically update fee_amount for all unpaid registrations based on new base fee & guest fee
        if (isset($data['base_registration_fee']) || isset($data['guest_fee_per_person'])) {
            $base = (float)$settings->base_registration_fee;
            $perGuest = (float)$settings->guest_fee_per_person;

            \App\Models\StudentRegistration::where('payment_status', '!=', 'paid')->get()->each(function ($student) use ($base, $perGuest) {
                $hasCustomWaiver = !empty($student->admin_notes) && preg_match('/(discount|waiver|concession|custom fee)/i', $student->admin_notes);
                if (!$hasCustomWaiver) {
                    $student->fee_amount = $base + ((int)$student->guests_count * $perGuest);
                    $student->save();
                }
            });
        }

        return back()->with([
            'message'    => 'Convocation master settings updated successfully in database! All unpaid registrations have been re-calculated.',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Get Focal Person JSON
     */
    public function getFocalPerson($id)
    {
        $person = \App\Models\ConvocationFocalPerson::findOrFail($id);
        return response()->json(['success' => true, 'data' => $person]);
    }

    /**
     * Add or Update Focal Person
     */
    public function saveFocalPerson(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'mobile'      => 'required|string|max:50',
            'designation' => 'nullable|string|max:100',
            'email'       => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable',
        ]);

        $personId = $request->input('id');
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : true;

        if (!empty($personId) && is_numeric($personId) && (int)$personId > 0) {
            $person = \App\Models\ConvocationFocalPerson::findOrFail((int)$personId);
            $person->update([
                'name'        => trim($request->input('name')),
                'designation' => trim($request->input('designation') ?: 'Convocation Focal Person'),
                'mobile'      => trim($request->input('mobile')),
                'email'       => $request->filled('email') ? strtolower(trim($request->input('email'))) : null,
                'sort_order'  => (int)$request->input('sort_order', 1),
                'is_active'   => $isActive,
            ]);
            $msg = 'Focal person "' . $person->name . '" updated successfully.';
        } else {
            $person = \App\Models\ConvocationFocalPerson::create([
                'name'        => trim($request->input('name')),
                'designation' => trim($request->input('designation') ?: 'Convocation Focal Person'),
                'mobile'      => trim($request->input('mobile')),
                'email'       => $request->filled('email') ? strtolower(trim($request->input('email'))) : null,
                'sort_order'  => (int)$request->input('sort_order', 1),
                'is_active'   => $isActive,
            ]);
            $msg = 'New focal person "' . $person->name . '" added successfully.';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $msg, 'data' => $person]);
        }

        return redirect()->to(route('admin.settings') . '#focal_persons_card')->with(['message' => $msg, 'alert-type' => 'success']);
    }

    /**
     * Delete Focal Person
     */
    public function deleteFocalPerson(Request $request, $id)
    {
        $person = \App\Models\ConvocationFocalPerson::find($id);
        $name = $person ? $person->name : 'Focal person';
        if ($person) {
            $person->delete();
        }

        $msg = "Focal person '{$name}' deleted successfully.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return redirect()->to(route('admin.settings') . '#focal_persons_card')->with(['message' => $msg, 'alert-type' => 'info']);
    }
}

