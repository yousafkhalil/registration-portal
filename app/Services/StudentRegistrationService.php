<?php

namespace App\Services;

use App\Models\User;
use App\Models\StudentRegistration;
use App\Models\ConvocationSetting;
use App\Repositories\StudentRegistrationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentRegistrationService
{
    protected StudentRegistrationRepository $repository;
    protected UserRepository $userRepository;

    public function __construct(
        StudentRegistrationRepository $repository,
        UserRepository $userRepository
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * Build combined address string from structured fields
     */
    public function buildCombinedAddress(array $data): ?string
    {
        $parts = [];
        if (!empty($data['house_no'])) {
            $parts[] = 'House/Flat: ' . trim($data['house_no']);
        }
        if (!empty($data['street_address'])) {
            $parts[] = 'Street/Sector: ' . trim($data['street_address']);
        }
        if (!empty($data['area'])) {
            $parts[] = 'Area: ' . trim($data['area']);
        }
        if (!empty($data['city'])) {
            $parts[] = trim($data['city']);
        }
        if (!empty($data['province'])) {
            $parts[] = trim($data['province']);
        }

        if (!empty($parts)) {
            return implode(', ', $parts);
        }

        return !empty($data['address']) ? trim($data['address']) : null;
    }

    /**
     * Build readable summary from profs position JSON
     */
    public function buildPositionsSummary($positionsData, ?string $fallback = null): ?string
    {
        if (is_string($positionsData)) {
            $decoded = json_decode($positionsData, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $positionsData = $decoded;
            }
        }

        if (!is_array($positionsData) || empty($positionsData)) {
            return $fallback;
        }

        $summaryParts = [];
        foreach ($positionsData as $item) {
            $profName = $item['prof'] ?? '';
            $position = $item['position'] ?? null;
            $subject  = !empty($item['subject']) ? trim($item['subject']) : null;

            if (empty($position) && !empty($item['overall_first'])) {
                $position = '1st Position';
            }

            $desc = [];
            if (!empty($position)) {
                $desc[] = $position;
            }
            if (!empty($subject)) {
                $desc[] = 'Subject: ' . $subject;
            }

            if (!empty($profName) && !empty($desc)) {
                $summaryParts[] = $profName . ' (' . implode(', ', $desc) . ')';
            }
        }

        return !empty($summaryParts) ? implode('; ', $summaryParts) : $fallback;
    }

    /**
     * Register a new student: creates records in users and student_registrations tables
     */
    public function registerStudent(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // 1. Sanitize CNIC and Contacts
            $cleanCnic      = !empty($data['cnic']) ? preg_replace('/[^0-9]/', '', $data['cnic']) : null;
            $cleanContact   = !empty($data['contact_no']) ? str_replace(['-', ' '], '', $data['contact_no']) : null;
            $cleanEmergency = !empty($data['emergency_contact_no']) ? str_replace(['-', ' '], '', $data['emergency_contact_no']) : null;

            // 2. Prepare Guest Info
            $guestsCount   = isset($data['guests_count']) ? (int)$data['guests_count'] : 0;
            $guest1Name    = ($guestsCount >= 1) ? ($data['guest1_name'] ?? null) : null;
            $guest1Cnic    = ($guestsCount >= 1 && !empty($data['guest1_cnic'])) ? preg_replace('/[^0-9]/', '', $data['guest1_cnic']) : null;
            $guest1Contact = ($guestsCount >= 1 && !empty($data['guest1_contact_no'])) ? str_replace(['-', ' '], '', $data['guest1_contact_no']) : null;

            $guest2Name    = ($guestsCount >= 2) ? ($data['guest2_name'] ?? null) : null;
            $guest2Cnic    = ($guestsCount >= 2 && !empty($data['guest2_cnic'])) ? preg_replace('/[^0-9]/', '', $data['guest2_cnic']) : null;
            $guest2Contact = ($guestsCount >= 2 && !empty($data['guest2_contact_no'])) ? str_replace(['-', ' '], '', $data['guest2_contact_no']) : null;

            // 3. Prepare Prof Positions JSON & Summary
            $positionsData = $data['positions_data'] ?? null;
            if (is_string($positionsData)) {
                $decoded = json_decode($positionsData, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $positionsData = $decoded;
                }
            }
            $positionsSummary = $this->buildPositionsSummary($positionsData, $data['positions_summary'] ?? null);

            // 4. Combined Address
            $fullAddress = $this->buildCombinedAddress($data);

            // 5. Fee calculation: dynamically from database settings table
            $convSetting = ConvocationSetting::current();
            $feeAmount   = StudentRegistration::calculateFee($guestsCount);
            $challanNo   = StudentRegistration::generateChallanNo(mt_rand(10000, 99999));
            $dueDate     = $convSetting->registration_deadline ? $convSetting->registration_deadline->format('Y-m-d') : '2026-11-15';

            // 6. Create User record in users table
            $user = User::create([
                'name'                 => $data['name'],
                'email'                => strtolower(trim($data['email'])),
                'password'             => Hash::make($data['password']),
                'department'           => $data['department'] ?? null,
                'contact_no'           => $cleanContact,
                'emergency_contact_no' => $cleanEmergency,
                'cnic'                 => $cleanCnic,
                'address'              => $fullAddress,
                'role'                 => 'student',
                'active'               => 'Y',
            ]);

            // 7. Prepare Registration Profile Data
            $regData = [
                'user_id'              => $user->id,
                'roll_no'              => $data['roll_no'],
                'name'                 => $data['name'],
                'father_name'          => $data['father_name'] ?? null,
                'department'           => $data['department'] ?? null,
                'session'              => $data['session'] ?? null, // Admission Year
                'class'                => $data['class'] ?? null,   // Graduation Year
                'uhs_registration_no'  => $data['uhs_registration_no'] ?? null,
                'council_type'         => $data['council_type'] ?? null,
                'pmdc_registration_no' => $data['pmdc_registration_no'] ?? null,
                'positions_data'       => $positionsData,
                'positions_summary'    => $positionsSummary,
                'contact_no'           => $cleanContact,
                'emergency_contact_no' => $cleanEmergency,
                'guests_count'         => $guestsCount,
                'guest1_name'          => $guest1Name,
                'guest1_cnic'          => $guest1Cnic,
                'guest1_contact_no'    => $guest1Contact,
                'guest2_name'          => $guest2Name,
                'guest2_cnic'          => $guest2Cnic,
                'guest2_contact_no'    => $guest2Contact,
                'email'                => strtolower(trim($data['email'])),
                'cnic'                 => $cleanCnic,
                'house_no'             => $data['house_no'] ?? null,
                'street_address'       => $data['street_address'] ?? null,
                'area'                 => $data['area'] ?? null,
                'city'                 => $data['city'] ?? null,
                'province'             => $data['province'] ?? null,
                'address'              => $fullAddress,
                'status'               => 'active',
                'challan_no'           => $challanNo,
                'fee_amount'           => $feeAmount,
                'payment_status'       => 'unpaid',
                'due_date'             => $dueDate,
            ];

            $registration = $this->repository->save($regData);

            // Generate token for API use
            $token = $user->createToken('student-portal-token')->plainTextToken;

            return [
                'success'      => true,
                'message'      => 'Student registered successfully.',
                'token'        => $token,
                'redirect_url' => url('/student/challan'),
                'user'         => [
                    'id'         => $user->id,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'department' => $user->department,
                ],
                'registration' => $registration
            ];
        });
    }

    /**
     * Retrieve student details by user ID
     */
    public function getStudentDetails($userId): array
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found.'
            ];
        }

        $registration = $this->repository->findByUserId($userId);

        if (!$registration) {
            $registration = new StudentRegistration([
                'user_id'              => $user->id,
                'name'                 => $user->name,
                'email'                => $user->email,
                'department'           => $user->department,
                'contact_no'           => $user->contact_no,
                'emergency_contact_no' => $user->emergency_contact_no,
                'cnic'                 => $user->cnic,
                'address'              => $user->address,
                'guests_count'         => 0,
                'fee_amount'           => 15000,
                'challan_no'           => StudentRegistration::generateChallanNo($user->id),
                'payment_status'       => 'unpaid',
                'due_date'             => now()->addDays(15)->format('Y-m-d'),
            ]);
        }

        return [
            'success' => true,
            'user'    => $user,
            'data'    => $registration
        ];
    }

    /**
     * Update student details (atomic sync in users & student_registrations)
     */
    public function updateStudentDetails($userId, array $data): array
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = User::findOrFail($userId);
            $existingReg = $this->repository->findByUserId($userId);

            // Clean CNIC & Contacts
            $cleanCnic      = !empty($data['cnic']) ? preg_replace('/[^0-9]/', '', $data['cnic']) : null;
            $cleanContact   = !empty($data['contact_no']) ? str_replace(['-', ' '], '', $data['contact_no']) : null;
            $cleanEmergency = !empty($data['emergency_contact_no']) ? str_replace(['-', ' '], '', $data['emergency_contact_no']) : null;

            // Prepare Guest Info
            $guestsCount   = isset($data['guests_count']) ? (int)$data['guests_count'] : 0;
            $guest1Name    = ($guestsCount >= 1) ? ($data['guest1_name'] ?? null) : null;
            $guest1Cnic    = ($guestsCount >= 1 && !empty($data['guest1_cnic'])) ? preg_replace('/[^0-9]/', '', $data['guest1_cnic']) : null;
            $guest1Contact = ($guestsCount >= 1 && !empty($data['guest1_contact_no'])) ? str_replace(['-', ' '], '', $data['guest1_contact_no']) : null;

            $guest2Name    = ($guestsCount >= 2) ? ($data['guest2_name'] ?? null) : null;
            $guest2Cnic    = ($guestsCount >= 2 && !empty($data['guest2_cnic'])) ? preg_replace('/[^0-9]/', '', $data['guest2_cnic']) : null;
            $guest2Contact = ($guestsCount >= 2 && !empty($data['guest2_contact_no'])) ? str_replace(['-', ' '], '', $data['guest2_contact_no']) : null;

            // Prepare Prof Positions JSON & Summary
            $positionsData = $data['positions_data'] ?? null;
            if (is_string($positionsData)) {
                $decoded = json_decode($positionsData, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $positionsData = $decoded;
                }
            }
            $positionsSummary = $this->buildPositionsSummary($positionsData, $data['positions_summary'] ?? null);

            // Combined Address
            $fullAddress = $this->buildCombinedAddress($data);

            // Fee recalculation: If not already paid, update fee according to guest count
            $feeAmount = ($existingReg && $existingReg->payment_status === 'paid')
                ? $existingReg->fee_amount
                : StudentRegistration::calculateFee($guestsCount);

            $challanNo = ($existingReg && !empty($existingReg->challan_no))
                ? $existingReg->challan_no
                : StudentRegistration::generateChallanNo($userId);

            $dueDate = ($existingReg && !empty($existingReg->due_date))
                ? $existingReg->due_date
                : '2026-11-15';

            // Update user basic profile
            $user->name                 = $data['name'];
            if (!empty($data['email'])) {
                $user->email = strtolower(trim($data['email']));
            }
            if (!empty($data['department'])) {
                $user->department = $data['department'];
            }
            $user->contact_no           = $cleanContact;
            $user->emergency_contact_no = $cleanEmergency;
            $user->cnic                 = $cleanCnic;
            $user->address              = $fullAddress;
            $user->save();

            // Prepare registration update array
            $updateData = [
                'roll_no'              => $data['roll_no'],
                'name'                 => $data['name'],
                'father_name'          => $data['father_name'] ?? null,
                'department'           => $data['department'] ?? null,
                'session'              => $data['session'] ?? null, // Admission Year
                'class'                => $data['class'] ?? null,   // Graduation Year
                'uhs_registration_no'  => $data['uhs_registration_no'] ?? null,
                'council_type'         => $data['council_type'] ?? null,
                'pmdc_registration_no' => $data['pmdc_registration_no'] ?? null,
                'positions_data'       => $positionsData,
                'positions_summary'    => $positionsSummary,
                'contact_no'           => $cleanContact,
                'emergency_contact_no' => $cleanEmergency,
                'guests_count'         => $guestsCount,
                'guest1_name'          => $guest1Name,
                'guest1_cnic'          => $guest1Cnic,
                'guest1_contact_no'    => $guest1Contact,
                'guest2_name'          => $guest2Name,
                'guest2_cnic'          => $guest2Cnic,
                'guest2_contact_no'    => $guest2Contact,
                'email'                => !empty($data['email']) ? strtolower(trim($data['email'])) : $user->email,
                'cnic'                 => $cleanCnic,
                'house_no'             => $data['house_no'] ?? null,
                'street_address'       => $data['street_address'] ?? null,
                'area'                 => $data['area'] ?? null,
                'city'                 => $data['city'] ?? null,
                'province'             => $data['province'] ?? null,
                'address'              => $fullAddress,
                'fee_amount'           => $feeAmount,
                'challan_no'           => $challanNo,
                'due_date'             => $dueDate,
            ];

            $registration = $this->repository->updateOrCreateByUserId($userId, $updateData);

            return [
                'success' => true,
                'message' => 'Student registration details successfully updated.',
                'data'    => $registration,
                'user'    => $user
            ];
        });
    }

    /**
     * Get Challan and Fee details for printable voucher
     */
    public function getChallanDetails($userId): array
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return ['success' => false, 'message' => 'Student not found.'];
        }

        $reg = $this->repository->findByUserId($userId);
        if (!$reg) {
            return ['success' => false, 'message' => 'Registration details not found.'];
        }

        $convSetting = ConvocationSetting::current();

        // Ensure challan number & due date exist
        if (empty($reg->challan_no)) {
            $reg->challan_no = StudentRegistration::generateChallanNo($user->id);
            $reg->fee_amount = StudentRegistration::calculateFee($reg->guests_count);
            $reg->due_date   = $convSetting->registration_deadline ? $convSetting->registration_deadline->format('Y-m-d') : '2026-11-15';
            $reg->save();
        }

        $bankInfo = [
            'bank_name'      => $convSetting->bank_name ?? 'The Bank of Punjab (BOP)',
            'secondary_bank' => $convSetting->secondary_bank ?? 'Habib Bank Limited (HBL)',
            'account_title'  => $convSetting->account_title ?? 'Shahida Islam Medical Complex - Convocation Fund',
            'account_number' => $convSetting->account_number ?? '00100458920001',
            'iban'           => $convSetting->iban ?? 'PK36BOPB00100458920001',
            'branch'         => $convSetting->branch_info ?? 'Any Online Branch Nationwide or Raast / 1Link',
        ];

        return [
            'success'      => true,
            'user'         => $user,
            'registration' => $reg,
            'breakdown'    => $reg->fee_breakdown,
            'bank'         => $bankInfo,
        ];
    }

    /**
     * Process In-App Instant Online Payment
     */
    public function payOnline($userId, array $paymentData): array
    {
        $reg = $this->repository->findByUserId($userId);
        if (!$reg) {
            return ['success' => false, 'message' => 'Registration record not found.'];
        }

        if ($reg->payment_status === 'paid') {
            return [
                'success' => true,
                'message' => 'Fee has already been paid.',
                'data'    => $reg
            ];
        }

        $gateway = $paymentData['gateway'] ?? 'Online Card';
        $txnId = 'TXN-' . strtoupper(Str::random(10));

        // Note: Students cannot directly mark payment as paid; it goes to pending_verification for Super Admin approval
        $reg->payment_status  = 'pending_verification';
        $reg->payment_method  = 'online';
        $reg->paid_amount     = $reg->fee_amount;
        $reg->paid_at         = now();
        $reg->bank_name       = $gateway;
        $reg->transaction_id  = $txnId;
        $reg->payment_remarks = 'Online payment initiated via ' . $gateway . ' by student. Awaiting admin approval.';
        $reg->save();

        return [
            'success'        => true,
            'message'        => 'Online payment reference ' . $txnId . ' recorded. Payment is currently pending Super Admin verification.',
            'transaction_id' => $txnId,
            'data'           => $reg
        ];
    }

    /**
     * Submit Bank Deposit Receipt / Online Screenshot Proof (Challan or App Screenshot)
     */
    public function submitBankDepositReceipt($userId, array $data, $receiptFile = null): array
    {
        $reg = $this->repository->findByUserId($userId);
        if (!$reg) {
            return ['success' => false, 'message' => 'Registration record not found.'];
        }

        $receiptPath = null;
        if ($receiptFile && $receiptFile->isValid()) {
            $filename = 'receipt_' . $userId . '_' . time() . '.' . $receiptFile->getClientOriginalExtension();
            $receiptPath = $receiptFile->storeAs('receipts', $filename, 'public');
        }

        $reg->payment_status  = 'pending_verification';
        $reg->payment_method  = $data['payment_method'] ?? 'bank_deposit';
        $reg->paid_amount     = $reg->fee_amount;
        $reg->paid_at         = !empty($data['deposit_date']) ? $data['deposit_date'] : now();
        $reg->bank_name       = $data['bank_name'] ?? 'Bank of Punjab';
        $reg->transaction_id  = $data['transaction_id'] ?? ('DEP-' . strtoupper(Str::random(8)));
        if ($receiptPath) {
            $reg->receipt_path = $receiptPath;
        }
        $reg->payment_remarks = $data['remarks'] ?? 'Payment proof submitted by student for verification.';
        $reg->rejection_reason = null; // Clear previous rejection reason upon new upload
        $reg->save();

        return [
            'success' => true,
            'message' => 'Payment proof attached and submitted successfully! Your payment is pending Admin verification.',
            'data'    => $reg
        ];
    }

    /**
     * SUPER ADMIN: Get Dashboard Statistics
     */
    public function getAdminDashboardStats(): array
    {
        $totalStudents = StudentRegistration::count();
        $pendingVerifications = StudentRegistration::where('payment_status', 'pending_verification')->count();
        $paidStudents = StudentRegistration::where('payment_status', 'paid')->count();
        $unpaidStudents = StudentRegistration::where('payment_status', 'unpaid')->count();
        $totalCollected = StudentRegistration::where('payment_status', 'paid')->sum('paid_amount');
        $totalExpectedFee = StudentRegistration::sum('fee_amount');

        $recentPending = StudentRegistration::with('user')
            ->where('payment_status', 'pending_verification')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return [
            'total_students'        => $totalStudents,
            'pending_verifications' => $pendingVerifications,
            'paid_students'         => $paidStudents,
            'unpaid_students'       => $unpaidStudents,
            'total_collected'       => (float)$totalCollected,
            'total_expected'        => (float)$totalExpectedFee,
            'recent_pending'        => $recentPending,
        ];
    }

    /**
     * SUPER ADMIN: Get filterable list of student registrations
     */
    public function getAdminStudentsList(array $filters = [])
    {
        $query = StudentRegistration::with(['user', 'verifier'])->orderBy('id', 'desc');

        if (!empty($filters['status']) && in_array($filters['status'], ['pending_verification', 'paid', 'unpaid'])) {
            $query->where('payment_status', $filters['status']);
        }

        if (!empty($filters['department'])) {
            $query->where('department', $filters['department']);
        }

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('roll_no', 'ilike', "%{$search}%")
                  ->orWhere('challan_no', 'ilike', "%{$search}%")
                  ->orWhere('cnic', 'like', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhere('transaction_id', 'ilike', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 20);
    }

    /**
     * SUPER ADMIN: Find single student registration by ID
     */
    public function getRegistrationById(int $id): ?StudentRegistration
    {
        return StudentRegistration::with(['user', 'verifier'])->find($id);
    }

    /**
     * SUPER ADMIN: Approve student payment (Super Rights)
     */
    public function approvePayment(int $registrationId, int $adminId, ?string $adminNotes = null): array
    {
        $reg = StudentRegistration::findOrFail($registrationId);

        $reg->payment_status      = 'paid';
        $reg->verified_by_user_id = $adminId;
        $reg->verified_at         = now();
        $reg->paid_amount         = $reg->fee_amount;
        if (empty($reg->paid_at)) {
            $reg->paid_at = now();
        }
        $reg->rejection_reason    = null; // clear any previous rejection
        if ($adminNotes) {
            $reg->admin_notes     = $adminNotes;
        }
        $reg->save();

        return [
            'success' => true,
            'message' => "Payment for {$reg->name} (Challan #{$reg->challan_no}) has been approved and marked as PAID.",
            'data'    => $reg
        ];
    }

    /**
     * SUPER ADMIN: Reject student payment with reason (Super Rights)
     */
    public function rejectPayment(int $registrationId, int $adminId, string $rejectionReason, ?string $adminNotes = null): array
    {
        $reg = StudentRegistration::findOrFail($registrationId);

        $reg->payment_status      = 'unpaid';
        $reg->verified_by_user_id = $adminId;
        $reg->verified_at         = now();
        $reg->rejection_reason    = $rejectionReason;
        if ($adminNotes) {
            $reg->admin_notes     = $adminNotes;
        }
        $reg->save();

        return [
            'success' => true,
            'message' => "Payment proof for {$reg->name} rejected. Status reverted to UNPAID.",
            'data'    => $reg
        ];
    }

    /**
     * SUPER ADMIN: Permission / Fee Structure Override Form
     */
    public function updateFeeStructure(int $registrationId, int $adminId, array $data): array
    {
        $reg = StudentRegistration::findOrFail($registrationId);

        if (isset($data['fee_amount'])) {
            $reg->fee_amount = (float)$data['fee_amount'];
        }

        if (isset($data['due_date'])) {
            $reg->due_date = $data['due_date'];
        }

        if (isset($data['guests_count'])) {
            $reg->guests_count = (int)$data['guests_count'];
        }

        if (isset($data['payment_status']) && in_array($data['payment_status'], ['paid', 'unpaid', 'pending_verification'])) {
            $prevStatus = $reg->payment_status;
            $reg->payment_status = $data['payment_status'];

            if ($data['payment_status'] === 'paid') {
                $reg->verified_by_user_id = $adminId;
                $reg->verified_at         = now();
                $reg->paid_amount         = $reg->fee_amount;
                if (empty($reg->paid_at)) {
                    $reg->paid_at = now();
                }
                $reg->rejection_reason    = null;
            } elseif ($data['payment_status'] === 'unpaid') {
                if (!empty($data['rejection_reason'])) {
                    $reg->rejection_reason = $data['rejection_reason'];
                }
            }
        }

        if (!empty($data['admin_notes'])) {
            $reg->admin_notes = $data['admin_notes'];
        }

        $reg->verified_by_user_id = $adminId;
        $reg->save();

        return [
            'success' => true,
            'message' => "Fee structure & permissions for {$reg->name} successfully updated by Admin.",
            'data'    => $reg
        ];
    }
}
