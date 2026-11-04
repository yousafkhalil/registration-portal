@extends('theme')

@section('title', 'Manage Registrations - ' . ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' | ' . ($convocationSettings->institution_name ?? 'SIMC'))
@section('page_title', ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' &bull; Registrations & Fee Approvals')

@section('Content')

    <style>
        .filter-scroll-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 6px;
        }
        .filter-scroll-pills::-webkit-scrollbar {
            height: 4px;
        }
        .table td, .table th {
            white-space: nowrap;
        }
    </style>

    <div class="container-fluid py-2">
        <!-- Status Filter Tabs & Stats -->
        <div class="row g-2 mb-3 align-items-center">
            <div class="col-lg-8">
                <div class="filter-scroll-pills">
                    <a href="{{ route('admin.students') }}" class="btn btn-sm text-nowrap {{ empty($filters['status']) ? 'text-white' : 'btn-outline-secondary' }} mb-0" style="{{ empty($filters['status']) ? 'background: #0f2533;' : '' }}">
                        All ({{ $stats['total_students'] }})
                    </a>
                    <a href="{{ route('admin.students', array_merge(request()->except('page'), ['status' => 'pending_verification'])) }}" class="btn btn-sm text-nowrap {{ ($filters['status'] ?? '') === 'pending_verification' ? 'text-white' : 'btn-outline-secondary' }} mb-0" style="{{ ($filters['status'] ?? '') === 'pending_verification' ? 'background: #0b4f6c;' : '' }}">
                        <i class="fa fa-clock me-1"></i> Review Queue ({{ $stats['pending_verifications'] }})
                    </a>
                    <a href="{{ route('admin.students', array_merge(request()->except('page'), ['status' => 'paid'])) }}" class="btn btn-sm text-nowrap {{ ($filters['status'] ?? '') === 'paid' ? 'text-white' : 'btn-outline-secondary' }} mb-0" style="{{ ($filters['status'] ?? '') === 'paid' ? 'background: #17693f;' : '' }}">
                        <i class="fa fa-check-circle me-1"></i> Paid ({{ $stats['paid_students'] }})
                    </a>
                    <a href="{{ route('admin.students', array_merge(request()->except('page'), ['status' => 'unpaid'])) }}" class="btn btn-sm text-nowrap {{ ($filters['status'] ?? '') === 'unpaid' ? 'text-white' : 'btn-outline-secondary' }} mb-0" style="{{ ($filters['status'] ?? '') === 'unpaid' ? 'background: #8a5a0b;' : '' }}">
                        <i class="fa fa-exclamation-triangle me-1"></i> Unpaid ({{ $stats['unpaid_students'] }})
                    </a>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end">
                <span class="badge text-secondary text-xs border" style="background: #eef2f5;">
                    Showing {{ $students->total() }} record(s)
                </span>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="card border-0 shadow-sm mb-4" style="border: 1px solid #dde3e8; border-radius: 10px;">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('admin.students') }}" class="row g-2 align-items-center">
                    @if(!empty($filters['status']))
                        <input type="hidden" name="status" value="{{ $filters['status'] }}">
                    @endif

                    <div class="col-md-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="fa fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control form-control-sm border-start-0" placeholder="Search by Student Name, Roll No, CNIC, Challan No, Ref ID..." value="{{ $filters['search'] ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select name="department" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- All Departments --</option>
                            <option value="MBBS" {{ ($filters['department'] ?? '') === 'MBBS' ? 'selected' : '' }}>MBBS (Medicine)</option>
                            <option value="BDS" {{ ($filters['department'] ?? '') === 'BDS' ? 'selected' : '' }}>BDS (Dental)</option>
                            <option value="Pharm-D" {{ ($filters['department'] ?? '') === 'Pharm-D' ? 'selected' : '' }}>Pharm-D (Pharmacy)</option>
                            <option value="DPT" {{ ($filters['department'] ?? '') === 'DPT' ? 'selected' : '' }}>DPT (Physical Therapy)</option>
                            <option value="Nursing" {{ ($filters['department'] ?? '') === 'Nursing' ? 'selected' : '' }}>BS Nursing</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm w-100 mb-0 text-white fw-bold" style="background: #0b4f6c;">
                            <i class="fa fa-filter me-1"></i> Apply Filters
                        </button>
                        @if(!empty($filters['search']) || !empty($filters['department']) || !empty($filters['status']))
                            <a href="{{ route('admin.students') }}" class="btn btn-sm btn-outline-secondary mb-0" title="Reset Filters">
                                <i class="fa fa-undo"></i>
                            </a>
                        @endif
                    </div>
                </form>
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

        <!-- Students Table Card -->
        <div class="card border-0 shadow-sm" style="border: 1px solid #dde3e8; border-radius: 10px;">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Student & Contact</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Department / Roll No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Challan / Amount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Guests</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Voucher Proof</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Super Rights</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $reg)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="background: #0b4f6c;">
                                                {{ strtoupper(substr($reg->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm fw-bold text-dark">{{ $reg->name }}</h6>
                                                <small class="text-muted text-xxs font-monospace">{{ $reg->email }}</small>
                                                <div class="text-xxs text-secondary">
                                                    <i class="fa fa-phone me-1"></i> {{ $reg->contact_no }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #eef2f5; color: #3d4b57; border: 1px solid #dde3e8;">{{ $reg->department }}</span>
                                        <div class="fw-bold text-dark text-xs mt-1">Roll: {{ $reg->roll_no }}</div>
                                        <small class="text-muted text-xxs">Class: {{ $reg->class ?? 'N/A' }}</small>
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
                                        @if($reg->payment_status === 'paid')
                                            <span class="badge text-xxs" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb;">
                                                <i class="fa fa-check-circle me-1"></i> PAID
                                            </span>
                                            <div class="text-xxs text-muted mt-1">
                                                By: {{ $reg->verifier ? $reg->verifier->name : 'Admin' }}
                                            </div>
                                        @elseif($reg->payment_status === 'pending_verification')
                                            <span class="badge text-xxs" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">
                                                <i class="fa fa-clock me-1"></i> PENDING REVIEW
                                            </span>
                                            <div class="text-xxs mt-1 fw-bold" style="color: #0b4f6c;">Action Required</div>
                                        @else
                                            <span class="badge text-xxs" style="background: #fbf0d9; color: #8a5a0b; border: 1px solid #fae1b3;">
                                                <i class="fa fa-exclamation-circle me-1"></i> UNPAID
                                            </span>
                                            @if($reg->rejection_reason)
                                                <div class="text-xxs text-danger mt-1" title="{{ $reg->rejection_reason }}">
                                                    Rejected
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($reg->receipt_path)
                                            <a href="{{ asset('storage/' . $reg->receipt_path) }}" target="_blank" class="btn btn-xs mb-1 d-block py-1 text-center" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">
                                                <i class="fa fa-eye me-1"></i> View Voucher
                                            </a>
                                            <small class="text-muted text-xxs font-monospace d-block">
                                                {{ $reg->bank_name ?? 'Bank' }}
                                            </small>
                                        @else
                                            <span class="text-muted text-xxs">No Proof Attached</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            @if($reg->payment_status !== 'paid')
                                                <!-- Super Admin Quick Approve -->
                                                <form method="POST" action="{{ route('admin.students.approve', $reg->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm mb-0 py-1 px-2 text-white" style="background: #17693f;" title="Approve & Mark Paid" onclick="return confirm('Confirm approve payment of PKR {{ number_format($reg->fee_amount) }} for {{ $reg->name }}?')">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reg->payment_status === 'pending_verification')
                                                <!-- Reject Modal Trigger -->
                                                <button type="button" class="btn btn-sm btn-outline-danger mb-0 py-1 px-2" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $reg->id }}" title="Reject Payment Proof">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif

                                            <!-- Permission / Fee Structure Form -->
                                            <a href="{{ route('admin.students.show', $reg->id) }}" class="btn btn-sm mb-0 py-1 px-2 text-white" style="background: #0f2533;" title="Permission & Fee Override Form">
                                                <i class="fa fa-sliders-h me-1"></i> Manage
                                            </a>
                                        </div>

                                        <!-- Reject Modal -->
                                        @if($reg->payment_status === 'pending_verification')
                                            <div class="modal fade" id="rejectModal{{ $reg->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered text-start">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('admin.students.reject', $reg->id) }}">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h6 class="modal-title fw-bold">Reject Proof - {{ $reg->name }}</h6>
                                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-xs text-secondary">
                                                                    Status will revert to <strong>UNPAID</strong>. The student will see your rejection reason on their fee portal.
                                                                </p>
                                                                <div class="mb-3">
                                                                    <label class="form-label text-xs fw-bold text-dark">Reason <span class="text-danger">*</span></label>
                                                                    <textarea name="rejection_reason" class="form-control text-xs" rows="3" required placeholder="State why payment was not accepted...">Deposit voucher image is blurry / illegible</textarea>
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        No student registration records match the current filter criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="p-3 border-top d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-xs">Page {{ $students->currentPage() }} of {{ $students->lastPage() }}</small>
                    </div>
                    <div>
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

