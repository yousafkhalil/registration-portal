@extends('theme')

@section('title', 'Student Profile & Academic Details')

@section('Content')

    <style>
        .edit-section-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 22px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .edit-section-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }
        .edit-card-header {
            padding: 14px 20px;
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .edit-card-header h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .field-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .form-control,
        .form-select {
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-size: 0.88rem !important;
            transition: all 0.2s ease;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }
        .guest-card {
            background: #f8fafc;
            border: 1.5px dashed #3b82f6;
            border-radius: 10px;
            padding: 16px;
            margin-top: 10px;
            transition: all 0.2s ease;
        }
        .prof-row-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 14px;
            transition: all 0.2s ease;
        }
        .prof-row-card:hover {
            border-color: #94a3b8;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        }
        .position-opt-btn {
            cursor: pointer;
            border: 1px solid #c3ccd4;
            background: #ffffff;
            color: #3d4b57;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.15s ease;
            user-select: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .position-opt-btn:hover {
            border-color: #0b4f6c;
            background: #e3eff5;
            color: #0b4f6c;
        }
        .position-opt-btn.active {
            background: #0b4f6c !important;
            border-color: #0b4f6c !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(11, 79, 108, 0.25);
        }
        .position-clear-btn {
            cursor: pointer;
            border: 1px solid #dde3e8;
            background: #f8fafb;
            color: #5d6b77;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .position-clear-btn:hover {
            background: #eef1f4;
            color: #16212b;
        }

        /* Mobile Responsive Enhancements */
        @media (max-width: 768px) {
            .card-body.p-4 {
                padding: 16px !important;
            }
            .edit-card-header {
                padding: 12px 14px;
            }
            .edit-card-header h6 {
                font-size: 0.88rem;
            }
            .form-control,
            .form-select {
                font-size: 16px !important; /* Prevents auto zoom in on iOS Safari */
                padding: 9px 12px !important;
            }
            .position-opt-btn {
                padding: 6px 10px;
                font-size: 0.76rem;
            }
        }
    </style>

    <div class="container-fluid py-2">
        <!-- SIMC Convocation Header Banner -->
        <div class="card mb-4 border-radius-xl" style="background: #0f2533 !important; border: 1px solid #dde3e8; border-bottom: 3px solid #0b4f6c; box-shadow: 0 1px 3px rgba(16,24,40,0.08);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar avatar-xl rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 58px; height: 58px; background: #1b7aa3; color: #ffffff;">
                            <i class="fa fa-graduation-cap" style="font-size: 26px;"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span class="badge text-xxs fw-bold" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">{{ strtoupper($convocationSettings->convocation_title ?? 'FIRST CONVOCATION 2026') }}</span>
                            <small class="text-white-50 text-xxs">{{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 Nov 2026' }} &bull; {{ $convocationSettings->institution_name ?? 'Shahida Islam Medical Complex' }}</small>
                        </div>
                        <h4 class="text-white font-weight-bolder mb-1">{{ $studentRegistration->name ?? $user->name }}</h4>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge text-xxs" style="background: #1b7aa3; color: #ffffff;">
                                <i class="fa fa-id-badge me-1"></i> Roll No:
                                {{ $studentRegistration->roll_no_formatted ?? ($studentRegistration->roll_no ?? 'Not Assigned') }}
                            </span>
                            <span class="badge text-xxs" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">
                                <i class="fa fa-graduation-cap me-1"></i>
                                {{ $studentRegistration->department ?? ($user->department ?? 'MBBS') }}
                            </span>
                            @if(!empty($studentRegistration->uhs_registration_no))
                                <span class="badge text-xxs" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">
                                    Reg: {{ $studentRegistration->uhs_registration_no }}
                                </span>
                            @endif
                            @if(($studentRegistration->payment_status ?? 'unpaid') === 'paid')
                                <span class="badge text-xxs" style="background: #17693f; color: #fff;">Fee: Paid</span>
                            @elseif(($studentRegistration->payment_status ?? 'unpaid') === 'pending_verification')
                                <span class="badge text-xxs" style="background: #0b4f6c; color: #fff;">Fee: In Review</span>
                            @else
                                <span class="badge text-xxs" style="background: #7a5210; color: #fff;">Fee: Due</span>
                            @endif
                            <span class="text-xs text-white opacity-8 ms-2">
                                <i class="fa fa-envelope me-1"></i> {{ $user->email }}
                            </span>
                        </div>
                    </div>
                    <div class="col-auto mt-3 mt-md-0">
                        <div class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2 mb-2">
                                <span class="badge text-xxs px-3 py-2" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">
                                    Total: PKR {{ number_format($studentRegistration->fee_amount ?? ($convocationSettings->base_registration_fee ?? 15000)) }}
                                </span>
                                <span class="badge text-xxs px-3 py-2" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">
                                    <i class="fa fa-users me-1"></i> {{ $studentRegistration->guests_count ?? 0 }} Guest(s)
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="{{ route('student.challan') }}" class="btn btn-sm text-dark mb-0 py-1 px-3" style="background: #ffffff; border: 1px solid #c3ccd4; font-weight: 500;">
                                    <i class="fa fa-print me-1"></i> Bank Challan
                                </a>
                                <a href="{{ route('student.payment') }}" class="btn btn-sm text-white mb-0 py-1 px-3" style="background: #0b4f6c; font-weight: 500;">
                                    <i class="fa fa-credit-card me-1"></i> Pay Fee Proof
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Student Details Form -->
        <form id="editStudentDetailsForm" method="POST" action="{{ route('student.details.update') }}">
            @csrf

            <!-- Hidden inputs for Prof Positions JSON, Summary & Combined Address -->
            <input type="hidden" name="positions_data" id="positions_data" value="{{ is_array($studentRegistration->positions_data ?? null) ? json_encode($studentRegistration->positions_data) : ($studentRegistration->positions_data ?? '') }}">
            <input type="hidden" name="positions_summary" id="positions_summary" value="{{ $studentRegistration->positions_summary ?? '' }}">
            <input type="hidden" name="address" id="address" value="{{ $studentRegistration->address ?? $user->address }}">

            <div class="row">
                <!-- Left Column: Personal, Degree & Address Information -->
                <div class="col-lg-6">
                    <!-- Section 1: Basic Profile & Degree Program -->
                    <div class="edit-section-card">
                        <div class="edit-card-header">
                            <h6>
                                <i class="fa fa-user-circle text-primary"></i> 1. Student Personal & Degree Information
                            </h6>
                            <span class="badge bg-light text-secondary">Profile</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="field-label">Student Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $studentRegistration->name ?? $user->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Father Name <span class="text-danger">*</span></label>
                                    <input type="text" name="father_name" id="father_name" class="form-control"
                                        value="{{ old('father_name', $studentRegistration->father_name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Roll Number <span class="text-danger">*</span></label>
                                    <input type="text" name="roll_no" id="roll_no"
                                        class="form-control fw-bold"
                                        value="{{ old('roll_no', $studentRegistration->roll_no_formatted ?? $studentRegistration->roll_no) }}"
                                        placeholder="e.g. SIM-17-007" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">
                                        Email (Login ID) <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $studentRegistration->email ?? $user->email) }}"
                                        placeholder="student@example.com" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="field-label text-primary">
                                        <span><i class="fa fa-graduation-cap me-1"></i> Department / Degree Program</span> <span class="text-danger">*</span>
                                    </label>
                                    @php
                                        $selectedDept = old('department', $studentRegistration->department ?? ($user->department ?? 'MBBS'));
                                    @endphp
                                    <select name="department" id="department" class="form-select fw-bold" required onchange="handleDepartmentChange(this.value)">
                                        @if(isset($academicPrograms) && $academicPrograms->count() > 0)
                                            @foreach($academicPrograms as $program)
                                                <option value="{{ $program->code }}" {{ $selectedDept == $program->code ? 'selected' : '' }}>
                                                    {{ $program->code }} ({{ $program->total_profs }} Professional Years)
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="MBBS" {{ $selectedDept == 'MBBS' ? 'selected' : '' }}>MBBS (5 Professional Years)</option>
                                            <option value="BDS" {{ $selectedDept == 'BDS' ? 'selected' : '' }}>BDS (4 Professional Years)</option>
                                            <option value="Pharm-D" {{ $selectedDept == 'Pharm-D' ? 'selected' : '' }}>Pharm-D (5 Professional Years)</option>
                                            <option value="Nursing" {{ $selectedDept == 'Nursing' ? 'selected' : '' }}>BS Nursing (4 Professional Years)</option>
                                            <option value="DPT" {{ $selectedDept == 'DPT' ? 'selected' : '' }}>DPT (5 Professional Years)</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Admission Year <span class="text-danger">*</span></label>
                                    <input type="text" name="session" id="session" class="form-control"
                                        value="{{ old('session', $studentRegistration->session) }}" placeholder="e.g. 2018" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Graduation Year <span class="text-danger">*</span></label>
                                    <input type="text" name="class" id="class" class="form-control"
                                        value="{{ old('class', $studentRegistration->class) }}" placeholder="e.g. 2023" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="field-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_no" id="contact_no" class="form-control"
                                        value="{{ old('contact_no', $studentRegistration->contact_no ?? $user->contact_no) }}"
                                        placeholder="e.g. 03001234567" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="field-label text-danger">
                                        <span><i class="fa fa-phone-alt me-1"></i> Emergency Contact</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="emergency_contact_no" id="emergency_contact_no" class="form-control"
                                        value="{{ old('emergency_contact_no', $studentRegistration->emergency_contact_no ?? $user->emergency_contact_no) }}"
                                        placeholder="e.g. 03007654321" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="field-label">CNIC / B-Form <span class="text-danger">*</span></label>
                                    <input type="text" name="cnic" id="cnic" class="form-control cnic-mask"
                                        value="{{ old('cnic', $studentRegistration->cnic_formatted ?? ($studentRegistration->cnic ?? $user->cnic)) }}"
                                        placeholder="e.g. 35202-1234567-1" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Structured Residential Address -->
                    <div class="edit-section-card">
                        <div class="edit-card-header">
                            <h6>
                                <i class="fa fa-map-marker text-danger"></i> 2. Residential Address (Mandatory)
                            </h6>
                            <span class="badge bg-light text-secondary">Address</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="field-label">House / Flat / Building No. <span class="text-danger">*</span></label>
                                    <input type="text" name="house_no" id="house_no" class="form-control"
                                        value="{{ old('house_no', $studentRegistration->house_no) }}"
                                        placeholder="e.g. House # 12-B / Flat 4" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="field-label">Street / Sector / Block <span class="text-danger">*</span></label>
                                    <input type="text" name="street_address" id="street_address" class="form-control"
                                        value="{{ old('street_address', $studentRegistration->street_address) }}"
                                        placeholder="e.g. Street 4, Sector F-8/2" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="field-label">Area / Locality / Mohallah <span class="text-danger">*</span></label>
                                    <input type="text" name="area" id="area" class="form-control"
                                        value="{{ old('area', $studentRegistration->area) }}"
                                        placeholder="e.g. Johar Town / Blue Area" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">City / District <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        value="{{ old('city', $studentRegistration->city ?? ($studentRegistration->address ?? $user->address)) }}"
                                        placeholder="e.g. Lahore / Islamabad" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Province / Territory <span class="text-danger">*</span></label>
                                    @php
                                        $selectedProvince = old('province', $studentRegistration->province ?? 'Punjab');
                                    @endphp
                                    <select name="province" id="province" class="form-select" required>
                                        <option value="">-- Select Province --</option>
                                        <option value="Punjab" {{ $selectedProvince == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                        <option value="Sindh" {{ $selectedProvince == 'Sindh' ? 'selected' : '' }}>Sindh</option>
                                        <option value="Khyber Pakhtunkhwa" {{ $selectedProvince == 'Khyber Pakhtunkhwa' ? 'selected' : '' }}>Khyber Pakhtunkhwa</option>
                                        <option value="Balochistan" {{ $selectedProvince == 'Balochistan' ? 'selected' : '' }}>Balochistan</option>
                                        <option value="Islamabad Capital Territory" {{ $selectedProvince == 'Islamabad Capital Territory' ? 'selected' : '' }}>Islamabad Capital Territory</option>
                                        <option value="Azad Jammu & Kashmir" {{ $selectedProvince == 'Azad Jammu & Kashmir' ? 'selected' : '' }}>Azad Jammu & Kashmir</option>
                                        <option value="Gilgit-Baltistan" {{ $selectedProvince == 'Gilgit-Baltistan' ? 'selected' : '' }}>Gilgit-Baltistan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Council, Guests & Dynamic Prof Positions -->
                <div class="col-lg-6">
                    <!-- Section 3: University & Council Registration -->
                    <div class="edit-section-card">
                        <div class="edit-card-header">
                            <h6>
                                <i class="fa fa-hospital-o text-info"></i> 3. University & Council Registration
                            </h6>
                            <span class="badge bg-light text-secondary">Council</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="field-label">
                                        <span>University Registration Number</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="uhs_registration_no" id="uhs_registration_no"
                                        class="form-control text-uppercase font-monospace fw-bold"
                                        value="{{ old('uhs_registration_no', $studentRegistration->uhs_registration_no) }}"
                                        placeholder="2022-uhs-001" required>
                                    <small class="text-muted text-xxs">Format: 2022-uhs-001 (Dashes added automatically)</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">
                                        <span id="council_label_text">Council Registration</span> <span class="text-danger">*</span>
                                    </label>
                                    @php
                                        $selectedCouncil = old('council_type', $studentRegistration->council_type ?? 'PMDC');
                                    @endphp
                                    <div class="input-group">
                                        <select name="council_type" id="council_type" class="form-select flex-grow-0" style="max-width: 110px;" required onchange="handleCouncilTypeChange(this.value)">
                                            <option value="PMDC" {{ $selectedCouncil == 'PMDC' ? 'selected' : '' }}>PMDC</option>
                                            <option value="PNC" {{ $selectedCouncil == 'PNC' ? 'selected' : '' }}>PNC</option>
                                            <option value="PCP" {{ $selectedCouncil == 'PCP' ? 'selected' : '' }}>PCP</option>
                                            <option value="AHC" {{ $selectedCouncil == 'AHC' ? 'selected' : '' }}>AHC</option>
                                        </select>
                                        <input type="text" name="pmdc_registration_no" id="pmdc_registration_no"
                                            class="form-control text-uppercase font-monospace fw-bold"
                                            value="{{ old('pmdc_registration_no', $studentRegistration->pmdc_registration_no) }}"
                                            placeholder="e.g. 54321-P" required>
                                    </div>
                                    <small class="text-muted text-xxs" id="council_hint_text">Auto-formats according to council standard</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Accompanying Guests (Max 2 Allowed) -->
                    <div class="edit-section-card">
                        <div class="edit-card-header">
                            <h6>
                                <i class="fa fa-users text-primary"></i> 4. Accompanying Guests (Ceremony / Convocation)
                            </h6>
                            <span class="badge" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b7d6e6;">Max 2 Allowed</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <label class="field-label mb-0">
                                            <span>{{ $convocationSettings->guest_eligibility_notice ?? 'Only Mother, Father, Siblings OR Spouse' }} (Maximum {{ $convocationSettings->max_guests_allowed ?? 2 }} Allowed)</span> <span class="text-danger">*</span>
                                        </label>
                                        <span class="badge px-2 py-1 text-xxs font-monospace" id="live_fee_badge" style="background: #e3f3ea; color: #17693f; border: 1px solid #b8e2cb;">
                                            <i class="fa fa-receipt me-1"></i> Fee: PKR {{ number_format($studentRegistration->fee_amount ?? ($convocationSettings->base_registration_fee ?? 15000)) }}
                                        </span>
                                    </div>
                                    @php
                                        $currentGuestsCount = (int)old('guests_count', $studentRegistration->guests_count ?? 0);
                                        $baseFeeVal = (int)($convocationSettings->base_registration_fee ?? 15000);
                                        $guestFeeVal = (int)($convocationSettings->guest_fee_per_person ?? 5000);
                                    @endphp
                                    <select name="guests_count" id="guests_count" class="form-select fw-bold" required onchange="handleGuestCountChange(this.value)">
                                        <option value="0" {{ $currentGuestsCount === 0 ? 'selected' : '' }}>0 - No Guests (Fee: PKR {{ number_format($baseFeeVal) }})</option>
                                        <option value="1" {{ $currentGuestsCount === 1 ? 'selected' : '' }}>1 Guest (Fee: PKR {{ number_format($baseFeeVal + $guestFeeVal) }})</option>
                                        <option value="2" {{ $currentGuestsCount === 2 ? 'selected' : '' }}>2 Guests (Fee: PKR {{ number_format($baseFeeVal + (2 * $guestFeeVal)) }})</option>
                                    </select>
                                </div>

                                <!-- Guest 1 Block -->
                                <div class="col-12 guest-card" id="guest1_block" style="{{ $currentGuestsCount >= 1 ? 'display: block;' : 'display: none;' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="text-xs fw-bold text-primary mb-0">
                                            <i class="fa fa-user me-1"></i> Guest 1 Information
                                        </h6>
                                        <span class="badge bg-light text-dark text-xxs">Guest #1</span>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="field-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="guest1_name" id="guest1_name" class="form-control"
                                                value="{{ old('guest1_name', $studentRegistration->guest1_name) }}"
                                                placeholder="e.g. Muhammad Iqbal">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="field-label">CNIC <span class="text-danger">*</span></label>
                                            <input type="text" name="guest1_cnic" id="guest1_cnic" class="form-control cnic-mask"
                                                value="{{ old('guest1_cnic', $studentRegistration->guest1_cnic_formatted ?? $studentRegistration->guest1_cnic) }}"
                                                placeholder="e.g. 35202-1234567-1">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="field-label">Contact No <span class="text-danger">*</span></label>
                                            <input type="text" name="guest1_contact_no" id="guest1_contact_no" class="form-control"
                                                value="{{ old('guest1_contact_no', $studentRegistration->guest1_contact_no) }}"
                                                placeholder="e.g. 03001234567">
                                        </div>
                                    </div>
                                </div>

                                <!-- Guest 2 Block -->
                                <div class="col-12 guest-card" id="guest2_block" style="{{ $currentGuestsCount === 2 ? 'display: block;' : 'display: none;' }}">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="text-xs fw-bold text-primary mb-0">
                                            <i class="fa fa-user me-1"></i> Guest 2 Information
                                        </h6>
                                        <span class="badge bg-light text-dark text-xxs">Guest #2</span>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="field-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="guest2_name" id="guest2_name" class="form-control"
                                                value="{{ old('guest2_name', $studentRegistration->guest2_name) }}"
                                                placeholder="e.g. Fatima Bibi">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="field-label">CNIC <span class="text-danger">*</span></label>
                                            <input type="text" name="guest2_cnic" id="guest2_cnic" class="form-control cnic-mask"
                                                value="{{ old('guest2_cnic', $studentRegistration->guest2_cnic_formatted ?? $studentRegistration->guest2_cnic) }}"
                                                placeholder="e.g. 35202-7654321-2">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="field-label">Contact No <span class="text-danger">*</span></label>
                                            <input type="text" name="guest2_contact_no" id="guest2_contact_no" class="form-control"
                                                value="{{ old('guest2_contact_no', $studentRegistration->guest2_contact_no) }}"
                                                placeholder="e.g. 03217654321">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Degree Profs & Academic Positions (Pre-rendered) -->
                    @php
                        $deptProfsMapping = [];
                        if (isset($academicPrograms) && $academicPrograms->count() > 0) {
                            foreach ($academicPrograms as $prog) {
                                $deptProfsMapping[$prog->code] = [
                                    'profs' => $prog->profs_list,
                                    'council' => $prog->council_type,
                                    'placeholder' => $prog->council_placeholder,
                                ];
                            }
                        } else {
                            $deptProfsMapping = [
                                'MBBS' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', 'Final Prof'], 'council' => 'PMDC', 'placeholder' => '54321-P'],
                                'BDS' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', 'Final Prof'], 'council' => 'PMDC', 'placeholder' => '54321-P'],
                                'Pharm-D' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'], 'council' => 'PCP', 'placeholder' => '12345-PCP'],
                                'Nursing' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof'], 'council' => 'PNC', 'placeholder' => '12345-PNC'],
                                'DPT' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'], 'council' => 'AHC', 'placeholder' => '12345-AHC'],
                            ];
                        }
                    @endphp

                    <div class="edit-section-card">
                        <div class="edit-card-header">
                            <h6>
                                <i class="fa fa-trophy text-warning"></i> 5. Professional Examination Distinctions & Positions
                            </h6>
                            <span class="badge bg-warning text-dark">Distinctions</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                <div>
                                    <span class="badge bg-primary text-white text-xs px-3 py-2" id="current_dept_badge">
                                        Degree: {{ $selectedDept }}
                                    </span>
                                    <span class="text-xs text-secondary ms-1">
                                        Click your position in each Prof. (Leave as <em>None</em> if no position):
                                    </span>
                                </div>
                            </div>

                            <!-- Dynamic Profs Container (Pre-rendered in Blade) -->
                            <div id="dynamic_profs_container">
                                @foreach($deptProfsMapping as $deptKey => $deptInfo)
                                    @php
                                        $groupSafeKey = str_replace(['-', ' '], '_', $deptKey);
                                        $isGroupActive = ($selectedDept === $deptKey);
                                    @endphp
                                    <div class="dept-profs-group" id="profs_group_{{ $groupSafeKey }}"
                                         style="{{ $isGroupActive ? 'display: block;' : 'display: none;' }}">
                                        @foreach($deptInfo['profs'] as $prof)
                                            @php
                                                $safeProfId = strtolower(str_replace(['-', ' '], '_', $deptKey . '_' . $prof));
                                            @endphp
                                            <div class="prof-row-card" data-dept="{{ $deptKey }}" data-prof="{{ $prof }}" id="card_{{ $safeProfId }}">
                                                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
                                                    <div>
                                                        <h6 class="text-sm fw-bold text-dark mb-0">
                                                            <i class="fa fa-award text-primary me-1"></i> {{ $prof }}
                                                        </h6>
                                                        <small class="text-muted text-xxs">Select position if achieved, or leave as None</small>
                                                    </div>
                                                    <span class="badge bg-light text-secondary text-xxs">{{ $deptKey }}</span>
                                                </div>

                                                <div class="position-options-wrap d-flex flex-wrap gap-2 mt-2">
                                                    <button type="button" class="btn btn-sm position-opt-btn"
                                                        data-pos="1st Position" onclick="selectProfPosition(this, '{{ $prof }}', '1st Position')">
                                                        1st Position
                                                    </button>
                                                    <button type="button" class="btn btn-sm position-opt-btn"
                                                        data-pos="2nd Position" onclick="selectProfPosition(this, '{{ $prof }}', '2nd Position')">
                                                        2nd Position
                                                    </button>
                                                    <button type="button" class="btn btn-sm position-opt-btn"
                                                        data-pos="3rd Position" onclick="selectProfPosition(this, '{{ $prof }}', '3rd Position')">
                                                        3rd Position
                                                    </button>
                                                    <button type="button" class="btn btn-sm position-opt-btn"
                                                        data-pos="Subject Distinction" onclick="selectProfPosition(this, '{{ $prof }}', 'Subject Distinction')">
                                                        Subject Distinction
                                                    </button>
                                                    <button type="button" class="btn btn-sm position-clear-btn"
                                                        onclick="clearProfPosition(this, '{{ $prof }}')">
                                                        None
                                                    </button>
                                                </div>

                                                <div class="subject-input-wrap mt-3" id="subj_box_{{ $safeProfId }}" style="display: none;">
                                                    <div class="p-2 rounded bg-light border">
                                                        <label class="form-label text-xxs fw-bold text-dark mb-1">
                                                            <i class="fa fa-pencil text-primary me-1"></i> Enter Subject Name with Distinction:
                                                        </label>
                                                        <input type="text" class="form-control form-control-sm prof-subject-input"
                                                            placeholder="e.g. Anatomy, Physiology, Pharmacology, Medicine"
                                                            data-prof="{{ $prof }}"
                                                            oninput="handleSubjectInput('{{ $prof }}', this.value)">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <!-- Distinctions Summary Badge -->
                            <div class="mt-3 p-3 bg-light rounded border text-xs" id="positions_summary_badge">
                                <i class="fa fa-info-circle text-primary me-1"></i> <strong>Selected Positions:</strong>
                                <span id="summary_text" class="text-muted ms-1">No position selected (Optional)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Bar -->
                    <div class="card shadow-sm border p-3 mb-4" style="border-radius: 12px;">
                        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between gap-2">
                            <span class="text-xs text-muted mb-1 mb-sm-0">
                                <i class="fa fa-shield me-1 text-success"></i> Changes update your official academic record.
                            </span>
                            <button type="submit" id="btnUpdateDetails" class="btn text-white mb-0 px-4 py-2" style="background: #0b4f6c; font-weight: 500;">
                                <i class="fa fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function showNotification(type, message) {
            if (typeof toastr !== 'undefined' && toastr[type]) {
                toastr[type](message);
            } else {
                alert(message);
            }
        }

        // ==========================================
        // 1. GUEST COUNT SELECTION HANDLER (Native JS)
        // ==========================================
        function handleGuestCountChange(val) {
            var count = parseInt(val) || 0;
            var g1 = document.getElementById('guest1_block');
            var g2 = document.getElementById('guest2_block');

            var g1Name = document.getElementById('guest1_name');
            var g1Cnic = document.getElementById('guest1_cnic');
            var g1Contact = document.getElementById('guest1_contact_no');

            var g2Name = document.getElementById('guest2_name');
            var g2Cnic = document.getElementById('guest2_cnic');
            var g2Contact = document.getElementById('guest2_contact_no');

            if (g1) g1.style.display = (count >= 1) ? 'block' : 'none';
            if (g2) g2.style.display = (count >= 2) ? 'block' : 'none';

            if (g1Name) g1Name.required = (count >= 1);
            if (g1Cnic) g1Cnic.required = (count >= 1);
            if (g1Contact) g1Contact.required = (count >= 1);

            if (g2Name) g2Name.required = (count >= 2);
            if (g2Cnic) g2Cnic.required = (count >= 2);
            if (g2Contact) g2Contact.required = (count >= 2);

            var feeBadge = document.getElementById('live_fee_badge');
            if (feeBadge) {
                var baseFee = {{ (int)($convocationSettings->base_registration_fee ?? 15000) }};
                var guestFee = {{ (int)($convocationSettings->guest_fee_per_person ?? 5000) }};
                var calcFee = baseFee + (count * guestFee);
                var guestText = count === 0 ? 'Alone' : (count + ' Guest' + (count > 1 ? 's' : ''));
                feeBadge.innerHTML = '<i class="fa fa-receipt me-1"></i> Fee: PKR ' + calcFee.toLocaleString() + ' (' + guestText + ')';
            }
        }

        // ==========================================
        // 2. DEPARTMENT SELECTION HANDLER (Native JS)
        // ==========================================
        var deptCouncilMap = {
            @if(isset($academicPrograms) && $academicPrograms->count() > 0)
                @foreach($academicPrograms as $program)
                    '{{ $program->code }}': '{{ $program->council_type }}',
                @endforeach
            @else
                'MBBS': 'PMDC',
                'BDS': 'PMDC',
                'Pharm-D': 'PCP',
                'Nursing': 'PNC',
                'DPT': 'AHC'
            @endif
        };

        function handleDepartmentChange(dept) {
            if (!dept) dept = 'MBBS';

            // 1. Update current dept badge
            var badge = document.getElementById('current_dept_badge');
            if (badge) badge.innerText = 'Degree: ' + dept;

            // 2. Update council selector & labels
            var expectedCouncil = deptCouncilMap[dept] || 'PMDC';
            var councilSelect = document.getElementById('council_type');
            var councilLabel = document.getElementById('council_label_text');
            var councilInput = document.getElementById('pmdc_registration_no');

            if (councilSelect) councilSelect.value = expectedCouncil;
            if (councilLabel) councilLabel.innerText = 'Council Registration (' + expectedCouncil + ')';
            if (councilInput) {
                if (expectedCouncil === 'PMDC') councilInput.placeholder = 'e.g. 54321-P';
                else if (expectedCouncil === 'PNC') councilInput.placeholder = 'e.g. 12345-PNC';
                else if (expectedCouncil === 'PCP') councilInput.placeholder = 'e.g. 12345-PCP';
                else if (expectedCouncil === 'AHC') councilInput.placeholder = 'e.g. 12345-AHC';
            }

            // 3. Show matching profs group, hide others
            var groups = document.querySelectorAll('.dept-profs-group');
            groups.forEach(function (group) {
                group.style.display = 'none';
            });
            var targetGroup = document.getElementById('profs_group_' + dept.replace(/[^a-zA-Z0-9]/g, '_'));
            if (targetGroup) {
                targetGroup.style.display = 'block';
            }

            syncPositionsJsonAndSummary();
        }

        function handleCouncilTypeChange(cType) {
            var councilLabel = document.getElementById('council_label_text');
            if (councilLabel) councilLabel.innerText = 'Council Registration (' + cType + ')';
        }

        // ==========================================
        // 3. PROF POSITIONS SELECTION LOGIC
        // ==========================================
        var selectedProfPositions = {};

        // Parse any previously saved positions
        try {
            var rawPositions = document.getElementById('positions_data') ? document.getElementById('positions_data').value : '';
            if (rawPositions) {
                var parsed = JSON.parse(rawPositions);
                if (Array.isArray(parsed)) {
                    parsed.forEach(function (item) {
                        if (item.prof) {
                            var posVal = item.position || (item.overall_first ? '1st Position' : '');
                            var subjVal = item.subject || '';
                            if (!subjVal && Array.isArray(item.subjects) && item.subjects.length > 0) {
                                subjVal = item.subjects.join(', ');
                            }
                            selectedProfPositions[item.prof] = {
                                position: posVal,
                                subject: subjVal
                            };
                        }
                    });
                }
            }
        } catch (e) {
            selectedProfPositions = {};
        }

        function selectProfPosition(btn, prof, pos) {
            var card = btn.closest('.prof-row-card');
            if (!card) return;

            // Remove active from all position buttons in this card
            var allBtns = card.querySelectorAll('.position-opt-btn');
            allBtns.forEach(function (b) {
                b.classList.remove('active');
            });

            // Activate clicked button
            btn.classList.add('active');

            // Handle subject distinction box
            var subjBox = card.querySelector('.subject-input-wrap');
            var subjInput = card.querySelector('.prof-subject-input');
            var currentSubjVal = subjInput ? subjInput.value.trim() : '';

            if (pos === 'Subject Distinction') {
                if (subjBox) subjBox.style.display = 'block';
                if (subjInput) subjInput.focus();
            } else {
                if (subjBox) subjBox.style.display = 'none';
            }

            selectedProfPositions[prof] = {
                position: pos,
                subject: currentSubjVal
            };

            syncPositionsJsonAndSummary();
        }

        function clearProfPosition(btn, prof) {
            var card = btn.closest('.prof-row-card');
            if (!card) return;

            var allBtns = card.querySelectorAll('.position-opt-btn');
            allBtns.forEach(function (b) {
                b.classList.remove('active');
            });

            var subjBox = card.querySelector('.subject-input-wrap');
            if (subjBox) subjBox.style.display = 'none';
            var subjInput = card.querySelector('.prof-subject-input');
            if (subjInput) subjInput.value = '';

            delete selectedProfPositions[prof];
            syncPositionsJsonAndSummary();
        }

        function handleSubjectInput(prof, val) {
            if (selectedProfPositions[prof]) {
                selectedProfPositions[prof].subject = val;
            } else {
                selectedProfPositions[prof] = {
                    position: 'Subject Distinction',
                    subject: val
                };
            }
            syncPositionsJsonAndSummary();
        }

        function syncPositionsJsonAndSummary() {
            var result = [];
            var summaryParts = [];

            var deptSelect = document.getElementById('department');
            var currentDept = deptSelect ? deptSelect.value : 'MBBS';
            var activeGroup = document.getElementById('profs_group_' + currentDept.replace(/[^a-zA-Z0-9]/g, '_'));
            var allowedProfs = [];

            if (activeGroup) {
                activeGroup.querySelectorAll('.prof-row-card').forEach(function (card) {
                    allowedProfs.push(card.getAttribute('data-prof'));
                });
            }

            for (var prof in selectedProfPositions) {
                if (allowedProfs.length > 0 && allowedProfs.indexOf(prof) === -1) continue;

                var item = selectedProfPositions[prof];
                if (item && item.position) {
                    result.push({
                        prof: prof,
                        position: item.position,
                        subject: item.subject || ''
                    });

                    var label = prof + ': ' + item.position;
                    if (item.position === 'Subject Distinction' && item.subject) {
                        label += ' (' + item.subject + ')';
                    }
                    summaryParts.push(label);
                }
            }

            var hiddenData = document.getElementById('positions_data');
            var hiddenSummary = document.getElementById('positions_summary');
            var summaryText = document.getElementById('summary_text');

            if (hiddenData) hiddenData.value = JSON.stringify(result);
            var summaryStr = summaryParts.length > 0 ? summaryParts.join(' | ') : 'No position selected (Optional)';
            if (hiddenSummary) hiddenSummary.value = summaryParts.join('; ');
            if (summaryText) summaryText.innerText = summaryStr;
        }

        // ==========================================
        // 4. AUTO-FORMAT CNIC (35202-1234567-1)
        // ==========================================
        function formatCnicValue(raw) {
            var val = (raw || '').replace(/\D/g, '');
            if (val.length > 13) val = val.substring(0, 13);
            var formatted = '';
            if (val.length > 5) {
                formatted += val.substring(0, 5) + '-';
                if (val.length > 12) {
                    formatted += val.substring(5, 12) + '-' + val.substring(12, 13);
                } else {
                    formatted += val.substring(5);
                }
            } else {
                formatted = val;
            }
            return formatted;
        }

        document.addEventListener('input', function (e) {
            if (e.target && (e.target.id === 'cnic' || e.target.classList.contains('cnic-mask'))) {
                e.target.value = formatCnicValue(e.target.value);
            }
        });

        // ==========================================
        // 5. UNIVERSITY REGISTRATION NUMBER (2022-uhs-001)
        // ==========================================
        function formatUniversityReg(val) {
            if (!val) return '';
            var clean = val.replace(/[^a-zA-Z0-9]/g, '');
            var formatted = '';

            if (clean.length > 0) {
                formatted += clean.substring(0, Math.min(4, clean.length));
            }
            if (clean.length > 4) {
                var rest = clean.substring(4);
                var match = rest.match(/^([a-zA-Z]{1,4})(.*)$/);
                if (match) {
                    formatted += '-' + match[1].toLowerCase();
                    if (match[2]) {
                        formatted += '-' + match[2];
                    }
                } else {
                    formatted += '-' + rest;
                }
            }
            return formatted;
        }

        var uhsInput = document.getElementById('uhs_registration_no');
        if (uhsInput) {
            uhsInput.addEventListener('input', function () {
                this.value = formatUniversityReg(this.value);
            });
        }

        // ==========================================
        // 6. COUNCIL REGISTRATION AUTO-FORMAT
        // ==========================================
        function formatCouncilReg(val) {
            if (!val) return '';
            var clean = val.replace(/[^a-zA-Z0-9]/g, '');

            var matchDigits = clean.match(/^(\d{3,7})([a-zA-Z0-9]{1,6})?$/);
            if (matchDigits) {
                var res = matchDigits[1];
                if (matchDigits[2]) {
                    res += '-' + matchDigits[2].toUpperCase();
                }
                return res;
            }

            var matchLetters = clean.match(/^([a-zA-Z]{2,6})(\d{1,8})([a-zA-Z])?$/);
            if (matchLetters) {
                var res = matchLetters[1].toUpperCase() + '-' + matchLetters[2];
                if (matchLetters[3]) {
                    res += '-' + matchLetters[3].toUpperCase();
                }
                return res;
            }

            return val.toUpperCase();
        }

        var pmdcInput = document.getElementById('pmdc_registration_no');
        if (pmdcInput) {
            pmdcInput.addEventListener('input', function () {
                this.value = formatCouncilReg(this.value);
            });
        }

        // ==========================================
        // 7. COMBINED RESIDENTIAL ADDRESS SYNC
        // ==========================================
        function updateCombinedAddress() {
            var parts = [];
            var house = document.getElementById('house_no') ? document.getElementById('house_no').value.trim() : '';
            var street = document.getElementById('street_address') ? document.getElementById('street_address').value.trim() : '';
            var area = document.getElementById('area') ? document.getElementById('area').value.trim() : '';
            var city = document.getElementById('city') ? document.getElementById('city').value.trim() : '';
            var province = document.getElementById('province') ? document.getElementById('province').value.trim() : '';

            if (house) parts.push('House/Flat: ' + house);
            if (street) parts.push('Street: ' + street);
            if (area) parts.push('Area: ' + area);
            if (city) parts.push(city);
            if (province) parts.push(province);

            var addressField = document.getElementById('address');
            if (addressField) addressField.value = parts.join(', ');
        }

        ['house_no', 'street_address', 'area', 'city', 'province'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', updateCombinedAddress);
                el.addEventListener('change', updateCombinedAddress);
            }
        });

        // Initialize state on page load
        document.addEventListener('DOMContentLoaded', function () {
            var currentGuestsCount = document.getElementById('guests_count') ? document.getElementById('guests_count').value : '0';
            handleGuestCountChange(currentGuestsCount);

            var currentDept = document.getElementById('department') ? document.getElementById('department').value : 'MBBS';
            handleDepartmentChange(currentDept);

            // Restore any active saved positions
            for (var prof in selectedProfPositions) {
                var item = selectedProfPositions[prof];
                var card = document.querySelector('.prof-row-card[data-prof="' + prof + '"]');
                if (card && item && item.position) {
                    var btn = card.querySelector('.position-opt-btn[data-pos="' + item.position + '"]');
                    if (btn) btn.classList.add('active');

                    if (item.position === 'Subject Distinction') {
                        var subjBox = card.querySelector('.subject-input-wrap');
                        var subjInput = card.querySelector('.prof-subject-input');
                        if (subjBox) subjBox.style.display = 'block';
                        if (subjInput && item.subject) subjInput.value = item.subject;
                    }
                }
            }
            syncPositionsJsonAndSummary();
        });

        // ==========================================
        // 8. AJAX FORM SUBMISSION FOR EDIT FORM
        // ==========================================
        var editForm = document.getElementById('editStudentDetailsForm');
        if (editForm) {
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                syncPositionsJsonAndSummary();
                updateCombinedAddress();

                var btn = document.getElementById('btnUpdateDetails');
                var originalBtnHtml = btn ? btn.innerHTML : '';

                // Client-side required validation
                var name = document.getElementById('name') ? document.getElementById('name').value.trim() : '';
                var email = document.getElementById('email') ? document.getElementById('email').value.trim() : '';
                var contact = document.getElementById('contact_no') ? document.getElementById('contact_no').value.trim() : '';
                var emergency = document.getElementById('emergency_contact_no') ? document.getElementById('emergency_contact_no').value.trim() : '';
                var cnic = document.getElementById('cnic') ? document.getElementById('cnic').value.trim() : '';
                var rollNo = document.getElementById('roll_no') ? document.getElementById('roll_no').value.trim() : '';
                var fatherName = document.getElementById('father_name') ? document.getElementById('father_name').value.trim() : '';
                var dept = document.getElementById('department') ? document.getElementById('department').value : '';
                var session = document.getElementById('session') ? document.getElementById('session').value.trim() : '';
                var gradYear = document.getElementById('class') ? document.getElementById('class').value.trim() : '';
                var houseNo = document.getElementById('house_no') ? document.getElementById('house_no').value.trim() : '';
                var street = document.getElementById('street_address') ? document.getElementById('street_address').value.trim() : '';
                var area = document.getElementById('area') ? document.getElementById('area').value.trim() : '';
                var city = document.getElementById('city') ? document.getElementById('city').value.trim() : '';
                var province = document.getElementById('province') ? document.getElementById('province').value : '';
                var uhsReg = document.getElementById('uhs_registration_no') ? document.getElementById('uhs_registration_no').value.trim() : '';
                var pmdcReg = document.getElementById('pmdc_registration_no') ? document.getElementById('pmdc_registration_no').value.trim() : '';

                if (!name || !email || !contact || !emergency || !cnic || !rollNo ||
                    !fatherName || !dept || !session || !gradYear || !houseNo || !street ||
                    !area || !city || !province || !uhsReg || !pmdcReg) {
                    showNotification('warning', 'Please fill in all mandatory fields marked with an asterisk (*).');
                    return;
                }

                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Saving Changes...';
                }

                var formData = new FormData(editForm);
                var tokenMeta = document.querySelector('meta[name="csrf-token"]');
                var csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

                fetch(editForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function (res) {
                    return res.json().then(function (data) {
                        return { status: res.status, ok: res.ok, data: data };
                    });
                })
                .then(function (result) {
                    if (result.ok && result.data.success) {
                        showNotification('success', result.data.message || 'Details updated successfully!');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    } else {
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = originalBtnHtml;
                        }
                        if (result.data.errors) {
                            var firstKey = Object.keys(result.data.errors)[0];
                            showNotification('error', result.data.errors[firstKey][0]);
                        } else {
                            showNotification('error', result.data.message || 'Update failed');
                        }
                    }
                })
                .catch(function (err) {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                    }
                    showNotification('error', 'Error updating details. Please try again.');
                });
            });
        }
    </script>

@endsection
