<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#0b4f6c">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }} | {{ $convocationSettings->institution_name ?? 'Shahida Islam Medical Complex' }}</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .login-card {
            background: var(--surface);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(16, 24, 40, 0.08), 0 10px 25px rgba(16, 24, 40, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }

        .login-header {
            background: var(--sidebar-bg);
            padding: 24px 22px;
            text-align: center;
            color: #ffffff;
            border-bottom: 3px solid var(--primary);
        }

        .brand-icon-box {
            width: 42px;
            height: 42px;
            background: #1b7aa3;
            color: #ffffff;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .login-body {
            padding: 26px 24px;
        }

        .form-label {
            font-size: 0.80rem;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 5px;
        }

        .form-control {
            border: 1px solid var(--border-strong) !important;
            border-radius: var(--radius-sm) !important;
            padding: 10px 13px !important;
            font-size: 0.88rem !important;
            color: var(--text) !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(11, 79, 108, 0.15) !important;
            outline: none !important;
        }

        .btn-login {
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 11px 16px;
            font-weight: 600;
            font-size: 0.90rem;
            width: 100%;
            transition: background 0.15s ease;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            color: #ffffff;
        }

        .convocation-pill {
            background: #152f40;
            color: #d5e1e8;
            border: 1px solid #234359;
            border-radius: 4px;
            padding: 3px 10px;
            font-size: 0.72rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 6px;
        }

        @media (max-width: 576px) {
            body {
                padding: 14px;
                align-items: flex-start;
                padding-top: 24px;
            }
            .login-header {
                padding: 20px 16px;
            }
            .login-body {
                padding: 20px 16px;
            }
            .form-control {
                font-size: 16px !important; /* Prevents auto zoom-in on iOS Safari */
                padding: 11px 13px !important;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <!-- Official Brand Header -->
        <div class="login-header">
            <div class="brand-icon-box">
                <i class="fa fa-university"></i>
            </div>
            <div class="convocation-pill text-uppercase">
                {{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }}
            </div>
            <h5 class="text-white font-weight-bolder mb-1" style="font-size: 1.05rem; letter-spacing: 0.3px;">
                {{ strtoupper($convocationSettings->institution_name ?? 'SHAHIDA ISLAM MEDICAL COMPLEX') }}
            </h5>
            <small class="text-white-50 text-xxs d-block mb-2">
                {{ $convocationSettings->institution_subtitle ?? 'Shahida Islam Medical College (MBBS) • Shahida Islam Dental College (BDS)' }}
            </small>
            @if(!empty($convocationSettings->convocation_date_formatted))
                <div class="badge text-xxs py-1 px-3" style="background: #152f40; border: 1px solid #234359; color: #d5e1e8;">
                    <i class="fa fa-calendar-alt me-1 text-info"></i> {{ $convocationSettings->convocation_date_formatted }}
                </div>
            @endif
        </div>

        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger text-white text-xs mb-3 p-2 rounded" role="alert" style="background: #a4262c;">
                    <i class="fa fa-exclamation-circle me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            @if(session('message'))
                <div class="alert text-xs mb-3 p-2 rounded" role="alert" style="background: #e3f3ea; color: #17693f; border: 1px solid #b3dfc4;">
                    <i class="fa fa-check-circle me-1"></i> {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Registered Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                        placeholder="doctor@example.com or admin@example.com" required autofocus>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Password</label>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-login mb-3">
                    <i class="fa fa-sign-in-alt me-1"></i> Sign In to Convocation Portal
                </button>

                <div class="text-center pt-2 border-top">
                    <span class="text-xs text-muted">Eligible Graduate not registered yet?</span>
                    <a href="{{ route('register') }}" class="text-xs fw-bold ms-1" style="color: var(--primary);">
                        Register for Convocation
                    </a>
                </div>
            </form>

            <!-- Focal Persons Support Strip -->
            @if(isset($convocationFocalPersons) && $convocationFocalPersons->count() > 0)
                <div class="mt-4 pt-3 border-top text-center text-xxs text-muted">
                    <strong class="d-block text-dark mb-1">Convocation Organizing Committee Focal Persons:</strong>
                    @foreach($convocationFocalPersons as $focal)
                        <div>{{ $focal->name }} ({{ $focal->designation }}): <a href="tel:{{ preg_replace('/[^0-9+]/', '', $focal->mobile) }}" class="text-decoration-none font-monospace fw-bold" style="color: var(--primary);">{{ $focal->mobile }}</a></div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>

</html>
