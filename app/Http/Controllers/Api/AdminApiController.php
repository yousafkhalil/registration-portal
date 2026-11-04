<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StudentRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminApiController extends Controller
{
    protected StudentRegistrationService $service;

    public function __construct(StudentRegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * GET /api/admin/stats
     */
    public function stats()
    {
        $stats = $this->service->getAdminDashboardStats();
        return response()->json([
            'success' => true,
            'data'    => $stats,
        ]);
    }

    /**
     * GET /api/admin/students
     */
    public function students(Request $request)
    {
        $filters = [
            'status'     => $request->query('status'),
            'department' => $request->query('department'),
            'search'     => $request->query('search'),
            'per_page'   => $request->query('per_page', 20),
        ];

        $students = $this->service->getAdminStudentsList($filters);

        return response()->json([
            'success' => true,
            'data'    => $students,
        ]);
    }

    /**
     * GET /api/admin/students/{id}
     */
    public function show(int $id)
    {
        $reg = $this->service->getRegistrationById($id);
        if (!$reg) {
            return response()->json(['success' => false, 'message' => 'Student registration not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $reg,
        ]);
    }

    /**
     * POST /api/admin/students/{id}/approve
     */
    public function approve(Request $request, int $id)
    {
        try {
            $admin = Auth::user();
            $adminNotes = $request->input('admin_notes');
            $result = $this->service->approvePayment($id, $admin->id, $adminNotes);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /api/admin/students/{id}/reject
     */
    public function reject(Request $request, int $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $admin = Auth::user();
            $reason = $request->input('rejection_reason');
            $adminNotes = $request->input('admin_notes');

            $result = $this->service->rejectPayment($id, $admin->id, $reason, $adminNotes);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /api/admin/students/{id}/update-fee-structure
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

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

