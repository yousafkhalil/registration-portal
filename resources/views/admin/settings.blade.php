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

        <!-- Card 6: Focal Persons Management (Dynamic Database Records) -->
        <div class="settings-card" id="focal_persons_card">
            <div class="settings-header flex-wrap gap-2">
                <div>
                    <h5>
                        <i class="fa fa-headset" style="color: #0b4f6c;"></i> 6. Convocation Focal Persons (Add / Edit / Remove)
                    </h5>
                    <small class="text-muted text-xxs">These focal persons are shown to students on the public registration page, student portal sidebar, and fee payment helpline.</small>
                </div>
                <button type="button" class="btn btn-sm text-white mb-0" style="background: #0b4f6c;" onclick="openAddFocalForm()">
                    <i class="fa fa-plus-circle me-1"></i> Add New Focal Person
                </button>
            </div>

            <!-- Inline Quick Add / Edit Form Box -->
            <div id="focal_inline_box" class="p-3 mb-4 rounded border bg-light shadow-sm" style="display: none; border-color: #b7d6e6 !important;">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                    <h6 class="fw-bold text-dark mb-0" id="inlineFocalTitle">
                        <i class="fa fa-user-plus text-primary me-2"></i> Add Convocation Focal Person
                    </h6>
                    <button type="button" class="btn btn-xs btn-outline-secondary mb-0" onclick="hideInlineFocalForm()">
                        <i class="fa fa-times me-1"></i> Close
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.focalPersons.save') }}" id="inlineFocalForm">
                    @csrf
                    <input type="hidden" name="id" id="inline_focal_id" value="">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="inline_focal_name" class="form-control" placeholder="e.g. Dr. Talha Khalil" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold">Designation / Role</label>
                            <input type="text" name="designation" id="inline_focal_designation" class="form-control" placeholder="e.g. Convocation Focal Person">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="inline_focal_mobile" class="form-control font-monospace" placeholder="e.g. +92 300 3180057" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-xs fw-bold">Official Email (Optional)</label>
                            <input type="email" name="email" id="inline_focal_email" class="form-control" placeholder="e.g. talha@simc.edu.pk">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label text-xs fw-bold">Display Sort Order</label>
                            <input type="number" name="sort_order" id="inline_focal_sort_order" class="form-control font-monospace" value="1" min="1">
                        </div>
                        <div class="col-md-3 col-sm-6 d-flex align-items-center pt-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_active" id="inline_focal_is_active" value="1" checked>
                                <label class="form-check-label text-xs fw-bold ms-2" for="inline_focal_is_active">Active & Visible</label>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary btn-sm mb-0" onclick="hideInlineFocalForm()">Cancel</button>
                            <button type="submit" id="inlineFocalSubmitBtn" class="btn btn-sm text-white mb-0 text-nowrap px-3" style="background: #0b4f6c;">
                                <i class="fa fa-save me-1"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Name & Role</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mobile Contact</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sort Order</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($focalPersons as $fp)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar avatar-xs rounded-circle d-flex align-items-center justify-content-center text-white" style="background: #0b4f6c; font-size: 0.70rem; width: 28px; height: 28px;">
                                            <i class="fa fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark text-sm">{{ $fp->name }}</strong>
                                            <small class="text-muted text-xxs">{{ $fp->designation ?? 'Convocation Focal Person' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="tel:{{ $fp->mobile }}" class="font-monospace fw-bold text-primary text-xs text-decoration-none">
                                        <i class="fa fa-phone-alt text-success me-1"></i> {{ $fp->mobile }}
                                    </a>
                                </td>
                                <td class="text-xs text-muted">
                                    @if(!empty($fp->email))
                                        <a href="mailto:{{ $fp->email }}" class="text-muted text-decoration-none">
                                            <i class="fa fa-envelope me-1"></i> {{ $fp->email }}
                                        </a>
                                    @else
                                        <span class="text-muted text-xxs">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-secondary text-xxs font-monospace">{{ $fp->sort_order }}</span>
                                </td>
                                <td class="text-center">
                                    @if($fp->is_active)
                                        <span class="badge" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb; font-size: 0.70rem;">
                                            <i class="fa fa-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; font-size: 0.70rem;">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1 align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mb-0 py-1 px-2"
                                            title="Edit Focal Person"
                                            onclick="openEditFocalForm('{{ $fp->id }}', '{{ addslashes($fp->name) }}', '{{ addslashes($fp->designation) }}', '{{ addslashes($fp->mobile) }}', '{{ addslashes($fp->email ?? '') }}', '{{ $fp->sort_order }}', '{{ $fp->is_active ? 1 : 0 }}')">
                                            <i class="fa fa-pencil-alt me-1"></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.focalPersons.delete', $fp->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete focal person: {{ addslashes($fp->name) }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger mb-0 py-1 px-2" title="Delete Focal Person">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa fa-info-circle me-1"></i> No focal persons registered in database yet. Click <strong>Add New Focal Person</strong> above to add.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Unified Add / Edit Focal Person Modal (Secondary / Overlay Option) -->
    <div class="modal fade" id="focalPersonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0" style="border-radius: 12px; overflow: hidden;">
                <form method="POST" action="{{ route('admin.focalPersons.save') }}" id="focalPersonModalForm">
                    @csrf
                    <input type="hidden" name="id" id="modal_focal_id" value="">

                    <div class="modal-header text-white" style="background: #0b4f6c;">
                        <h6 class="modal-title fw-bold text-white mb-0" id="focalModalTitle">
                            <i class="fa fa-user-plus me-2"></i> Add Convocation Focal Person
                        </h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="closeFocalModal()" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="modal_focal_name" class="form-control" placeholder="e.g. Dr. Talha Khalil" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Designation / Department</label>
                            <input type="text" name="designation" id="modal_focal_designation" class="form-control" placeholder="e.g. Convocation Focal Person / Assistant Professor">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Mobile / WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="modal_focal_mobile" class="form-control font-monospace" placeholder="e.g. +92 300 3180057" required>
                            <small class="text-muted text-xxs">Will be click-to-dial on student screens</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold">Email Address (Optional)</label>
                            <input type="email" name="email" id="modal_focal_email" class="form-control" placeholder="e.g. talha@simc.edu.pk">
                        </div>

                        <div class="row g-2">
                            <div class="col-sm-6">
                                <label class="form-label text-xs fw-bold">Display Sort Order</label>
                                <input type="number" name="sort_order" id="modal_focal_sort_order" class="form-control font-monospace" value="1" min="1">
                            </div>
                            <div class="col-sm-6 d-flex align-items-center pt-3">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="modal_focal_is_active" value="1" checked>
                                    <label class="form-check-label text-xs fw-bold ms-2" for="modal_focal_is_active">Active & Visible</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm mb-0" data-bs-dismiss="modal" onclick="closeFocalModal()">Cancel</button>
                        <button type="submit" id="focalModalSubmitBtn" class="btn btn-sm text-white mb-0 px-3" style="background: #0b4f6c;">
                            <i class="fa fa-save me-1"></i> Save Focal Person
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 1. INLINE FORM HANDLERS (Recommended, fast & works on every device)
        function openAddFocalForm() {
            var box = document.getElementById('focal_inline_box');
            if (box) {
                box.style.display = 'block';
                document.getElementById('inlineFocalTitle').innerHTML = '<i class="fa fa-user-plus text-primary me-2"></i> Add New Convocation Focal Person';
                document.getElementById('inlineFocalSubmitBtn').innerHTML = '<i class="fa fa-save me-1"></i> Save Focal Person';
                document.getElementById('inline_focal_id').value = '';
                document.getElementById('inline_focal_name').value = '';
                document.getElementById('inline_focal_designation').value = 'Convocation Focal Person';
                document.getElementById('inline_focal_mobile').value = '';
                document.getElementById('inline_focal_email').value = '';
                document.getElementById('inline_focal_sort_order').value = '1';
                document.getElementById('inline_focal_is_active').checked = true;

                box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                var nameInput = document.getElementById('inline_focal_name');
                if (nameInput) nameInput.focus();
            }
        }

        function openEditFocalForm(id, name, designation, mobile, email, sortOrder, isActive) {
            var box = document.getElementById('focal_inline_box');
            if (box) {
                box.style.display = 'block';
                document.getElementById('inlineFocalTitle').innerHTML = '<i class="fa fa-user-edit text-primary me-2"></i> Edit Focal Person: ' + name;
                document.getElementById('inlineFocalSubmitBtn').innerHTML = '<i class="fa fa-check me-1"></i> Update Focal Person';
                document.getElementById('inline_focal_id').value = id;
                document.getElementById('inline_focal_name').value = name;
                document.getElementById('inline_focal_designation').value = designation || 'Convocation Focal Person';
                document.getElementById('inline_focal_mobile').value = mobile;
                document.getElementById('inline_focal_email').value = email || '';
                document.getElementById('inline_focal_sort_order').value = sortOrder || 1;
                document.getElementById('inline_focal_is_active').checked = (isActive == 1 || isActive === '1' || isActive === true);

                box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                var nameInput = document.getElementById('inline_focal_name');
                if (nameInput) nameInput.focus();
            }
        }

        function hideInlineFocalForm() {
            var box = document.getElementById('focal_inline_box');
            if (box) box.style.display = 'none';
        }

        // 2. MODAL FALLBACK HANDLERS
        function closeFocalModal() {
            var modalEl = document.getElementById('focalPersonModal');
            if (!modalEl) return;
            if (window.bootstrap && bootstrap.Modal) {
                var modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            document.body.classList.remove('modal-open');
            var backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(function(b) { b.remove(); });
        }
    </script>

@endsection

