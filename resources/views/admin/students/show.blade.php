@extends('theme')

@section('title', 'Graduate Dossier & Fee Permission - ' . $registration->name . ' | ' . ($convocationSettings->convocation_title ?? 'SIMC First Convocation 2026'))
@section('page_title', ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' &bull; Super Admin Permission & Fee Control')

@section('Content')

    <style>
        .admin-box {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #dde3e8;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .permission-card {
            background: #0f2533;
            border-top: 3px solid #0b4f6c;
            border-radius: 10px;
            color: #ffffff;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(15, 37, 51, 0.12);
            border-left: 1px solid #1a3c52;
            border-right: 1px solid #1a3c52;
            border-bottom: 1px solid #1a3c52;
        }

        .label-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 2px;
        }

        .data-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }

        .receipt-preview-box {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            padding: 12px;
            background: #f8fafc;
            text-align: center;
        }

        .receipt-preview-img {
            max-height: 400px;
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-box, .permission-card {
                padding: 16px;
                border-radius: 12px;
            }
            .data-value {
                font-size: 0.85rem;
                word-break: break-word;
            }
        }
    </style>

    <div class="container-fluid py-2">
        <!-- Top Nav Breadcrumb -->
        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-2 mb-3">
            <a href="{{ route('admin.students') }}" class="btn btn-sm btn-outline-secondary mb-0 text-center">
                <i class="fa fa-arrow-left me-1"></i> Back to Students List
            </a>
            <div>
                <a href="{{ route('student.challan') }}?student_id={{ $registration->user_id }}" target="_blank" class="btn btn-sm btn-outline-dark mb-0 w-100 text-center">
                    <i class="fa fa-print me-1"></i> Print Student Challan
                </a>
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

        <div class="row g-4">
            <!-- Left Column: Student Academic Dossier & Payment Proof -->
            <div class="col-lg-7">
                <!-- Academic & Personal Profile -->
                <div class="admin-box">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div>
                            <span class="badge text-xxs mb-1" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">{{ $registration->department }}</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $registration->name }}</h4>
                            <small class="text-muted text-xs">Father's Name: {{ $registration->father_name ?? 'N/A' }}</small>
                        </div>
                        <div class="text-end">
                            @if($registration->payment_status === 'paid')
                                <span class="badge px-3 py-2 text-xs fw-bold" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb;">
                                    PAID & VERIFIED
                                </span>
                            @elseif($registration->payment_status === 'pending_verification')
                                <span class="badge px-3 py-2 text-xs fw-bold" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">
                                    PENDING REVIEW
                                </span>
                            @else
                                <span class="badge px-3 py-2 text-xs fw-bold" style="background: #fbf0d9; color: #8a5a0b; border: 1px solid #fae1b3;">
                                    UNPAID
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="label-title">Roll Number</div>
                            <div class="data-value font-monospace">{{ $registration->roll_no }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">CNIC Number</div>
                            <div class="data-value font-monospace">{{ $registration->cnic_formatted ?? $registration->cnic }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">UHS Registration No</div>
                            <div class="data-value font-monospace">{{ $registration->uhs_registration_no ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">Council Registration</div>
                            <div class="data-value font-monospace">{{ $registration->council_type }}: {{ $registration->pmdc_registration_no ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">Admission Session</div>
                            <div class="data-value">{{ $registration->session ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">Graduation Year / Class</div>
                            <div class="data-value">{{ $registration->class ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">Primary Contact</div>
                            <div class="data-value">{{ $registration->contact_no }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="label-title">Emergency Contact</div>
                            <div class="data-value">{{ $registration->emergency_contact_no ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="label-title">Email Address</div>
                            <div class="data-value">{{ $registration->email }}</div>
                        </div>
                        <div class="col-12">
                            <div class="label-title">Structured Postal Address</div>
                            <div class="data-value">{{ $registration->address ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Prof Positions Section -->
                    @if(!empty($registration->positions_data) || !empty($registration->positions_summary))
                        <div class="pt-3 border-top mt-3">
                            <h6 class="fw-bold text-dark text-xs text-uppercase mb-2">
                                <i class="fa fa-award text-warning me-1"></i> Academic Positions
                            </h6>
                            <div class="alert alert-light border p-2 text-xs mb-0 text-dark">
                                @if($registration->positions_summary === '0' || empty($registration->positions_summary))
                                    <span class="text-muted"><i class="fa fa-info-circle me-1"></i> None (0)</span>
                                @else
                                    {{ $registration->positions_summary }}
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Guest Details Section -->
                    <div class="pt-3 border-top mt-3">
                        <h6 class="fw-bold text-dark text-xs text-uppercase mb-2">
                            <i class="fa fa-users text-primary me-1"></i> Accompanying Guests ({{ (int)$registration->guests_count }} Allowed)
                        </h6>

                        @if((int)$registration->guests_count === 0)
                            <p class="text-xs text-muted mb-0">Student is attending convocation alone (no accompanying guests).</p>
                        @else
                            <div class="row g-2">
                                @if((int)$registration->guests_count >= 1 && !empty($registration->guest1_name))
                                    <div class="col-sm-6">
                                        <div class="p-2 border rounded bg-light text-xs">
                                            <strong class="d-block text-dark">Guest 1: {{ $registration->guest1_name }}</strong>
                                            <span class="text-muted d-block">CNIC: {{ $registration->guest1_cnic_formatted ?? $registration->guest1_cnic }}</span>
                                            <span class="text-muted d-block">Phone: {{ $registration->guest1_contact_no }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if((int)$registration->guests_count >= 2 && !empty($registration->guest2_name))
                                    <div class="col-sm-6">
                                        <div class="p-2 border rounded bg-light text-xs">
                                            <strong class="d-block text-dark">Guest 2: {{ $registration->guest2_name }}</strong>
                                            <span class="text-muted d-block">CNIC: {{ $registration->guest2_cnic_formatted ?? $registration->guest2_cnic }}</span>
                                            <span class="text-muted d-block">Phone: {{ $registration->guest2_contact_no }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Proof & Uploaded Slip Section -->
                <div class="admin-box">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="material-symbols-rounded text-primary me-1 align-middle">receipt</i>
                            Payment Proof Voucher / Screenshot
                        </h5>
                        @if($registration->receipt_path)
                            <a href="{{ asset('storage/' . $registration->receipt_path) }}" target="_blank" class="btn btn-xs btn-outline-primary mb-0">
                                <i class="fa fa-external-link-alt me-1"></i> Open Original
                            </a>
                        @endif
                    </div>

                    <div class="row g-2 mb-3 text-xs">
                        <div class="col-sm-4">
                            <span class="text-muted d-block">Bank Deposited In:</span>
                            <strong class="text-dark">{{ $registration->bank_name ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block">Transaction / Scroll Ref:</span>
                            <strong class="text-dark font-monospace">{{ $registration->transaction_id ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block">Deposit Date:</span>
                            <strong class="text-dark">{{ $registration->paid_at ? \Carbon\Carbon::parse($registration->paid_at)->format('d-M-Y') : 'N/A' }}</strong>
                        </div>
                    </div>

                    @if($registration->receipt_path)
                        @php
                            $ext = strtolower(pathinfo($registration->receipt_path, PATHINFO_EXTENSION));
                        @endphp

                        <div class="receipt-preview-box">
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                                <img src="{{ asset('storage/' . $registration->receipt_path) }}" alt="Paid Voucher Slip" class="receipt-preview-img img-fluid">
                            @elseif($ext === 'pdf')
                                <div class="py-4 text-center">
                                    <i class="fa fa-file-pdf text-danger fs-1 mb-2"></i>
                                    <h6 class="fw-bold text-dark mb-2">PDF Document Attached</h6>
                                    <a href="{{ asset('storage/' . $registration->receipt_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fa fa-download me-1"></i> View / Download PDF Voucher
                                    </a>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $registration->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                    <i class="fa fa-file me-1"></i> Open Attached Document
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-light border text-center py-4 mb-0 text-muted">
                            <i class="fa fa-file-upload fs-3 d-block mb-2 text-secondary"></i>
                            Student has not yet attached any paid voucher or payment screenshot.
                        </div>
                    @endif

                    <!-- Verification Logs -->
                    @if($registration->verified_at)
                        <div class="mt-3 pt-3 border-top text-xs">
                            <div class="d-flex align-items-center gap-2 text-success fw-bold">
                                <i class="fa fa-check-circle"></i>
                                <span>Verified by {{ $registration->verifier ? $registration->verifier->name : 'Super Admin' }} on {{ \Carbon\Carbon::parse($registration->verified_at)->format('d-M-Y h:i A') }}</span>
                            </div>
                            @if($registration->admin_notes)
                                <div class="text-muted mt-1">Admin Notes: <em>"{{ $registration->admin_notes }}"</em></div>
                            @endif
                        </div>
                    @endif

                    @if($registration->rejection_reason)
                        <div class="mt-3 pt-3 border-top text-xs">
                            <div class="d-flex align-items-center gap-2 text-danger fw-bold">
                                <i class="fa fa-times-circle"></i>
                                <span>Rejection Reason: {{ $registration->rejection_reason }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Super Admin Permission & Fee Structure Override Form -->
            <div class="col-lg-5">
                <div class="permission-card mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                        <div class="d-flex align-items-center gap-2">
                            <i class="material-symbols-rounded text-warning fs-3">shield_person</i>
                            <h5 class="text-white fw-bold mb-0">Super Admin Rights</h5>
                        </div>
                        <span class="badge bg-warning text-dark text-xxs fw-bold">ADMIN ONLY</span>
                    </div>

                    <p class="text-xs text-white-50 mb-4">
                        As requested, <strong>fee structure and payment status are strictly locked</strong> from student modification. Super Admin can adjust fees, guest limits, and payment approval status here.
                    </p>

                    <form method="POST" action="{{ route('admin.students.updateFee', $registration->id) }}">
                        @csrf

                        @php
                            $currentBaseFee = (float)($convocationSettings->base_registration_fee ?? 15000);
                            $currentGuestFee = (float)($convocationSettings->guest_fee_per_person ?? 5000);
                            $currentGuests = (int)$registration->guests_count;
                            $calculatedTotal = $currentBaseFee + ($currentGuests * $currentGuestFee);
                            $isCustom = abs((float)$registration->fee_amount - $calculatedTotal) > 0.01;
                        @endphp

                        <!-- 1. Candidate Base Registration Fee -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">
                                Candidate Base Fee (PKR) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-dark fw-bold">PKR</span>
                                <input type="number" step="100" id="admin_base_fee" name="base_fee" class="form-control bg-white text-dark fw-bold" value="{{ (int)$currentBaseFee }}" required>
                            </div>
                            <small class="text-white-50 text-xxs">Official base fee (includes gown). Default: PKR {{ number_format($currentBaseFee) }}</small>
                        </div>

                        <!-- 2. Accompanying Guests Override -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">
                                Accompanying Guests Count <span class="text-danger">*</span>
                            </label>
                            <select id="admin_guests_count" name="guests_count" class="form-select bg-white text-dark fw-bold" required>
                                <option value="0" {{ $currentGuests === 0 ? 'selected' : '' }}>0 Guests (PKR 0 extra)</option>
                                <option value="1" {{ $currentGuests === 1 ? 'selected' : '' }}>1 Guest (+PKR {{ number_format($currentGuestFee) }})</option>
                                <option value="2" {{ $currentGuests === 2 ? 'selected' : '' }}>2 Guests (+PKR {{ number_format($currentGuestFee * 2) }})</option>
                            </select>
                            <small class="text-white-50 text-xxs">PKR {{ number_format($currentGuestFee) }} per accompanying guest</small>
                        </div>

                        <!-- 3. Dynamic Calculation Live Formula Preview -->
                        <div class="p-3 mb-3 rounded" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);">
                            <div class="d-flex justify-content-between align-items-center mb-1 text-xs text-white-50">
                                <span>Calculation:</span>
                                <span id="admin_calc_breakdown" class="font-monospace text-white">PKR {{ number_format($currentBaseFee) }} + ({{ $currentGuests }} &times; {{ number_format($currentGuestFee) }})</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-light">
                                <span class="text-white fw-bold text-xs text-uppercase">Total Fee Payable:</span>
                                <span class="text-warning fw-bold fs-5 font-monospace" id="admin_total_display">PKR {{ number_format($isCustom ? $registration->fee_amount : $calculatedTotal) }}</span>
                            </div>
                        </div>

                        <!-- 4. Total Fee Payable Hidden/Controlled Input -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label text-xs fw-bold text-white mb-0">Total Fee Amount (PKR) <span class="text-danger">*</span></label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="toggle_custom_waiver" name="is_custom_waiver" value="1" {{ $isCustom ? 'checked' : '' }}>
                                    <label class="form-check-label text-white-50 text-xxs" for="toggle_custom_waiver">Custom Override</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-dark fw-bold">PKR</span>
                                <input type="number" step="100" id="admin_fee_amount" name="fee_amount" class="form-control bg-white text-dark fw-bold" value="{{ (int)$registration->fee_amount }}" {{ $isCustom ? '' : 'readonly' }} required>
                            </div>
                            <small class="text-white-50 text-xxs" id="custom_waiver_hint">
                                {{ $isCustom ? 'Manual fee override enabled. Type any custom concession amount.' : 'Auto-calculated: Base + (Guests × PKR 5,000). Turn on switch for custom discount.' }}
                            </small>
                        </div>

                        <!-- 5. Payment Status Override -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">Fee Payment Status <span class="text-danger">*</span></label>
                            <select name="payment_status" class="form-select bg-white text-dark fw-bold" required>
                                <option value="unpaid" {{ $registration->payment_status === 'unpaid' ? 'selected' : '' }}>UNPAID (Pending Payment / Proof)</option>
                                <option value="pending_verification" {{ $registration->payment_status === 'pending_verification' ? 'selected' : '' }}>PENDING VERIFICATION (Proof Attached)</option>
                                <option value="paid" {{ $registration->payment_status === 'paid' ? 'selected' : '' }}>PAID & VERIFIED (Official Clearance)</option>
                            </select>
                        </div>

                        <!-- 6. Fee Due Date -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">Fee Due Date</label>
                            <input type="date" name="due_date" class="form-control bg-white text-dark" value="{{ $registration->due_date ? \Carbon\Carbon::parse($registration->due_date)->format('Y-m-d') : date('Y-m-d', strtotime('+15 days')) }}">
                        </div>

                        <!-- 7. Admin Internal Notes -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">Admin Internal Remarks</label>
                            <textarea name="admin_notes" class="form-control bg-white text-dark text-xs" rows="2" placeholder="e.g. Verified via BOP branch manager scroll #492">{{ $registration->admin_notes }}</textarea>
                        </div>

                        <!-- 8. Rejection Reason (if setting to unpaid) -->
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold text-white mb-1">Rejection Reason (Visible to Student if Unpaid)</label>
                            <input type="text" name="rejection_reason" class="form-control bg-white text-dark text-xs" placeholder="e.g. Deposit voucher image illegible" value="{{ $registration->rejection_reason }}">
                        </div>

                        <button type="submit" class="btn w-100 py-3 mb-0 fw-bold text-white" style="background: #17693f;">
                            <i class="fa fa-save me-1"></i> Update Permissions & Fee Structure
                        </button>
                    </form>
                </div>

                <!-- Quick Action Buttons Box -->
                <div class="admin-box">
                    <h6 class="fw-bold text-dark text-xs text-uppercase mb-3">
                        <i class="fa fa-bolt text-warning me-1"></i> Quick 1-Click Status Toggles
                    </h6>

                    <div class="d-grid gap-2">
                        <!-- Quick Approve -->
                        <form method="POST" action="{{ route('admin.students.approve', $registration->id) }}">
                            @csrf
                            <button type="submit" class="btn w-100 mb-0 py-2 text-white fw-bold" style="background: #17693f;" onclick="return confirm('Approve payment and mark as PAID?')">
                                <i class="fa fa-check-circle me-1"></i> Mark as PAID & Verified
                            </button>
                        </form>

                        <!-- Quick Mark Fee Pending -->
                        <form method="POST" action="{{ route('admin.students.pending', $registration->id) }}">
                            @csrf
                            <button type="submit" class="btn w-100 mb-0 py-2 text-white fw-bold" style="background: #0b4f6c;" onclick="return confirm('Set status of {{ addslashes($registration->name) }} to FEE PENDING (Under Review)?')">
                                <i class="fa fa-clock me-1"></i> Mark as Fee PENDING (In Review)
                            </button>
                        </form>

                        <!-- Quick Reject -->
                        <button type="button" class="btn btn-outline-danger w-100 mb-0 py-2" data-bs-toggle="modal" data-bs-target="#quickRejectModal">
                            <i class="fa fa-times-circle me-1"></i> Reject Payment Proof (Set UNPAID)
                        </button>
                    </div>

                    <!-- Quick Reject Modal -->
                    <div class="modal fade" id="quickRejectModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered text-start">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.students.reject', $registration->id) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-bold">Reject Payment Proof - {{ $registration->name }}</h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-xs text-secondary">
                                            Status will be reverted to <strong>UNPAID</strong>. The student can view the reason on their portal and re-attach valid proof.
                                        </p>
                                        <div class="mb-3">
                                            <label class="form-label text-xs fw-bold text-dark">Rejection Reason <span class="text-danger">*</span></label>
                                            <textarea name="rejection_reason" class="form-control text-xs" rows="3" required placeholder="Explain why payment voucher was rejected...">Deposit voucher is blurry / bank stamp not clear</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger btn-sm">Confirm Reject</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseFeeInput = document.getElementById('admin_base_fee');
            const guestsCountSelect = document.getElementById('admin_guests_count');
            const totalAmountInput = document.getElementById('admin_fee_amount');
            const totalDisplay = document.getElementById('admin_total_display');
            const breakdownDisplay = document.getElementById('admin_calc_breakdown');
            const customSwitch = document.getElementById('toggle_custom_waiver');
            const customHint = document.getElementById('custom_waiver_hint');
            const perGuestFee = {{ (float)($convocationSettings->guest_fee_per_person ?? 5000) }};

            function recalculate() {
                if (!baseFeeInput || !guestsCountSelect) return;
                const base = parseFloat(baseFeeInput.value) || 0;
                const guests = parseInt(guestsCountSelect.value) || 0;
                const guestTotal = guests * perGuestFee;
                const total = base + guestTotal;

                if (breakdownDisplay) {
                    breakdownDisplay.textContent = 'PKR ' + base.toLocaleString() + ' + (' + guests + ' × ' + perGuestFee.toLocaleString() + ')';
                }

                if (customSwitch && !customSwitch.checked) {
                    if (totalAmountInput) totalAmountInput.value = total;
                    if (totalDisplay) totalDisplay.textContent = 'PKR ' + total.toLocaleString();
                } else if (customSwitch && customSwitch.checked) {
                    const manualTotal = parseFloat(totalAmountInput.value) || 0;
                    if (totalDisplay) totalDisplay.textContent = 'PKR ' + manualTotal.toLocaleString();
                }
            }

            if (baseFeeInput && guestsCountSelect) {
                baseFeeInput.addEventListener('input', recalculate);
                guestsCountSelect.addEventListener('change', recalculate);

                if (customSwitch) {
                    customSwitch.addEventListener('change', function() {
                        if (this.checked) {
                            totalAmountInput.removeAttribute('readonly');
                            totalAmountInput.focus();
                            if (customHint) {
                                customHint.textContent = 'Manual fee override enabled. Type any custom concession amount.';
                            }
                        } else {
                            totalAmountInput.setAttribute('readonly', 'readonly');
                            if (customHint) {
                                customHint.textContent = 'Auto-calculated: Base + (Guests × PKR ' + perGuestFee.toLocaleString() + '). Turn on switch for custom discount.';
                            }
                            recalculate();
                        }
                    });
                }

                if (totalAmountInput) {
                    totalAmountInput.addEventListener('input', function() {
                        if (customSwitch && customSwitch.checked) {
                            const manualTotal = parseFloat(this.value) || 0;
                            if (totalDisplay) totalDisplay.textContent = 'PKR ' + manualTotal.toLocaleString();
                        }
                    });
                }

                recalculate();
            }
        });
    </script>

@endsection

