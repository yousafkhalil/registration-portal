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
     * Super Admin Permission Form: Update Fee Structure & Status Override
     */
    public function updateFeeStructure(Request $request, int $id)
    {
        $request->validate([
            'fee_amount'       => 'nullable|numeric|min:0',
            'payment_status'   => 'nullable|in:paid,unpaid,pending_verification',
            'due_date'         => 'nullable|date',
            'guests_count'     => 'nullable|integer|min:0|max:2',
            'admin_notes'      => 'nullable|string|max:1000',
            'rejection_reason' => 'nullable|string|max:500',
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

        return back()->with([
            'message'    => 'Convocation master settings updated successfully in database!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Add or Update Focal Person
     */
    public function saveFocalPerson(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'mobile' => 'required|string|max:50',
        ]);

        if ($request->filled('id')) {
            $person = \App\Models\ConvocationFocalPerson::findOrFail($request->input('id'));
            $person->update([
                'name'        => $request->input('name'),
                'designation' => $request->input('designation', 'Convocation Focal Person'),
                'mobile'      => $request->input('mobile'),
                'email'       => $request->input('email'),
                'sort_order'  => (int)$request->input('sort_order', 1),
                'is_active'   => $request->boolean('is_active', true),
            ]);
            $msg = 'Focal person updated successfully.';
        } else {
            \App\Models\ConvocationFocalPerson::create([
                'name'        => $request->input('name'),
                'designation' => $request->input('designation', 'Convocation Focal Person'),
                'mobile'      => $request->input('mobile'),
                'email'       => $request->input('email'),
                'sort_order'  => (int)$request->input('sort_order', 1),
                'is_active'   => true,
            ]);
            $msg = 'New focal person added successfully.';
        }

        return back()->with(['message' => $msg, 'alert-type' => 'success']);
    }

    /**
     * Delete Focal Person
     */
    public function deleteFocalPerson($id)
    {
        \App\Models\ConvocationFocalPerson::destroy($id);
        return back()->with(['message' => 'Focal person deleted successfully.', 'alert-type' => 'info']);
    }
}

