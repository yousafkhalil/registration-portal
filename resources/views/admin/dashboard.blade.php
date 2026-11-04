@extends('theme')

@section('title', 'Admin Dashboard - ' . ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' | ' . ($convocationSettings->institution_name ?? 'Shahida Islam Medical Complex'))
@section('page_title', ($convocationSettings->institution_name ?? 'SIMC') . ' ' . ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' • Super Admin Console')

@section('Content')

    <style>
        .stat-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #dde3e8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .badge-pending {
            background-color: #e3eff5;
            color: #0b4f6c;
            border: 1px solid #b7d6e6;
        }

        .badge-paid {
            background-color: #e3f3ea;
            color: #17693f;
            border: 1px solid #b8e2cb;
        }

        .badge-unpaid {
            background-color: #fbf0d9;
            color: #8a5a0b;
            border: 1px solid #fae1b3;
        }

        .table td, .table th {
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .stat-card {
                padding: 14px 16px;
            }
            .stat-card h3 {
                font-size: 1.3rem;
            }
            .stat-icon {
                width: 42px;
                height: 42px;
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="container-fluid py-2">
        <!-- Top Metrics Row -->
        <div class="row g-3 mb-4">
            <!-- 1. Total Students -->
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card" style="border-left: 4px solid #0b4f6c;">
                    <div>
                        <span class="text-xs text-muted text-uppercase fw-bold">Total Students</span>
                        <h3 class="fw-bold text-dark mb-0">{{ number_format($stats['total_students']) }}</h3>
                        <small class="text-muted text-xxs">Registered in Portal</small>
                    </div>
                    <div class="stat-icon" style="background: #e3eff5; color: #0b4f6c;">
                        <i class="material-symbols-rounded">group</i>
                    </div>
                </div>
            </div>

            <!-- 2. Pending Verification (Needs Admin Action!) -->
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card" style="border-left: 4px solid #0b4f6c;">
                    <div>
                        <span class="text-xs text-uppercase fw-bold" style="color: #0b4f6c;">Pending Review</span>
                        <h3 class="fw-bold mb-0" style="color: #0b4f6c;">{{ number_format($stats['pending_verifications']) }}</h3>
                        <small class="text-muted text-xxs">Proof Submitted by Students</small>
                    </div>
                    <div class="stat-icon" style="background: #e3eff5; color: #0b4f6c;">
                        <i class="material-symbols-rounded">pending_actions</i>
                    </div>
                </div>
            </div>

            <!-- 3. Paid & Verified -->
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card" style="border-left: 4px solid #17693f;">
                    <div>
                        <span class="text-xs text-uppercase fw-bold" style="color: #17693f;">Paid & Verified</span>
                        <h3 class="fw-bold mb-0" style="color: #17693f;">{{ number_format($stats['paid_students']) }}</h3>
                        <small class="text-muted text-xxs">Super Admin Approved</small>
                    </div>
                    <div class="stat-icon" style="background: #e3f3ea; color: #17693f;">
                        <i class="material-symbols-rounded">verified</i>
                    </div>
                </div>
            </div>

            <!-- 4. Total Fee Collected -->
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card" style="border-left: 4px solid #0f2533;">
                    <div>
                        <span class="text-xs text-secondary text-uppercase fw-bold">Total Revenue</span>
                        <h3 class="fw-bold text-dark mb-0">PKR {{ number_format($stats['total_collected']) }}</h3>
                        <small class="text-muted text-xxs">Verified Fee In Bank</small>
                    </div>
                    <div class="stat-icon" style="background: #eef2f5; color: #0f2533;">
                        <i class="material-symbols-rounded">account_balance_wallet</i>
                    </div>
                </div>
            </div>
        </div>

        @if(session('message'))
            <div class="alert alert-success text-white shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                <i class="fa fa-check-circle me-2"></i> {{ session('message') }}
            </div>
        @endif

        <!-- Recent Pending Verification Queue -->
        <div class="card border-0 shadow-sm mb-4" style="border: 1px solid #dde3e8; border-radius: 10px;">
            <div class="card-header bg-white pb-0 pt-3 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="material-symbols-rounded align-middle me-1" style="color: #0b4f6c;">hourglass_top</i>
                        Pending Verification Queue
                    </h5>
                    <small class="text-muted text-xs">Students who have attached bank voucher / payment screenshot and are awaiting your approval</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.students', ['status' => 'pending_verification']) }}" class="btn btn-sm btn-outline-secondary mb-0">
                        <i class="fa fa-filter me-1"></i> View Full Verification Queue
                    </a>
                    <a href="{{ route('admin.students') }}" class="btn btn-sm mb-0 text-white" style="background: #0f2533;">
                        <i class="fa fa-users me-1"></i> All Students
                    </a>
                </div>
            </div>

            <div class="card-body px-0 pt-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Student Info</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Department / Session</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Challan / Amount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Guests</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment Proof</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Super Rights Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats['recent_pending'] as $reg)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="background: #0b4f6c;">
                                                {{ strtoupper(substr($reg->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm fw-bold text-dark">{{ $reg->name }}</h6>
                                                <small class="text-muted text-xxs font-monospace">Roll: {{ $reg->roll_no }} | CNIC: {{ $reg->cnic_formatted ?? $reg->cnic }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #eef2f5; color: #3d4b57; border: 1px solid #dde3e8;">{{ $reg->department }}</span>
                                        <div class="text-xxs text-muted mt-1">Class: {{ $reg->class ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark text-sm">PKR {{ number_format($reg->fee_amount) }}</div>
                                        <small class="text-muted text-xxs font-monospace">{{ $reg->challan_no }}</small>
                                    </td>
                                    <td>
                                        <span class="badge text-dark text-xxs border" style="background: #f8fafc;">
                                            {{ (int)$reg->guests_count }} Guest(s)
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column text-xxs">
                                            <span class="fw-bold text-dark">{{ $reg->bank_name ?? 'Bank Deposit' }}</span>
                                            <span class="text-muted font-monospace">Ref: {{ $reg->transaction_id ?? 'N/A' }}</span>
                                            @if($reg->receipt_path)
                                                <a href="{{ asset('storage/' . $reg->receipt_path) }}" target="_blank" class="fw-bold mt-1" style="color: #0b4f6c;">
                                                    <i class="fa fa-paperclip me-1"></i> View Attached Voucher
                                                </a>
                                            @else
                                                <span class="text-warning">No file uploaded</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <!-- 1-Click Super Admin Approve Form -->
                                            <form method="POST" action="{{ route('admin.students.approve', $reg->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm mb-0 py-1 px-3 text-white fw-bold" style="background: #17693f;" onclick="return confirm('Approve payment of PKR {{ number_format($reg->fee_amount) }} for {{ $reg->name }}?')">
                                                    <i class="fa fa-check me-1"></i> Approve
                                                </button>
                                            </form>

                                            <!-- Reject Button triggers modal -->
                                            <button type="button" class="btn btn-sm btn-outline-danger mb-0 py-1 px-2" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $reg->id }}">
                                                <i class="fa fa-times me-1"></i> Reject
                                            </button>

                                            <!-- Permission / Details Link -->
                                            <a href="{{ route('admin.students.show', $reg->id) }}" class="btn btn-sm btn-outline-secondary mb-0 py-1 px-2" title="Permission & Fee Form">
                                                <i class="fa fa-cog"></i>
                                            </a>
                                        </div>

                                        <!-- Reject Reason Modal -->
                                        <div class="modal fade" id="rejectModal{{ $reg->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered text-start">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('admin.students.reject', $reg->id) }}">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h6 class="modal-title fw-bold">Reject Payment Proof - {{ $reg->name }}</h6>
                                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-xs text-secondary">
                                                                Status will be reverted to <strong>UNPAID</strong> and the student will be notified to re-upload.
                                                            </p>
                                                            <div class="mb-3">
                                                                <label class="form-label text-xs fw-bold text-dark">Reason for Rejection <span class="text-danger">*</span></label>
                                                                <select name="rejection_reason" class="form-select form-select-sm mb-2" onchange="if(this.value !== 'Other') { document.getElementById('customReason{{ $reg->id }}').value = this.value; }">
                                                                    <option value="Deposit voucher image is blurry / illegible">Deposit voucher image is blurry / illegible</option>
                                                                    <option value="Bank stamp or transaction date missing">Bank stamp or transaction date missing</option>
                                                                    <option value="Paid amount does not match required fee">Paid amount does not match required fee</option>
                                                                    <option value="Invalid transaction reference ID">Invalid transaction reference ID</option>
                                                                    <option value="Other">Other (Enter below)</option>
                                                                </select>
                                                                <textarea id="customReason{{ $reg->id }}" name="rejection_reason" class="form-control text-xs" rows="3" placeholder="Enter reason explaining why payment proof was rejected..." required>Deposit voucher image is blurry / illegible</textarea>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label text-xs fw-bold text-secondary">Internal Admin Notes (Optional)</label>
                                                                <input type="text" name="admin_notes" class="form-control form-control-sm text-xs" placeholder="e.g. Verified with bank, no deposit received">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger btn-sm">Confirm Rejection</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="material-symbols-rounded fs-1 d-block mb-2 text-secondary">check_circle</i>
                                            <h6 class="fw-bold mb-1">All Caught Up!</h6>
                                            <p class="text-xs mb-0">No pending payment verifications in queue at this time.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Convocation Focal Persons & Quick Links Bar -->
        <div class="card border-0 shadow-sm mb-4" style="border: 1px solid #dde3e8; border-radius: 10px;">
            <div class="card-header bg-white pb-2 pt-3 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="material-symbols-rounded align-middle me-1" style="color: #0b4f6c;">support_agent</i>
                        Convocation Focal Persons (Student Helplines)
                    </h5>
                    <small class="text-muted text-xs">These official contacts are shown on the student portal, registration form, and printable fee vouchers</small>
                </div>
                <a href="{{ route('admin.settings') }}#focal_persons_card" class="btn btn-sm text-white mb-0" style="background: #0b4f6c;">
                    <i class="fa fa-pencil-alt me-1"></i> Add / Edit Focal Persons
                </a>
            </div>
            <div class="card-body pt-2 pb-3">
                @if(!empty($convocationFocalPersons) && count($convocationFocalPersons) > 0)
                    <div class="row g-3">
                        @foreach($convocationFocalPersons as $fp)
                            <div class="col-md-6 col-lg-4">
                                <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center text-white" style="background: #0b4f6c;">
                                            <i class="fa fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark text-xs mb-0">{{ $fp->name }}</strong>
                                            <small class="text-muted text-xxs d-block">{{ $fp->designation }}</small>
                                            <a href="tel:{{ $fp->mobile }}" class="text-primary font-monospace fw-bold text-xxs text-decoration-none">
                                                <i class="fa fa-phone-alt text-success me-1"></i> {{ $fp->mobile }}
                                            </a>
                                        </div>
                                    </div>
                                    <span class="badge text-xxs" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb;">Active</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3 text-muted text-xs">
                        No focal persons configured yet. <a href="{{ route('admin.settings') }}#focal_persons_card" class="fw-bold text-primary">Click here to add</a>.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

