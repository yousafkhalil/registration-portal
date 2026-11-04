@extends('theme')

@section('title', 'Fee Payment Proof - ' . ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' | ' . ($convocationSettings->institution_name ?? 'Shahida Islam Medical Complex'))
@section('page_title', 'Fee Payment Proof & Voucher Upload')

@section('Content')

    <style>
        .payment-summary-card {
            background: #0f2533;
            border-top: 3px solid #0b4f6c;
            border-radius: 12px;
            color: #ffffff;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(15, 37, 51, 0.12);
            border-left: 1px solid #1b384c;
            border-right: 1px solid #1b384c;
            border-bottom: 1px solid #1b384c;
        }

        .payment-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #dde3e8;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-control,
        .form-select {
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 6px !important;
            padding: 9px 12px !important;
            font-size: 0.88rem !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0b4f6c !important;
            box-shadow: 0 0 0 3px rgba(11, 79, 108, 0.12) !important;
        }

        .receipt-slip {
            background: #fbfdfc;
            border: 2px dashed #17693f;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(23, 105, 63, 0.06);
        }

        .paid-stamp {
            border: 2px solid #17693f;
            color: #17693f;
            background: #e3f3ea;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 4px;
            display: inline-block;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
        }

        .pending-stamp {
            border: 2px solid #0b4f6c;
            color: #0b4f6c;
            background: #e3eff5;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 4px;
            display: inline-block;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .info-pill {
            background: #f8fafc;
            border: 1px solid #dde3e8;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .focal-card {
            background: #ffffff;
            border: 1px solid #dde3e8;
            border-radius: 10px;
            padding: 16px;
        }

        /* Mobile Responsive Enhancements */
        @media (max-width: 768px) {
            .payment-summary-card {
                padding: 16px;
                border-radius: 10px;
            }
            .payment-summary-card h4 {
                font-size: 1.15rem;
            }
            .payment-card {
                padding: 16px;
            }
            .form-control,
            .form-select {
                font-size: 16px !important; /* Prevents auto zoom in on iOS Safari */
                padding: 10px 12px !important;
            }
            .receipt-slip {
                padding: 16px;
            }
        }
    </style>

    <div class="container-fluid py-2">
        <!-- Top Summary Banner -->
        <div class="payment-summary-card">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-warning text-dark text-xxs fw-bold px-2 py-1">{{ strtoupper($convocationSettings->convocation_title ?? 'FIRST CONVOCATION 2026') }}</span>
                        <span class="badge bg-dark text-white text-xxs border border-secondary">{{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 Nov 2026' }}</span>
                    </div>
                    <h4 class="text-white fw-bold mb-1">{{ $registration->name }}</h4>
                    <div class="d-flex flex-wrap gap-2 text-xs opacity-9 mt-2">
                        <span><i class="fa fa-id-badge me-1"></i> Roll No: <strong>{{ $registration->roll_no }}</strong></span>
                        <span>&bull;</span>
                        <span><i class="fa fa-graduation-cap me-1"></i> {{ $registration->department }}</span>
                        <span>&bull;</span>
                        <span><i class="fa fa-file-invoice me-1"></i> Challan: <strong>{{ $registration->challan_no }}</strong></span>
                    </div>
                </div>

                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <small class="text-uppercase letter-spacing-1 fw-bold" style="color: #94abbc; font-size: 0.72rem;">Convocation Fee Payable</small>
                    <h2 class="text-white fw-bold mb-1">PKR {{ number_format($registration->fee_amount) }}</h2>
                    @if($registration->payment_status === 'paid')
                        <span class="badge px-3 py-2 fw-bold text-xs" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb;">
                            <i class="fa fa-check-circle me-1"></i> Paid & Verified by Super Admin
                        </span>
                    @elseif($registration->payment_status === 'pending_verification')
                        <span class="badge px-3 py-2 fw-bold text-xs" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">
                            <i class="fa fa-clock me-1"></i> Proof Uploaded (Pending Admin Approval)
                        </span>
                    @else
                        <span class="badge px-3 py-2 fw-bold text-xs" style="background: #fbf0d9; color: #8a5a0b; border: 1px solid #fae1b3;">
                            <i class="fa fa-exclamation-triangle me-1"></i> Fee Unpaid - Proof Required
                        </span>
                    @endif
                </div>
            </div>

            <!-- Fee Breakdown Pill -->
            <div class="mt-3 pt-3 border-top border-secondary text-xs d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <span>Graduate Fee ({{ $convocationSettings->gown_fee_notice ?? 'Including Gown' }}): <strong>PKR {{ number_format($convocationSettings->base_registration_fee ?? 15000) }}</strong></span>
                    <span class="mx-2">&bull;</span>
                    <span>Accompanying Guests: <strong>{{ (int)$registration->guests_count }} Guest(s)</strong> (&times; PKR {{ number_format($convocationSettings->guest_fee_per_person ?? 5000) }} = PKR {{ number_format((int)$registration->guests_count * ($convocationSettings->guest_fee_per_person ?? 5000)) }})</span>
                </div>
                <div>
                    Registration Deadline: <strong class="text-warning">{{ $convocationSettings->registration_deadline_formatted ?? '15 November 2026' }}</strong>
                </div>
            </div>
        </div>

        @if(session('message'))
            <div class="alert alert-success text-white shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                <i class="fa fa-check-circle me-2"></i> {{ session('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger text-white shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                <i class="fa fa-exclamation-circle me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Rejection Notice if any -->
        @if($registration->payment_status === 'unpaid' && !empty($registration->rejection_reason))
            <div class="alert alert-danger text-white shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-times-circle fs-4"></i>
                    <div>
                        <strong class="d-block">Previous Payment Proof Rejected by Admin:</strong>
                        <span>{{ $registration->rejection_reason }}</span>
                        <div class="mt-1 text-xs opacity-9">Please attach the correct stamped voucher or valid payment screenshot below.</div>
                    </div>
                </div>
            </div>
        @endif

        @if($registration->payment_status === 'paid')
            <!-- Paid Digital Receipt Slip -->
            <div class="receipt-slip mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="paid-stamp">PAID</div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Official Convocation Digital Payment Receipt</h5>
                                <small class="text-muted">Transaction Reference: <strong class="font-monospace text-dark">{{ $registration->transaction_id }}</strong></small>
                            </div>
                        </div>

                        <div class="row g-2 text-xs">
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Verified Fee Amount:</span>
                                <strong class="text-success fs-6 font-monospace">PKR {{ number_format($registration->paid_amount) }}</strong>
                                <small class="text-muted d-block">(Convocation Gown Included)</small>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Payment Method:</span>
                                <strong class="text-dark">{{ ucfirst(str_replace('_', ' ', $registration->payment_method)) }} ({{ $registration->bank_name }})</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Verification Date:</span>
                                <strong class="text-dark">{{ $registration->verified_at ? \Carbon\Carbon::parse($registration->verified_at)->format('d-M-Y h:i A') : now()->format('d-M-Y') }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block">Approved By:</span>
                                <strong class="text-primary">{{ $registration->verifier ? $registration->verifier->name : 'Super Admin' }}</strong>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <span class="text-muted d-block">Guest Entitlement:</span>
                                <strong class="text-dark">{{ (int)$registration->guests_count }} Guest(s) (Parents / Siblings) Included in Convocation Pass</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('student.challan') }}" class="btn btn-outline-dark mb-2 d-block">
                            <i class="fa fa-eye me-1"></i> View Bank Challan Voucher
                        </a>
                        <button type="button" onclick="window.print()" class="btn mb-0 d-block w-100 fw-bold" style="background: #17693f; color: #ffffff;">
                            <i class="fa fa-print me-1"></i> Print Official Receipt
                        </button>
                    </div>
                </div>
            </div>
        @else
            <!-- If Pending Verification Banner -->
            @if($registration->payment_status === 'pending_verification')
                <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #0b4f6c !important; border-radius: 10px; border: 1px solid #dde3e8;">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="pending-stamp">PENDING REVIEW</div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Your Payment Proof is Under Review</h5>
                                    <p class="text-secondary text-xs mb-0">
                                        Submitted on <strong>{{ $registration->paid_at ? \Carbon\Carbon::parse($registration->paid_at)->format('d M, Y') : now()->format('d M, Y') }}</strong> via <strong>{{ $registration->bank_name }}</strong> (Ref: <code>{{ $registration->transaction_id }}</code>).
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if($registration->receipt_path)
                                    <a href="{{ asset('storage/' . $registration->receipt_path) }}" target="_blank" class="btn btn-sm mb-0" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">
                                        <i class="fa fa-image me-1"></i> View Uploaded Proof Slip
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="alert alert-light border mt-3 mb-0 text-xs text-secondary" style="background: #f8fafc; border-color: #dde3e8 !important;">
                            <i class="fa fa-info-circle me-1" style="color: #0b4f6c;"></i>
                            <strong>Convocation Policy Notice:</strong> Fee status is updated <strong>strictly by Super Admin</strong> after verifying your deposit slip/screenshot. Your status will update to Paid once approved.
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Payment Form (Step 1: Bank Instructions; Step 2: Upload Proof) -->
            <div class="row g-4">
                <!-- Column 1: Bank Payment Instructions -->
                <div class="col-lg-5">
                    <div class="payment-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="material-symbols-rounded align-middle me-1" style="color: #0b4f6c;">account_balance</i>
                                Step 1: Deposit Fee
                            </h5>
                            <span class="badge" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">Bank Details</span>
                        </div>

                        <p class="text-xs text-secondary mb-3">
                            You can pay through <strong>Cash Challan</strong> at any {{ $convocationSettings->bank_name ?? 'Bank of Punjab (BOP)' }} branch, or via <strong>Online Mobile Banking / 1Link / Raast</strong> using the account details below:
                        </p>

                        <!-- Bank Details Info Box -->
                        <div class="info-pill mb-3">
                            <div class="row g-2 text-xs">
                                <div class="col-12">
                                    <small class="text-muted d-block">Designated Bank</small>
                                    <strong class="text-dark fs-6">{{ $convocationSettings->bank_name ?? 'The Bank of Punjab (BOP)' }} {{ $convocationSettings->secondary_bank ? '/ ' . $convocationSettings->secondary_bank : '' }}</strong>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Account Title</small>
                                    <strong class="text-dark">{{ $convocationSettings->account_title ?? 'Shahida Islam Medical Complex - Convocation Fund' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Account Number</small>
                                    <strong class="font-monospace text-primary">{{ $convocationSettings->account_number ?? '00100458920001' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">IBAN (Raast / 1Link)</small>
                                    <strong class="font-monospace text-dark text-xxs">{{ $convocationSettings->iban ?? 'PK36BOPB00100458920001' }}</strong>
                                </div>
                                @if(!empty($convocationSettings->bank_branch))
                                <div class="col-12">
                                    <small class="text-muted d-block">Branch Details</small>
                                    <span class="text-dark text-xxs">{{ $convocationSettings->bank_branch }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button to View/Print Challan -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('student.challan') }}" class="btn btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                <i class="fa fa-print"></i>
                                <span>View & Print 3-Part Bank Challan</span>
                            </a>
                        </div>

                        <!-- Gown & Policy Note -->
                        <div class="mt-4 pt-3 border-top text-xs text-secondary">
                            <div class="mb-2">
                                <i class="fa fa-graduation-cap text-primary me-1"></i>
                                <strong>Convocation Gown:</strong> {{ $convocationSettings->gown_fee_notice ?? 'Included in your registration fee.' }}
                            </div>
                            <div>
                                <i class="fa fa-users text-warning me-1"></i>
                                <strong>Guest Restriction:</strong> {{ $convocationSettings->guest_eligibility_notice ?? 'Strictly Parents and Siblings only' }} (Max {{ $convocationSettings->max_guests_allowed ?? 2 }}).
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Upload Proof Form -->
                <div class="col-lg-7">
                    <div class="payment-card h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="material-symbols-rounded align-middle me-1" style="color: #0b4f6c;">upload_file</i>
                                Step 2: Attach Paid Voucher / Screenshot
                            </h5>
                            <span class="badge" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">Verification Form</span>
                        </div>

                        <p class="text-xs text-secondary mb-3">
                            After depositing the fee in the bank or completing an online bank transfer, attach the bank-stamped challan receipt or online transfer screenshot:
                        </p>

                        <form method="POST" action="{{ route('student.uploadReceipt') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Payment Channel -->
                            <div class="mb-3">
                                <label class="form-label text-xs fw-bold text-secondary mb-1">
                                    Payment Method / Bank Deposited In <span class="text-danger">*</span>
                                </label>
                                <select name="bank_name" class="form-select" required>
                                    <option value="The Bank of Punjab (BOP) - Cash Challan">The Bank of Punjab (BOP) - Cash Challan</option>
                                    <option value="Habib Bank Limited (HBL) - Cash Challan">Habib Bank Limited (HBL) - Cash Challan</option>
                                    <option value="Online Banking App / 1Link IBFT">Online Banking App (1Link IBFT Transfer)</option>
                                    <option value="Raast Instant Payment">Raast Instant Payment</option>
                                    <option value="EasyPaisa Mobile App">EasyPaisa Mobile App Transfer</option>
                                    <option value="JazzCash Mobile App">JazzCash Mobile App Transfer</option>
                                    <option value="Other Bank Transfer">Other Bank / Transfer Channel</option>
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- Deposit Date -->
                                <div class="col-md-6">
                                    <label class="form-label text-xs fw-bold text-secondary mb-1">
                                        Deposit / Payment Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="deposit_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                </div>

                                <!-- Transaction Ref -->
                                <div class="col-md-6">
                                    <label class="form-label text-xs fw-bold text-secondary mb-1">
                                        Bank Scroll No / Transaction ID / Ref <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="transaction_id" class="form-control font-monospace" placeholder="e.g. BOP-58491 or TRX-884920" required>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label class="form-label text-xs fw-bold text-secondary mb-1">
                                    Upload Stamped Voucher / Payment Screenshot <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="receipt_file" class="form-control" accept="image/*,application/pdf" required>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <small class="text-muted text-xxs">Accepted Formats: JPG, PNG, PDF (Max 5MB)</small>
                                    @if($registration->receipt_path)
                                        <small class="text-info text-xxs">
                                            <i class="fa fa-paperclip"></i> Current file already on record
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="mb-3">
                                <label class="form-label text-xs fw-bold text-secondary mb-1">
                                    Student Remarks (Optional)
                                </label>
                                <input type="text" name="remarks" class="form-control" placeholder="e.g. Deposited at BOP Lodhran branch / Raast from personal account">
                            </div>

                            <!-- Security Alert -->
                            <div class="alert alert-light border p-2 mb-3 text-xxs text-secondary">
                                <i class="fa fa-lock text-primary me-1"></i>
                                Status update permission is restricted to <strong>Super Admin</strong>. Once uploaded, your receipt will be reviewed by the University Administration.
                            </div>

                            <button type="submit" class="btn w-100 py-3 mb-0 fw-bold text-white" style="background: #0b4f6c;">
                                <i class="fa fa-paper-plane me-1"></i> Attach & Submit Payment Proof for Admin Approval
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Focal Persons Helpline Cards -->
        @if(isset($convocationFocalPersons) && $convocationFocalPersons->count() > 0)
        <div class="focal-card mt-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <h6 class="fw-bold text-dark mb-1 text-xs text-uppercase">
                        <i class="fa fa-headset text-primary me-1"></i> Convocation Focal Persons
                    </h6>
                    <small class="text-muted text-xxs">For fee verification, challan, or gown queries</small>
                </div>
                <div class="col-md-9">
                    <div class="row g-2">
                        @foreach($convocationFocalPersons as $focal)
                        <div class="col-sm-6">
                            <div class="p-2 border rounded bg-light text-xs">
                                <strong class="d-block text-dark">{{ $focal->name }} <span class="text-muted fw-normal">({{ $focal->designation }})</span></strong>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $focal->mobile) }}" class="text-primary text-decoration-none fw-bold font-monospace">
                                    <i class="fa fa-phone-alt me-1"></i> {{ $focal->mobile }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection
