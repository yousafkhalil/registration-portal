@extends('theme')

@section('title', 'Convocation Settings & Configuration - Super Admin')
@section('page_title', 'Convocation Master Settings (Database Columns)')

@section('Content')

    <style>
        .settings-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #dde3e8;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 24px;
        }

        .settings-header {
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .settings-header h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f2533;
            display: flex;
            align-items: center;
            gap: 8px;
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

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 4px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .settings-card {
                padding: 16px;
                border-radius: 10px;
            }
            .form-control,
            .form-select {
                font-size: 16px !important; /* Prevents auto zoom in on iOS Safari */
                padding: 10px 12px !important;
            }
        }
    </style>

    <div class="container-fluid py-2">
        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-2 mb-3">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="material-symbols-rounded text-primary align-middle me-1">settings_suggest</i>
                    Database Dynamic Settings & Configurations
                </h4>
                <p class="text-xs text-secondary mb-0">
                    All convocation parameters, fee structures, bank details, and dates are stored in database columns. Modifying values here immediately updates all pages, challans, calculations, and registration rules without changing any code.
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-0 text-center text-nowrap">
                <i class="fa fa-arrow-left me-1"></i> Dashboard
            </a>
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

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <!-- Card 1: Event & Institution Branding -->
            <div class="settings-card">
                <div class="settings-header">
                    <h5>
                        <i class="fa fa-university text-primary"></i> 1. Institution & Convocation Branding
                    </h5>
                    <span class="badge bg-light text-secondary text-xxs font-monospace">Table: convocation_settings</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Institution Name</label>
                        <input type="text" name="institution_name" class="form-control" value="{{ old('institution_name', $settings->institution_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Institution Tagline / Motto</label>
                        <input type="text" name="institution_tagline" class="form-control" value="{{ old('institution_tagline', $settings->institution_tagline) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Convocation Event Title</label>
                        <input type="text" name="convocation_title" class="form-control fw-bold" value="{{ old('convocation_title', $settings->convocation_title) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Official Slogan</label>
                        <input type="text" name="slogan" class="form-control" value="{{ old('slogan', $settings->slogan) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Official Website URL</label>
                        <input type="url" name="official_website" class="form-control font-monospace" value="{{ old('official_website', $settings->official_website) }}">
                    </div>
                </div>
            </div>

            <!-- Card 2: Key Event Dates & Deadlines -->
            <div class="settings-card">
                <div class="settings-header">
                    <h5>
                        <i class="fa fa-calendar-alt text-warning"></i> 2. Ceremony Dates & Registration Deadlines
                    </h5>
                    <span class="badge bg-warning text-dark text-xxs">Schedule</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Convocation Date (YYYY-MM-DD)</label>
                        <input type="date" name="convocation_date" class="form-control fw-bold" value="{{ old('convocation_date', $settings->convocation_date ? $settings->convocation_date->format('Y-m-d') : '2026-11-28') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Convocation Date Label (Display)</label>
                        <input type="text" name="convocation_date_formatted" class="form-control" value="{{ old('convocation_date_formatted', $settings->convocation_date_formatted) }}" placeholder="e.g. Saturday, 28 November 2026">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Registration Deadline (Due Date)</label>
                        <input type="date" name="registration_deadline" class="form-control fw-bold text-danger" value="{{ old('registration_deadline', $settings->registration_deadline ? $settings->registration_deadline->format('Y-m-d') : '2026-11-15') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Deadline Label (Display)</label>
                        <input type="text" name="registration_deadline_formatted" class="form-control" value="{{ old('registration_deadline_formatted', $settings->registration_deadline_formatted) }}" placeholder="e.g. 15 November 2026">
                    </div>
                </div>
            </div>

            <!-- Card 3: Fee Structure & Policy Rules -->
            <div class="settings-card">
                <div class="settings-header">
                    <h5>
                        <i class="fa fa-receipt text-success"></i> 3. Dynamic Fee Structure & Guest Allowances
                    </h5>
                    <span class="badge bg-success text-white text-xxs">Fee Engine</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Graduate Registration Fee (PKR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">PKR</span>
                            <input type="number" step="100" name="base_registration_fee" class="form-control fw-bold fs-6" value="{{ (int)$settings->base_registration_fee }}" required>
                        </div>
                        <small class="text-muted text-xxs">Base fee charged to graduate (includes gown)</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Guest Fee Per Person (PKR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">PKR</span>
                            <input type="number" step="100" name="guest_fee_per_person" class="form-control fw-bold" value="{{ (int)$settings->guest_fee_per_person }}" required>
                        </div>
                        <small class="text-muted text-xxs">Fee added per accompanying guest</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Maximum Guests Allowed</label>
                        <input type="number" min="0" max="5" name="max_guests_allowed" class="form-control fw-bold" value="{{ (int)$settings->max_guests_allowed }}" required>
                        <small class="text-muted text-xxs">Currently set to 2 guests maximum</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Convocation Gown Notice Text</label>
                        <input type="text" name="gown_included_notice" class="form-control" value="{{ old('gown_included_notice', $settings->gown_included_notice) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Allowed Guest Relationship Policy</label>
                        <input type="text" name="allowed_guest_relations" class="form-control" value="{{ old('allowed_guest_relations', $settings->allowed_guest_relations) }}">
                    </div>
                </div>
            </div>

            <!-- Card 4: Official Bank Details -->
            <div class="settings-card">
                <div class="settings-header">
                    <h5>
                        <i class="fa fa-building-columns text-info"></i> 4. Designated Bank Account Information
                    </h5>
                    <span class="badge bg-info text-white text-xxs">Challan & IBFT</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Primary Receiving Bank</label>
                        <input type="text" name="bank_name" class="form-control fw-bold" value="{{ old('bank_name', $settings->bank_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Secondary / Alternate Bank</label>
                        <input type="text" name="secondary_bank" class="form-control" value="{{ old('secondary_bank', $settings->secondary_bank) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Title</label>
                        <input type="text" name="account_title" class="form-control fw-bold" value="{{ old('account_title', $settings->account_title) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control font-monospace fw-bold" value="{{ old('account_number', $settings->account_number) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IBAN Number (1Link / Raast)</label>
                        <input type="text" name="iban" class="form-control font-monospace fw-bold" value="{{ old('iban', $settings->iban) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Branch & Payment Channel Notes</label>
                        <input type="text" name="branch_info" class="form-control" value="{{ old('branch_info', $settings->branch_info) }}">
                    </div>
                </div>
            </div>

            <!-- Card 5: Eligibility Sessions & Notices -->
            <div class="settings-card">
                <div class="settings-header">
                    <h5>
                        <i class="fa fa-users-viewfinder text-danger"></i> 5. Eligibility Sessions & Priority Notices
                    </h5>
                    <span class="badge bg-danger text-white text-xxs">Batch Eligibility</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Priority Registration Passing Sessions</label>
                        <input type="text" name="priority_sessions" class="form-control font-monospace" value="{{ old('priority_sessions', $settings->priority_sessions) }}" placeholder="e.g. 2021, 2022, 2023">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Provisional Registration Passing Sessions</label>
                        <input type="text" name="provisional_sessions" class="form-control font-monospace" value="{{ old('provisional_sessions', $settings->provisional_sessions) }}" placeholder="e.g. 2024">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Priority Registration Detailed Notice Text</label>
                        <textarea name="priority_notice" class="form-control text-xs" rows="3">{{ old('priority_notice', $settings->priority_notice) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Provisional Registration Detailed Notice Text</label>
                        <textarea name="provisional_notice" class="form-control text-xs" rows="3">{{ old('provisional_notice', $settings->provisional_notice) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button type="submit" class="btn px-4 py-3 fw-bold fs-6 text-white" style="background: #0b4f6c;">
                    <i class="fa fa-save me-2"></i> Save All Convocation Settings to Database
                </button>
            </div>
        </form>

        <!-- Card 6: Focal Persons Management -->
        <div class="settings-card">
            <div class="settings-header">
                <h5>
                    <i class="fa fa-headset" style="color: #0b4f6c;"></i> 6. Convocation Focal Persons
                </h5>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-0" data-bs-toggle="modal" data-bs-target="#addFocalModal">
                    <i class="fa fa-plus me-1"></i> Add New Focal Person
                </button>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Designation</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mobile Number</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($focalPersons as $fp)
                            <tr>
                                <td class="ps-3 fw-bold text-dark text-sm">{{ $fp->name }}</td>
                                <td class="text-xs text-secondary">{{ $fp->designation }}</td>
                                <td class="font-monospace fw-bold text-primary text-xs">{{ $fp->mobile }}</td>
                                <td class="text-xs">{{ $fp->sort_order }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.focalPersons.delete', $fp->id) }}" class="d-inline" onsubmit="return confirm('Delete focal person {{ $fp->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger mb-0 py-1 px-2">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No focal persons registered in database yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Focal Person Modal -->
    <div class="modal fade" id="addFocalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.focalPersons.save') }}">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">Add Convocation Focal Person</h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Dr. Talha Khalil" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Designation / Role</label>
                            <input type="text" name="designation" class="form-control form-control-sm" value="Convocation Focal Person">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control form-control-sm font-monospace" placeholder="e.g. +92 300 3180057" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-xs fw-bold">Display Sort Order</label>
                            <input type="number" name="sort_order" class="form-control form-control-sm" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm text-white" style="background: #0b4f6c;">Save Focal Person to Database</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

