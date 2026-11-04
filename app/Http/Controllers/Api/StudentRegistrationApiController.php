<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStudentRequest;
use App\Http\Requests\UpdateStudentDetailsRequest;
use App\Models\User;
use App\Services\StudentRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentRegistrationApiController extends Controller
{
    protected StudentRegistrationService $service;

    public function __construct(StudentRegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * API: Register Student
     * POST /api/register
     */
    public function register(RegisterStudentRequest $request): JsonResponse
    {
        try {
            $result = $this->service->registerStudent($request->validated());
            return response()->json($result, 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Student Login (Generates Sanctum API Token)
     * POST /api/login
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email credentials or password.'
            ], 401);
        }

        $token = $user->createToken('student-portal-token')->plainTextToken;
        $details = $this->service->getStudentDetails($user->id);

        return response()->json([
            'success'      => true,
            'message'      => 'Login successful.',
            'token'        => $token,
            'user'         => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'department' => $user->department,
            ],
            'registration' => $details['data'] ?? null
        ]);
    }

    /**
     * API: Get Current Authenticated Student Profile
     * GET /api/student/me
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $details = $this->service->getStudentDetails($user->id);

        return response()->json([
            'success'      => true,
            'user'         => $user,
            'registration' => $details['data'] ?? null
        ]);
    }

    /**
     * API: Update Student Details
     * POST /api/student/update
     */
    public function update(UpdateStudentDetailsRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            $result = $this->service->updateStudentDetails($user->id, $request->validated());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get Challan and Fee Details
     * GET /api/student/challan
     */
    public function challan(Request $request): JsonResponse
    {
        $user = $request->user();
        $challanData = $this->service->getChallanDetails($user->id);

        if (!$challanData['success']) {
            return response()->json($challanData, 404);
        }

        return response()->json($challanData);
    }

    /**
     * API: Process In-App Instant Online Payment
     * POST /api/student/pay-online
     */
    public function payOnline(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'gateway' => 'required|string|in:Card,EasyPaisa,JazzCash,1Link,Online Card',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $result = $this->service->payOnline($user->id, $request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * API: Submit Offline Bank Deposit Receipt
     * POST /api/student/upload-receipt
     */
    public function uploadReceipt(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'bank_name'      => 'required|string|max:100',
            'deposit_date'   => 'required|date',
            'transaction_id' => 'nullable|string|max:100',
            'receipt_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $result = $this->service->submitBankDepositReceipt(
                $user->id,
                $request->all(),
                $request->file('receipt_file')
            );
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * API: Logout (Revoke Current Token)
     * POST /api/logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out.'
        ]);
    }
}
