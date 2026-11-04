<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration - First Convocation 2026 | Shahida Islam Medical Complex</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Local jQuery with CDN fallback -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
        }
    </script>

    <style>
        :root {
            --bg: #f4f6f8;
            --surface: #ffffff;
            --border: #dde3e8;
            --border-strong: #c3ccd4;
            --text: #16212b;
            --text-2: #3d4b57;
            --muted: #5d6b77;
            --primary: #0b4f6c;
            --primary-hover: #093f57;
            --primary-soft: #e3eff5;
            --focus: #1f7fb0;
            --sidebar-bg: #0f2533;
            --radius-sm: 6px;
            --radius: 8px;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', "Segoe UI", system-ui, -apple-system, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .registration-container {
            max-width: 1100px;
            margin: 25px auto 60px auto;
        }

        /* Official Announcement Banner Card */
        .hero-banner-card {
            background: var(--sidebar-bg);
            border-radius: 10px;
            color: #ffffff;
            padding: 28px 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(16, 24, 40, 0.08);
            border: 1px solid var(--border);
            border-bottom: 3px solid var(--primary);
            position: relative;
            overflow: hidden;
        }

        .simc-logo-badge {
            width: 54px;
            height: 54px;
            background: #1b7aa3;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        /* Priority Cards */
        .priority-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .priority-box {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 16px 18px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
            border-left: 4px solid var(--primary);
        }

        .priority-box.priority-2 {
            border-left-color: #8a5a0b;
        }

        .form-section-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(16, 24, 40, 0.05);
            margin-bottom: 20px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .section-header {
            padding: 13px 20px;
            background: #f8fafb;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-header h5 {
            margin: 0;
            font-size: 0.96rem;
            font-weight: 700;
            color: #0f2533;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-body {
            padding: 22px 24px;
        }

        .field-label {
            font-size: 0.80rem;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-strong) !important;
            border-radius: var(--radius-sm) !important;
            padding: 9px 12px !important;
            font-size: 0.88rem !important;
            color: var(--text) !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(11, 79, 108, 0.15) !important;
            outline: none !important;
        }

        .guest-card {
            background: #f8fafb;
            border: 1px dashed #a4b8c6;
            border-radius: var(--radius);
            padding: 16px;
            margin-top: 12px;
        }

        .prof-row-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .position-opt-btn {
            cursor: pointer;
            border: 1px solid var(--border-strong);
            background: var(--surface);
            color: var(--text-2);
            padding: 6px 13px;
            border-radius: var(--radius-sm);
            font-size: 0.80rem;
            font-weight: 500;
            transition: all 0.15s ease;
            user-select: none;
        }

        .position-opt-btn:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
            color: var(--primary);
        }

        .position-opt-btn.active {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(11, 79, 108, 0.25);
        }

        .position-clear-btn {
            cursor: pointer;
            border: 1px solid var(--border);
            background: #f8fafb;
            color: var(--muted);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.78rem;
        }
        .position-clear-btn:hover {
            background: #eef1f4;
            color: var(--text);
        }

        .btn-register-submit {
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 12px 24px;
            font-size: 0.92rem;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(11, 79, 108, 0.2);
            transition: background 0.15s ease;
        }

        .btn-register-submit:hover {
            background: var(--primary-hover);
            color: #ffffff;
        }

        .focal-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px;
        }

        /* Mobile Responsive Enhancements */
        @media (max-width: 768px) {
            .registration-container {
                margin: 12px auto 40px auto;
                padding-left: 10px;
                padding-right: 10px;
            }

            .hero-banner-card {
                padding: 18px 16px;
                border-radius: 8px;
            }

            .hero-banner-card h1.display-6 {
                font-size: 1.45rem !important;
                line-height: 1.25;
            }

            .simc-logo-badge {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
            }

            .section-header {
                padding: 11px 14px;
            }

            .section-header h5 {
                font-size: 0.88rem;
            }

            .section-body {
                padding: 15px 14px;
            }

            .guest-card {
                padding: 12px;
            }

            .prof-row-card {
                padding: 12px;
            }

            .position-opt-btn {
                padding: 6px 10px;
                font-size: 0.76rem;
            }

            .form-control,
            .form-select {
                font-size: 16px !important;
                padding: 10px 12px !important;
            }

            .btn-register-submit {
                width: 100%;
                padding: 13px 16px;
                font-size: 0.90rem;
            }
        }

        @media (max-width: 480px) {
            .hero-banner-card h1.display-6 {
                font-size: 1.35rem !important;
            }
            .hero-banner-card h3 {
                font-size: 1.1rem !important;
            }
            .priority-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container registration-container">
        <!-- Official Convocation Header Banner (Dynamic from Database) -->
        <div class="hero-banner-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="simc-logo-badge">
                            <i class="fa fa-university"></i>
                        </div>
                        <div>
                            <span class="badge text-xxs font-weight-bold px-2 py-1 mb-1" style="background: rgba(255,255,255,0.15); color: #fff;">OFFICIAL ANNOUNCEMENT</span>
                            <h3 class="text-white fw-bold mb-0" style="letter-spacing: 0.5px;">{{ $convocationSettings->institution_name ?? 'Shahida Islam Medical Complex' }}</h3>
                            <small class="text-white-50 text-xs">
                                {{ $convocationSettings->institution_tagline ?? 'Together for Excellence in Healthcare Education' }}
                            </small>
                        </div>
                    </div>

                    <h1 class="text-white fw-bold display-6 mb-2">
                        {{ $convocationSettings->convocation_title ?? 'FIRST CONVOCATION 2026' }}
                    </h1>
                    <p class="text-white opacity-9 text-xs mb-3" style="max-width: 600px;">
                        <em>"{{ $convocationSettings->slogan ?? 'A Proud Milestone in Our Journey' }}"</em>
                        <br>
                        {{ $convocationSettings->portal_announcement ?? 'Bringing together the pioneering graduating batches to celebrate their academic achievements.' }}
                    </p>

                    <div class="d-flex flex-wrap gap-2 text-xs">
                        <span class="badge text-white px-3 py-2" style="background: #152f40; border: 1px solid #234359;">
                            <i class="fa fa-calendar-alt text-info me-1"></i> {{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 November 2026' }}
                        </span>
                        <span class="badge text-white px-3 py-2" style="background: #1a3c54; border: 1px solid #285575;">
                            <i class="fa fa-hourglass-half me-1"></i> Last Date: {{ $convocationSettings->registration_deadline_formatted ?? '15 November 2026' }}
                        </span>
                        <a href="{{ $convocationSettings->official_website ?? 'https://simc.edu.pk' }}" target="_blank" class="badge text-white px-3 py-2 text-decoration-none" style="background: #1b7aa3;">
                            <i class="fa fa-globe me-1"></i> {{ parse_url($convocationSettings->official_website ?? 'https://simc.edu.pk', PHP_URL_HOST) ?? 'simc.edu.pk' }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <small class="text-white-50 text-xxs fw-bold text-uppercase d-block mb-1">Registration Fee</small>
                        <h2 class="text-white fw-bold mb-0">PKR {{ number_format($convocationSettings->base_registration_fee ?? 15000) }}</h2>
                        <small class="text-white-50 text-xxs d-block mb-2">{{ ucfirst($convocationSettings->gown_included_notice ?? 'Including Convocation Gown') }}</small>
                        <hr class="my-2" style="border-color: rgba(255,255,255,0.15);">
                        <small class="text-white-50 text-xxs d-block">
                            Accompanying Guests: <strong>PKR {{ number_format($convocationSettings->guest_fee_per_person ?? 5000) }} / guest</strong> (Max {{ $convocationSettings->max_guests_allowed ?? 2 }})
                            <br>
                            <span class="text-white-50">{{ $convocationSettings->allowed_guest_relations ?? 'Parents & Siblings strictly allowed only' }}</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Eligibility and Registration Priority Banner (Dynamic from Database) -->
        <div class="priority-grid">
            <!-- Box 1: Priority Registration -->
            <div class="priority-box priority-1">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge text-white rounded-circle" style="background: #0b4f6c; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.70rem;">1</span>
                    <h6 class="fw-bold text-dark mb-0 text-sm">Priority Registration ({{ $convocationSettings->priority_sessions ?? '2021, 2022 & 2023' }})</h6>
                </div>
                <p class="text-xs text-secondary mb-0">
                    {{ $convocationSettings->priority_notice ?? 'All graduates who passed their Final Professional Examinations in priority sessions are given priority and guaranteed participation in the Convocation upon registration.' }}
                </p>
            </div>

            <!-- Box 2: Provisional Registration -->
            <div class="priority-box priority-2">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge text-white rounded-circle" style="background: #8a5a0b; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.70rem;">2</span>
                    <h6 class="fw-bold text-dark mb-0 text-sm">Provisional Registration (Session {{ $convocationSettings->provisional_sessions ?? '2024' }})</h6>
                </div>
                <p class="text-xs text-secondary mb-0">
                    {{ $convocationSettings->provisional_notice ?? 'Graduates of 2024 are invited to register provisionally. Participation will depend on seat availability after earlier batches have been accommodated.' }}
                </p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger text-white alert-dismissible fade show shadow-sm mb-4" role="alert"
                style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                    <i class="material-symbols-rounded me-2">error</i>
                    <div>
                        <strong>Please resolve the following errors:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form id="studentRegistrationForm" method="POST" action="{{ route('register.store') }}" novalidate>
            @csrf

            <!-- Hidden Inputs for Profs 1st Positions & Address Sync -->
            <input type="hidden" name="positions_data" id="positions_data" value="{{ old('positions_data', '') }}">
            <input type="hidden" name="positions_summary" id="positions_summary" value="{{ old('positions_summary', '') }}">
            <input type="hidden" name="address" id="address" value="{{ old('address', '') }}">

            <!-- ========================================== -->
            <!-- SECTION 1: ACCOUNT & LOGIN CREDENTIALS     -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-user-lock text-primary"></i>
                        1. Account & Login Credentials
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 1 of 6</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="field-label">Student Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                placeholder="e.g. Dr. Muhammad Ali" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Email Address (Used for Login & Official Alerts) <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                                placeholder="doctor@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Create Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Minimum 6 characters" required>
                        </div>
                        <div class="col-md-6">
                            <label class="field-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Re-type password" required>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Contact / Mobile Number (11 Digits) <span class="text-danger">*</span></label>
                            <input type="tel" name="contact_no" id="contact_no" class="form-control phone-11-mask font-monospace"
                                value="{{ old('contact_no') }}" placeholder="03001234567" maxlength="11" minlength="11" pattern="[0-9]{11}" required>
                            <small id="contact_no_hint" class="text-xxs d-block mt-1 text-muted">Must be strictly 11 digits (e.g. 03001234567)</small>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label text-danger">
                                <span><i class="fa fa-phone-alt me-1"></i> Emergency Contact (11 Digits)</span> <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="emergency_contact_no" id="emergency_contact_no"
                                class="form-control phone-11-mask font-monospace" value="{{ old('emergency_contact_no') }}"
                                placeholder="03007654321" maxlength="11" minlength="11" pattern="[0-9]{11}" required>
                            <small id="emergency_contact_no_hint" class="text-xxs d-block mt-1 text-muted">Must be strictly 11 digits (e.g. 03007654321)</small>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">CNIC / B-Form Number <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" id="cnic" class="form-control cnic-mask"
                                value="{{ old('cnic') }}" placeholder="e.g. 35202-1234567-1" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 2: STUDENT PROFILE & DEGREE INFO   -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-graduation-cap text-info"></i>
                        2. Academic Degree & Final Prof Examination Batch
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 2 of 6</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="field-label">College Roll Number <span class="text-danger">*</span></label>
                            <input type="text" name="roll_no" id="roll_no" class="form-control font-monospace"
                                value="{{ old('roll_no') }}" placeholder="e.g. SIMC-17-045" required>
                        </div>

                        <div class="col-md-4">
                            <label class="field-label">Father's Name <span class="text-danger">*</span></label>
                            <input type="text" name="father_name" id="father_name" class="form-control"
                                value="{{ old('father_name') }}" placeholder="e.g. Muhammad Iqbal Khan" required>
                        </div>

                        <div class="col-md-4">
                            <label class="field-label text-primary">
                                <span><i class="fa fa-clinic-medical me-1"></i> College & Department</span> <span class="text-danger">*</span>
                            </label>
                            @php
                                $currentDept = old('department', 'MBBS');
                            @endphp
                            <select name="department" id="department" class="form-select fw-bold" required onchange="handleDepartmentChange(this.value)">
                                @if(!empty($academicPrograms) && count($academicPrograms) > 0)
                                    @foreach($academicPrograms as $prog)
                                        <option value="{{ $prog->code }}" {{ $currentDept == $prog->code ? 'selected' : '' }}>
                                            {{ $prog->college_name }} ({{ $prog->degree_title }} - {{ $prog->total_profs }} Profs)
                                        </option>
                                    @endforeach
                                @else
                                    <option value="MBBS" {{ $currentDept == 'MBBS' ? 'selected' : '' }}>Shahida Islam Medical College (MBBS - 5 Profs)</option>
                                    <option value="BDS" {{ $currentDept == 'BDS' ? 'selected' : '' }}>Shahida Islam Dental College (BDS - 4 Profs)</option>
                                    <option value="Pharm-D" {{ $currentDept == 'Pharm-D' ? 'selected' : '' }}>Faculty of Pharmacy (Pharm-D - 5 Profs)</option>
                                    <option value="Nursing" {{ $currentDept == 'Nursing' ? 'selected' : '' }}>College of Nursing (BS Nursing - 4 Profs)</option>
                                    <option value="DPT" {{ $currentDept == 'DPT' ? 'selected' : '' }}>Department of Physical Therapy (DPT - 5 Profs)</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">
                                <span>Admission Year / Session</span> <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="session" id="session" class="form-control"
                                value="{{ old('session', '2016') }}" placeholder="e.g. 2016" required>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label text-dark">
                                <span>Final Prof Exam Passing Session (Graduation Year)</span> <span class="text-danger">*</span>
                            </label>
                            @php
                                $selectedClass = old('class', '2022');
                            @endphp
                            <select name="class" id="class" class="form-select fw-bold" required>
                                <option value="2021" {{ $selectedClass == '2021' ? 'selected' : '' }}>2021 Passing Session (Priority Registration Batch)</option>
                                <option value="2022" {{ $selectedClass == '2022' ? 'selected' : '' }}>2022 Passing Session (Priority Registration Batch)</option>
                                <option value="2023" {{ $selectedClass == '2023' ? 'selected' : '' }}>2023 Passing Session (Priority Registration Batch)</option>
                                <option value="2024" {{ $selectedClass == '2024' ? 'selected' : '' }}>2024 Passing Session (Provisional Registration Batch)</option>
                            </select>
                            <small class="text-muted text-xxs">Batches 2021, 2022 & 2023 have priority registration. Batch 2024 registers provisionally.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 3: STRUCTURED RESIDENTIAL ADDRESS  -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-location-dot text-danger"></i>
                        3. Residential Address (For Official Convocation Invitation Mailing)
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 3 of 6</span>
                </div>
                <div class="section-body">
                    <p class="text-xs text-secondary mb-3">
                        Please provide your structured postal address where convocation passes and invitation cards can be dispatched.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="field-label">House / Flat / Building No. <span class="text-danger">*</span></label>
                            <input type="text" name="house_no" id="house_no" class="form-control"
                                value="{{ old('house_no') }}" placeholder="e.g. House # 12-B / Flat 4" required>
                        </div>

                        <div class="col-md-4">
                            <label class="field-label">Street / Road / Block / Sector <span class="text-danger">*</span></label>
                            <input type="text" name="street_address" id="street_address" class="form-control"
                                value="{{ old('street_address') }}" placeholder="e.g. Street 4, Sector F-8/2" required>
                        </div>

                        <div class="col-md-4">
                            <label class="field-label">Area / Locality / Mohallah <span class="text-danger">*</span></label>
                            <input type="text" name="area" id="area" class="form-control"
                                value="{{ old('area') }}" placeholder="e.g. Model Town / Johar Town" required>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">City / District <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="city" class="form-control"
                                value="{{ old('city') }}" placeholder="e.g. Lodhran / Multan / Lahore" required>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">Province / Territory <span class="text-danger">*</span></label>
                            @php
                                $currentProvince = old('province', 'Punjab');
                            @endphp
                            <select name="province" id="province" class="form-select" required>
                                <option value="">-- Select Province --</option>
                                <option value="Punjab" {{ $currentProvince == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="Sindh" {{ $currentProvince == 'Sindh' ? 'selected' : '' }}>Sindh</option>
                                <option value="Khyber Pakhtunkhwa" {{ $currentProvince == 'Khyber Pakhtunkhwa' ? 'selected' : '' }}>Khyber Pakhtunkhwa</option>
                                <option value="Balochistan" {{ $currentProvince == 'Balochistan' ? 'selected' : '' }}>Balochistan</option>
                                <option value="Islamabad Capital Territory" {{ $currentProvince == 'Islamabad Capital Territory' ? 'selected' : '' }}>Islamabad Capital Territory</option>
                                <option value="Azad Jammu & Kashmir" {{ $currentProvince == 'Azad Jammu & Kashmir' ? 'selected' : '' }}>Azad Jammu & Kashmir</option>
                                <option value="Gilgit-Baltistan" {{ $currentProvince == 'Gilgit-Baltistan' ? 'selected' : '' }}>Gilgit-Baltistan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- SECTION 4: UNIVERSITY & COUNCIL REGISTRATION -->
            <!-- ========================================== -->
            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-file-medical text-warning"></i>
                        4. University (UHS) & Council Registration
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 4 of 6</span>
                </div>
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="field-label">
                                <span>University Registration Number</span> <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="uhs_registration_no" id="uhs_registration_no" class="form-control text-uppercase font-monospace fw-bold"
                                value="{{ old('uhs_registration_no') }}" placeholder="2022-uhs-001" required>
                            <small class="text-muted text-xxs">Format: 2022-uhs-001 (Dashes are added automatically)</small>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label">
                                <span id="council_label_text">Council Registration (PMDC)</span> <span class="text-danger">*</span>
                            </label>
                            @php
                                $currentCouncil = old('council_type', 'PMDC');
                            @endphp
                            <div class="input-group">
                                <select name="council_type" id="council_type" class="form-select flex-grow-0" style="max-width: 110px;" required onchange="handleCouncilTypeChange(this.value)">
                                    <option value="PMDC" {{ $currentCouncil == 'PMDC' ? 'selected' : '' }}>PMDC</option>
                                    <option value="PNC" {{ $currentCouncil == 'PNC' ? 'selected' : '' }}>PNC</option>
                                    <option value="PCP" {{ $currentCouncil == 'PCP' ? 'selected' : '' }}>PCP</option>
                                    <option value="AHC" {{ $currentCouncil == 'AHC' ? 'selected' : '' }}>AHC</option>
                                </select>
                                <input type="text" name="pmdc_registration_no" id="pmdc_registration_no"
                                    class="form-control text-uppercase font-monospace fw-bold" value="{{ old('pmdc_registration_no') }}"
                                    placeholder="e.g. 54321-P" required>
                            </div>
                            <small class="text-muted text-xxs" id="council_hint_text">Auto-formats according to the council standard</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- SECTION 5: ACCOMPANYING GUESTS (STRICT POLICY: PARENTS/SIBLINGS) -->
            <!-- ======================================================== -->
            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-users text-primary"></i>
                        5. Accompanying Guests (Ceremony & Convocation Pass)
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 5 of 6</span>
                </div>
                <div class="section-body">
                    <!-- Policy Alert Box (Dynamic from Database) -->
                    <div class="alert alert-warning text-dark border p-3 mb-3" style="border-radius: 10px; font-size: 0.8rem;">
                        <i class="fa fa-info-circle text-dark me-2"></i>
                        <strong>Eligible Guests Policy:</strong> {{ $convocationSettings->allowed_guest_relations ?? 'Strictly immediate family members only: Parents and Siblings.' }}
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="field-label mb-0">
                                    <span>Select Number of Guests (Maximum {{ $convocationSettings->max_guests_allowed ?? 2 }} Guests Allowed)</span> <span class="text-danger">*</span>
                                </label>
                                <span class="badge text-xxs font-monospace px-2 py-1" id="live_fee_badge" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b2d4e5;">
                                    Fee: PKR {{ number_format($convocationSettings->base_registration_fee ?? 15000) }} (Graduate Alone)
                                </span>
                            </div>
                            @php
                                $currentGuestsCount = (int)old('guests_count', 0);
                                $baseFeeVal = (int)($convocationSettings->base_registration_fee ?? 15000);
                                $guestFeeVal = (int)($convocationSettings->guest_fee_per_person ?? 5000);
                            @endphp
                            <select name="guests_count" id="guests_count" class="form-select fw-bold" required onchange="handleGuestCountChange(this.value)">
                                <option value="0" {{ $currentGuestsCount === 0 ? 'selected' : '' }}>0 Guests - Graduate Alone (Fee: PKR {{ number_format($baseFeeVal) }})</option>
                                <option value="1" {{ $currentGuestsCount === 1 ? 'selected' : '' }}>1 Guest (Parents / Sibling) - (Fee: PKR {{ number_format($baseFeeVal + $guestFeeVal) }})</option>
                                <option value="2" {{ $currentGuestsCount === 2 ? 'selected' : '' }}>2 Guests (Parents / Siblings) - (Fee: PKR {{ number_format($baseFeeVal + ($guestFeeVal * 2)) }})</option>
                            </select>
                            <small class="text-muted text-xxs d-block mt-1">Graduate fee includes convocation gown. Guest fee is PKR {{ number_format($guestFeeVal) }} per person.</small>
                        </div>

                        <!-- Guest 1 Block -->
                        <div class="col-12 guest-card" id="guest1_block" style="{{ $currentGuestsCount >= 1 ? 'display: block;' : 'display: none;' }}">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-xs fw-bold text-primary mb-0">
                                    <i class="fa fa-user me-1"></i> Guest 1 Information (Parents / Sibling Only)
                                </h6>
                                <span class="badge bg-light text-dark text-xxs">Guest #1</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="field-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="guest1_name" id="guest1_name" class="form-control"
                                        value="{{ old('guest1_name') }}" placeholder="e.g. Muhammad Iqbal Khan">
                                </div>
                                <div class="col-md-4">
                                    <label class="field-label">CNIC Number <span class="text-danger">*</span></label>
                                    <input type="text" name="guest1_cnic" id="guest1_cnic"
                                        class="form-control cnic-mask" value="{{ old('guest1_cnic') }}"
                                        placeholder="e.g. 35202-1234567-1">
                                </div>
                                <div class="col-md-4">
                                    <label class="field-label">Contact Number (11 Digits) <span class="text-danger">*</span></label>
                                    <input type="tel" name="guest1_contact_no" id="guest1_contact_no"
                                        class="form-control phone-11-mask font-monospace" value="{{ old('guest1_contact_no') }}"
                                        placeholder="03001234567" maxlength="11" minlength="11" pattern="[0-9]{11}">
                                    <small id="guest1_contact_no_hint" class="text-xxs d-block mt-1 text-muted">Strictly 11 digits (e.g. 03001234567)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Guest 2 Block -->
                        <div class="col-12 guest-card" id="guest2_block" style="{{ $currentGuestsCount === 2 ? 'display: block;' : 'display: none;' }}">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-xs fw-bold text-primary mb-0">
                                    <i class="fa fa-user me-1"></i> Guest 2 Information (Parents / Sibling Only)
                                </h6>
                                <span class="badge bg-light text-dark text-xxs">Guest #2</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="field-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="guest2_name" id="guest2_name" class="form-control"
                                        value="{{ old('guest2_name') }}" placeholder="e.g. Fatima Bibi">
                                </div>
                                <div class="col-md-4">
                                    <label class="field-label">CNIC Number <span class="text-danger">*</span></label>
                                    <input type="text" name="guest2_cnic" id="guest2_cnic"
                                        class="form-control cnic-mask" value="{{ old('guest2_cnic') }}"
                                        placeholder="e.g. 35202-7654321-2">
                                </div>
                                <div class="col-md-4">
                                    <label class="field-label">Contact Number (11 Digits) <span class="text-danger">*</span></label>
                                    <input type="tel" name="guest2_contact_no" id="guest2_contact_no"
                                        class="form-control phone-11-mask font-monospace" value="{{ old('guest2_contact_no') }}"
                                        placeholder="03217654321" maxlength="11" minlength="11" pattern="[0-9]{11}">
                                    <small id="guest2_contact_no_hint" class="text-xxs d-block mt-1 text-muted">Strictly 11 digits (e.g. 03217654321)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- SECTION 6: DEGREE PROFS & ACADEMIC POSITIONS             -->
            <!-- ======================================================== -->
            @php
                $deptProfsMapping = [];
                if (!empty($academicPrograms) && count($academicPrograms) > 0) {
                    foreach ($academicPrograms as $p) {
                        $deptProfsMapping[$p->code] = [
                            'profs'   => $p->profs_list ?? [],
                            'council' => $p->council_type ?? 'PMDC'
                        ];
                    }
                } else {
                    $deptProfsMapping = [
                        'MBBS' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', 'Final Prof'], 'council' => 'PMDC'],
                        'BDS' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', 'Final Prof'], 'council' => 'PMDC'],
                        'Pharm-D' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'], 'council' => 'PCP'],
                        'Nursing' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof'], 'council' => 'PNC'],
                        'DPT' => ['profs' => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'], 'council' => 'AHC'],
                    ];
                }
            @endphp

            <div class="form-section-card">
                <div class="section-header">
                    <h5>
                        <i class="fa-solid fa-trophy text-warning"></i>
                        6. Professional Examination Academic Positions
                    </h5>
                    <span class="badge bg-light text-dark font-weight-bold">Step 6 of 6</span>
                </div>
                <div class="section-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <span class="badge bg-primary text-white text-xs px-3 py-2" id="current_dept_badge">
                                Degree: {{ $currentDept }}
                            </span>
                            <span class="text-xs text-secondary ms-2">
                                Click your position in each Prof if applicable (or select <em>None (0)</em>):
                            </span>
                        </div>
                    </div>

                    <!-- Groups pre-rendered in Blade so they are 100% visible immediately -->
                    <div id="dynamic_profs_container">
                        @foreach($deptProfsMapping as $deptKey => $deptInfo)
                            @php
                                $groupSafeKey = str_replace(['-', ' '], '_', $deptKey);
                                $isGroupActive = ($currentDept === $deptKey);
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
                                                <small class="text-muted text-xxs">Select position if achieved, or leave as None (0)</small>
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
                                            <button type="button" class="btn btn-sm position-opt-btn active"
                                                data-pos="0" onclick="selectProfPosition(this, '{{ $prof }}', '0')">
                                                None (0)
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <!-- Live Summary -->
                    <div class="mt-3 p-3 bg-light rounded border text-xs" id="positions_summary_badge">
                        <i class="fa fa-info-circle text-primary me-1"></i> <strong>Selected Positions Summary:</strong>
                        <span id="summary_text" class="text-muted ms-1">No position selected (Optional)</span>
                    </div>
                </div>
            </div>

            <!-- Focal Persons Support Box (Dynamic from Database) -->
            @if(!empty($convocationFocalPersons) && count($convocationFocalPersons) > 0)
                <div class="focal-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h6 class="fw-bold text-dark mb-1 text-xs text-uppercase">
                                <i class="fa fa-phone-volume text-primary me-1"></i> Convocation Focal Persons
                            </h6>
                            <small class="text-muted text-xxs">For any queries regarding registration, gowns, or payments</small>
                        </div>
                        @foreach($convocationFocalPersons as $fp)
                            <div class="col-md-4 mb-2 mb-md-0">
                                <div class="p-2 border rounded bg-light text-xs">
                                    <strong class="d-block text-dark">{{ $fp->name }}</strong>
                                    <small class="text-muted text-xxs d-block">{{ $fp->designation }}</small>
                                    <a href="tel:{{ $fp->mobile }}" class="text-primary text-decoration-none fw-bold font-monospace">
                                        <i class="fa fa-mobile-alt me-1"></i> {{ $fp->mobile }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Form Action Footer -->
            <div
                class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 p-3 bg-white rounded-3 shadow-sm border mb-5">
                <div class="d-flex align-items-center">
                    <i class="fa fa-shield-alt text-success fs-3 me-3"></i>
                    <div>
                        <h6 class="mb-0 text-dark fw-bold">Instant Account Activation & Challan Voucher</h6>
                        <small class="text-muted">Upon submission, your printable bank challan invoice will be generated immediately.</small>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2 w-100 w-md-auto justify-content-end">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary px-3 mb-0 text-center"
                        style="border-radius: 8px;">
                        <i class="fa fa-arrow-left me-1"></i> Back to Login
                    </a>
                    <button type="submit" id="btnSubmitRegistration" class="btn btn-register-submit mb-0">
                        <i class="fa fa-check-circle me-2"></i> Register for Convocation & Get Challan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Core Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        // Safe toastr initialization
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3500"
            };
        }

        function showNotification(type, message) {
            if (typeof toastr !== 'undefined' && toastr[type]) {
                toastr[type](message);
            } else {
                alert(message);
            }
        }

        // ==========================================
        // 1. DYNAMIC GUEST COUNT & FEE HANDLER
        // ==========================================
        var dynamicBaseFee = {{ (int)($convocationSettings->base_registration_fee ?? 15000) }};
        var dynamicGuestFee = {{ (int)($convocationSettings->guest_fee_per_person ?? 5000) }};

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
                var calculatedTotal = dynamicBaseFee + (count * dynamicGuestFee);
                if (count === 0) {
                    feeBadge.innerHTML = 'Fee: PKR ' + calculatedTotal.toLocaleString() + ' (Graduate Alone)';
                } else {
                    feeBadge.innerHTML = 'Fee: PKR ' + calculatedTotal.toLocaleString() + ' (Graduate + ' + count + ' Guest' + (count > 1 ? 's' : '') + ')';
                }
            }
        }

        // ==========================================
        // 2. DEPARTMENT SELECTION HANDLER (From DB)
        // ==========================================
        var deptCouncilMap = {
            @if(!empty($academicPrograms) && count($academicPrograms) > 0)
                @foreach($academicPrograms as $prog)
                    "{{ $prog->code }}": "{{ $prog->council_type }}",
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

        try {
            var rawPositions = document.getElementById('positions_data') ? document.getElementById('positions_data').value : '';
            if (rawPositions) {
                var parsed = JSON.parse(rawPositions);
                if (Array.isArray(parsed)) {
                    parsed.forEach(function (item) {
                        if (item.prof) {
                            selectedProfPositions[item.prof] = {
                                position: item.position || (item.overall_first ? '1st Position' : '0')
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

            var allBtns = card.querySelectorAll('.position-opt-btn');
            allBtns.forEach(function (b) {
                b.classList.remove('active');
            });

            btn.classList.add('active');

            selectedProfPositions[prof] = {
                position: pos || '0'
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

            var noneBtn = card.querySelector('.position-opt-btn[data-pos="0"]');
            if (noneBtn) noneBtn.classList.add('active');

            selectedProfPositions[prof] = {
                position: '0'
            };
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

            allowedProfs.forEach(function (prof) {
                var item = selectedProfPositions[prof];
                var pos = (item && item.position) ? item.position : '0';

                result.push({
                    prof: prof,
                    position: pos
                });

                if (pos && pos !== '0' && pos.toLowerCase() !== 'none') {
                    summaryParts.push(prof + ': ' + pos);
                }
            });

            var hiddenData = document.getElementById('positions_data');
            var hiddenSummary = document.getElementById('positions_summary');
            var summaryText = document.getElementById('summary_text');

            if (hiddenData) hiddenData.value = JSON.stringify(result);
            var summaryStr = summaryParts.length > 0 ? summaryParts.join(' | ') : '0 (No Positions)';
            if (hiddenSummary) hiddenSummary.value = summaryParts.length > 0 ? summaryParts.join('; ') : '0';
            if (summaryText) summaryText.innerText = summaryStr;
        }

        // ==========================================
        // 4. FORMAT CNIC (e.g. 35202-1234567-1)
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
        // 7. COMBINED ADDRESS SYNC
        // ==========================================
        function updateCombinedAddress() {
            var parts = [];
            var house = document.getElementById('house_no') ? document.getElementById('house_no').value.trim() : '';
            var street = document.getElementById('street_address') ? document.getElementById('street_address').value.trim() : '';
            var area = document.getElementById('area') ? document.getElementById('area').value.trim() : '';
            var city = document.getElementById('city') ? document.getElementById('city').value.trim() : '';
            var province = document.getElementById('province') ? document.getElementById('province').value : '';

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

        function updatePhoneInputIndicator(input) {
            if (!input) return;
            var hint = document.getElementById(input.id + '_hint');
            var raw = input.value.replace(/[^0-9]/g, '');
            if (raw.length > 11) raw = raw.slice(0, 11);
            input.value = raw;

            if (!hint) return;

            if (raw.length === 0) {
                hint.innerHTML = '<span class="text-danger"><i class="fa fa-exclamation-circle me-1"></i> Strictly 11 digits required</span>';
                input.style.borderColor = '#dc3545';
            } else if (raw.length < 11) {
                hint.innerHTML = '<span class="text-danger fw-bold"><i class="fa fa-exclamation-triangle me-1"></i> ' + raw.length + ' / 11 digits (' + (11 - raw.length) + ' more needed)</span>';
                input.style.borderColor = '#dc3545';
            } else if (raw.length === 11) {
                hint.innerHTML = '<span class="text-success fw-bold"><i class="fa fa-check-circle me-1"></i> Valid 11 digits entered</span>';
                input.style.borderColor = '#198754';
            }
        }

        // Initialize state on page load
        document.addEventListener('DOMContentLoaded', function () {
            // Attach 11-digit numeric mask and live indicator to phone inputs
            document.querySelectorAll('.phone-11-mask').forEach(function (input) {
                input.addEventListener('input', function () {
                    updatePhoneInputIndicator(this);
                });
                input.addEventListener('blur', function () {
                    updatePhoneInputIndicator(this);
                });
                if (input.value) {
                    updatePhoneInputIndicator(input);
                }
            });

            var currentGuestsCount = document.getElementById('guests_count') ? document.getElementById('guests_count').value : '0';
            handleGuestCountChange(currentGuestsCount);

            var currentDept = document.getElementById('department') ? document.getElementById('department').value : 'MBBS';
            handleDepartmentChange(currentDept);

            // Restore any active saved positions, or default to None (0)
            document.querySelectorAll('.prof-row-card').forEach(function (card) {
                var prof = card.getAttribute('data-prof');
                var allBtns = card.querySelectorAll('.position-opt-btn');
                allBtns.forEach(function (b) { b.classList.remove('active'); });

                var saved = selectedProfPositions[prof];
                var targetPos = (saved && saved.position) ? saved.position : '0';
                var btn = card.querySelector('.position-opt-btn[data-pos="' + targetPos + '"]');
                if (btn) {
                    btn.classList.add('active');
                } else {
                    var noneBtn = card.querySelector('.position-opt-btn[data-pos="0"]');
                    if (noneBtn) noneBtn.classList.add('active');
                }
            });

            syncPositionsJsonAndSummary();
        });

        // ==========================================
        // 8. FORM SUBMISSION (AJAX with Fallback)
        // ==========================================
        var regForm = document.getElementById('studentRegistrationForm');
        if (regForm) {
            regForm.addEventListener('submit', function (e) {
                e.preventDefault();
                syncPositionsJsonAndSummary();
                updateCombinedAddress();

                var btn = document.getElementById('btnSubmitRegistration');
                var originalBtnHtml = btn ? btn.innerHTML : '';

                // Client-side mandatory validation
                var name = document.getElementById('name') ? document.getElementById('name').value.trim() : '';
                var email = document.getElementById('email') ? document.getElementById('email').value.trim() : '';
                var pass = document.getElementById('password') ? document.getElementById('password').value : '';
                var passConf = document.getElementById('password_confirmation') ? document.getElementById('password_confirmation').value : '';
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

                if (!name || !email || !pass || !contact || !emergency || !cnic || !rollNo ||
                    !fatherName || !dept || !session || !gradYear || !houseNo || !street ||
                    !area || !city || !province || !uhsReg || !pmdcReg) {
                    showNotification('warning', 'Please fill in all mandatory fields marked with an asterisk (*).');
                    return;
                }

                // Strict 11-digit phone check
                var cleanContact = contact.replace(/[^0-9]/g, '');
                var cleanEmergency = emergency.replace(/[^0-9]/g, '');

                if (cleanContact.length !== 11) {
                    var cInput = document.getElementById('contact_no');
                    if (cInput) {
                        cInput.focus();
                        updatePhoneInputIndicator(cInput);
                    }
                    showNotification('error', 'Contact / Mobile Number must be strictly 11 digits! Submission blocked.');
                    return;
                }

                if (cleanEmergency.length !== 11) {
                    var emInput = document.getElementById('emergency_contact_no');
                    if (emInput) {
                        emInput.focus();
                        updatePhoneInputIndicator(emInput);
                    }
                    showNotification('error', 'Emergency Contact Number must be strictly 11 digits! Submission blocked.');
                    return;
                }

                var guestsCountVal = parseInt(document.getElementById('guests_count') ? document.getElementById('guests_count').value : '0', 10);
                if (guestsCountVal >= 1) {
                    var g1ContactEl = document.getElementById('guest1_contact_no');
                    var g1Val = g1ContactEl ? g1ContactEl.value.replace(/[^0-9]/g, '') : '';
                    if (g1Val.length !== 11) {
                        if (g1ContactEl) {
                            g1ContactEl.focus();
                            updatePhoneInputIndicator(g1ContactEl);
                        }
                        showNotification('error', 'Guest 1 Contact Number must be strictly 11 digits! Submission blocked.');
                        return;
                    }
                }
                if (guestsCountVal >= 2) {
                    var g2ContactEl = document.getElementById('guest2_contact_no');
                    var g2Val = g2ContactEl ? g2ContactEl.value.replace(/[^0-9]/g, '') : '';
                    if (g2Val.length !== 11) {
                        if (g2ContactEl) {
                            g2ContactEl.focus();
                            updatePhoneInputIndicator(g2ContactEl);
                        }
                        showNotification('error', 'Guest 2 Contact Number must be strictly 11 digits! Submission blocked.');
                        return;
                    }
                }

                if (pass !== passConf) {
                    showNotification('error', 'Password confirmation does not match!');
                    return;
                }

                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Registering Account...';
                }

                var formData = new FormData(regForm);
                var tokenMeta = document.querySelector('meta[name="csrf-token"]');
                var csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

                fetch(regForm.action, {
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
                        showNotification('success', result.data.message || 'Registration successful! Showing your invoice...');
                        setTimeout(function () {
                            window.location.href = result.data.redirect_url || '/student/challan';
                        }, 1200);
                    } else {
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = originalBtnHtml;
                        }
                        if (result.data.errors) {
                            var firstKey = Object.keys(result.data.errors)[0];
                            showNotification('error', result.data.errors[firstKey][0]);
                        } else {
                            showNotification('error', result.data.message || 'Registration failed');
                        }
                    }
                })
                .catch(function (err) {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;
                    }
                    showNotification('error', 'An error occurred. Please check your inputs and try again.');
                });
            });
        }
    </script>
</body>

</html>
