<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shahida Islam Medical Complex - First Convocation 2026')</title>

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

    @auth
        @php
            $authUser = auth()->user();
            $currentToken = session('sanctum_token');
            if (!$currentToken) {
                $currentToken = $authUser->createToken('web-session')->plainTextToken;
                session(['sanctum_token' => $currentToken]);
            }
        @endphp
        <script>
            window.API_TOKEN = "{{ $currentToken }}";
            localStorage.setItem('student_api_token', "{{ $currentToken }}");
        </script>
    @endauth

    <style>
        /* ========================================================
           SIMC Portal Design System (Aligned with simcportal.pacslink.com.pk)
           ======================================================== */
        :root {
            --sidebar-w: 268px;
            --font: "Inter", "Segoe UI", system-ui, -apple-system, Roboto, "Helvetica Neue", Arial, sans-serif;
            --mono: ui-monospace, "Cascadia Mono", "SFMono-Regular", Consolas, monospace;
            --bg: #f4f6f8;
            --surface: #ffffff;
            --surface-2: #f8fafb;
            --border: #dde3e8;
            --border-strong: #c3ccd4;
            --text: #16212b;
            --text-2: #3d4b57;
            --muted: #5d6b77;
            --primary: #0b4f6c;          /* Official SIMC Deep Teal / Slate */
            --primary-hover: #093f57;
            --primary-soft: #e3eff5;
            --focus: #1f7fb0;
            --sidebar-bg: #0f2533;       /* SIMC Portal Deep Slate Navy */
            --sidebar-hover: #193547;
            --sidebar-active: #0b4f6c;
            --sidebar-text: #d5e1e8;
            --radius-sm: 6px;
            --radius: 8px;
            --radius-lg: 12px;
            --shadow-subtle: 0 1px 3px rgba(16, 24, 40, 0.06);
            --shadow-card: 0 2px 8px rgba(16, 24, 40, 0.05);
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            line-height: 1.5;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Enterprise Sidebar Styling */
        .portal-sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid #1c3547;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.12);
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 8px 14px 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 14px;
            text-decoration: none;
        }

        .portal-brand-icon {
            width: 34px;
            height: 34px;
            background: #1b7aa3;
            color: #ffffff;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .sidebar-student-card {
            background: #152f40;
            border: 1px solid #234359;
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            margin-bottom: 14px;
        }

        .convocation-event-pill {
            background: #132b3a;
            border: 1px solid #1f3f54;
            border-radius: var(--radius-sm);
            padding: 9px 11px;
            margin-bottom: 14px;
            color: #e2edf3;
            font-size: 0.76rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 9px 12px;
            color: var(--sidebar-text);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: var(--sidebar-hover);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: var(--sidebar-active);
            font-weight: 600;
        }

        .sidebar-link .link-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 20px;
            text-align: center;
            color: #8fb9cf;
        }

        .sidebar-link.active i {
            color: #ffffff;
        }

        /* Main Content Wrapper */
        .portal-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }

        .portal-header-bar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: var(--shadow-subtle);
        }

        .focal-person-pill {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 5px 11px;
            font-size: 0.75rem;
            color: var(--text-2);
        }

        /* Mobile Backdrop Overlay */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 37, 51, 0.6);
            backdrop-filter: blur(2px);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        body.sidebar-open {
            overflow: hidden !important;
        }

        @media (max-width: 991px) {
            .portal-sidebar {
                transform: translateX(-100%);
                width: 280px;
                max-width: 86vw;
            }
            .portal-sidebar.show {
                transform: translateX(0);
            }
            .portal-main {
                margin-left: 0 !important;
            }
            .portal-header-bar {
                padding: 10px 14px;
            }
        }

        @media (max-width: 576px) {
            .portal-header-bar h6 {
                font-size: 0.88rem !important;
            }
            .portal-header-bar small {
                display: none !important;
            }
            .portal-brand {
                padding: 4px 6px 12px 6px;
            }
        }
    </style>
</head>

<body>
    @auth
        @php
            $isAdmin = auth()->user()->isAdmin();
            $reg = auth()->user()->studentRegistration;
            $feeAmount = $reg ? $reg->fee_amount : 15000;
            $paymentStatus = $reg ? $reg->payment_status : 'unpaid';
        @endphp

        <!-- Left Vertical Sidebar -->
        <aside class="portal-sidebar" id="portalSidebar">
            <!-- Mobile Close Bar -->
            <div class="d-flex align-items-center justify-content-between d-lg-none pb-2 mb-2 border-bottom border-secondary">
                <span class="text-xs text-white-50 fw-bold text-uppercase"><i class="fa fa-compass me-1"></i> Navigation Menu</span>
                <button type="button" class="btn btn-sm btn-link text-white p-0 m-0" id="sidebarCloseBtn" aria-label="Close Sidebar">
                    <i class="material-symbols-rounded fs-4">close</i>
                </button>
            </div>
            @if($isAdmin)
                <!-- Admin Brand -->
                <a href="{{ route('admin.dashboard') }}" class="portal-brand">
                    <div class="portal-brand-icon">
                        <i class="material-symbols-rounded">admin_panel_settings</i>
                    </div>
                    <div>
                        <h6 class="text-white fw-bold mb-0" style="font-size: 0.90rem; letter-spacing: 0.3px;">SHAHIDA ISLAM</h6>
                        <small class="text-white-50 text-xxs d-block">Admin Console &bull; First Convocation</small>
                    </div>
                </a>

                <!-- Admin User Card -->
                <div class="sidebar-student-card">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="background: #1b7aa3; color: #fff;">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <div style="overflow: hidden;">
                            <h6 class="text-white text-xs fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</h6>
                            <small class="text-white-50 text-xxs d-block">{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #234359 !important;">
                        <span class="badge text-xxs" style="background: #1b7aa3; color: #fff;">Super Admin</span>
                        <span class="text-white-50 text-xxs"><i class="fa fa-check me-1"></i> Full Access</span>
                    </div>
                </div>

                <!-- Admin Navigation Links -->
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">dashboard</i>
                                <span>Overview Dashboard</span>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.students', ['status' => 'pending_verification']) }}" class="sidebar-link {{ request()->routeIs('admin.students') && request('status') === 'pending_verification' ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">pending_actions</i>
                                <span>Verification Queue</span>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.students') }}" class="sidebar-link {{ request()->routeIs('admin.students') && !request('status') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">group</i>
                                <span>All Student Registrations</span>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">settings_suggest</i>
                                <span>Convocation Settings</span>
                            </span>
                        </a>
                    </li>
                </ul>
            @else
                <!-- Student Brand Logo & Title -->
                <a href="{{ route('student.details.edit') }}" class="portal-brand">
                    <div class="portal-brand-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h6 class="text-white fw-bold mb-0" style="font-size: 0.90rem; letter-spacing: 0.2px;">{{ strtoupper($convocationSettings->institution_name ?? 'SHAHIDA ISLAM') }}</h6>
                        <small class="text-warning text-xxs font-weight-bold d-block">{{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }}</small>
                    </div>
                </a>

                <!-- Convocation Event Pill (Dynamic from Database) -->
                <div class="convocation-event-pill">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-white text-xxs text-uppercase fw-bold"><i class="fa fa-calendar-check me-1"></i> {{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }}</span>
                    </div>
                    <div class="fw-bold text-white text-xs">{{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 Nov 2026' }}</div>
                    <small class="text-white-50 text-xxs d-block mt-1">Deadline: <strong>{{ $convocationSettings->registration_deadline_formatted ?? '15 Nov 2026' }}</strong></small>
                </div>

                <!-- Student Summary Card -->
                <div class="sidebar-student-card">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="background: #1b7aa3; color: #fff;">
                            <i class="fa fa-user-graduate"></i>
                        </div>
                        <div style="overflow: hidden;">
                            <h6 class="text-white text-xs fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</h6>
                            <small class="text-white-50 text-xxs d-block">{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #234359 !important;">
                        <span class="badge text-xxs" style="background: #1b7aa3; color: #fff;">{{ auth()->user()->department ?? 'MBBS' }}</span>
                        @if($paymentStatus === 'paid')
                            <span class="badge text-xxs" style="background: #17693f; color: #fff;">
                                <i class="fa fa-check-circle me-1"></i> Paid
                            </span>
                        @elseif($paymentStatus === 'pending_verification')
                            <span class="badge text-xxs" style="background: #0b4f6c; color: #fff;">
                                <i class="fa fa-clock me-1"></i> In Review
                            </span>
                        @else
                            <span class="badge text-xxs" style="background: #7a5210; color: #fff;">
                                Due
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Student Navigation Links -->
                <ul class="sidebar-menu">
                    <!-- 1. Profile / Details -->
                    <li class="sidebar-menu-item">
                        <a href="{{ route('student.details.edit') }}" class="sidebar-link {{ request()->routeIs('student.details.edit') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">person</i>
                                <span>My Registration</span>
                            </span>
                        </a>
                    </li>

                    <!-- 2. Fee Voucher / Challan -->
                    <li class="sidebar-menu-item">
                        <a href="{{ route('student.challan') }}" class="sidebar-link {{ request()->routeIs('student.challan') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">receipt_long</i>
                                <span>Fee Challan Voucher</span>
                            </span>
                            <span class="badge {{ request()->routeIs('student.challan') ? 'bg-white text-dark' : 'bg-primary text-white' }} text-xxs">
                                PKR {{ number_format($feeAmount) }}
                            </span>
                        </a>
                    </li>

                    <!-- 3. Fee Payment / Upload Receipt -->
                    <li class="sidebar-menu-item">
                        <a href="{{ route('student.payment') }}" class="sidebar-link {{ request()->routeIs('student.payment') ? 'active' : '' }}">
                            <span class="link-left">
                                <i class="material-symbols-rounded">payments</i>
                                <span>Fee Payment Proof</span>
                            </span>
                            @if($paymentStatus === 'paid')
                                <span class="badge bg-success text-white text-xxs">Paid</span>
                            @elseif($paymentStatus === 'pending_verification')
                                <span class="badge bg-info text-white text-xxs">In Review</span>
                            @else
                                <span class="badge bg-danger text-white text-xxs">Due</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <!-- Focal Persons Helpline Box (Dynamic from Database) -->
                @if(!empty($convocationFocalPersons) && count($convocationFocalPersons) > 0)
                    <div class="p-2 mb-3 rounded" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <small class="text-white-50 text-xxs fw-bold d-block mb-1 text-uppercase">
                            <i class="fa fa-headset text-warning me-1"></i> Convocation Focal Persons:
                        </small>
                        <div class="text-xxs text-white">
                            @foreach($convocationFocalPersons as $fp)
                                <div class="mb-1"><strong>{{ $fp->name }}:</strong> <a href="tel:{{ $fp->mobile }}" class="text-info text-decoration-none font-monospace">{{ $fp->mobile }}</a></div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Sidebar Footer with Logout -->
            <div class="pt-3 mt-auto" style="border-top: 1px solid #1c3547;">
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn w-100 btn-sm mb-0 d-flex align-items-center justify-content-center gap-2" style="background: transparent; color: #d5e1e8; border: 1px solid #28475c;">
                        <i class="material-symbols-rounded text-sm">logout</i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>
        <!-- Mobile Sidebar Backdrop Overlay -->
        <div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop"></div>
    @endauth

    <!-- Main Content Wrapper -->
    <div class="@auth portal-main @endauth">
        @auth
            <!-- Top Sticky Header Bar -->
            <header class="portal-header-bar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <button type="button" class="btn btn-link text-dark p-0 d-lg-none d-flex align-items-center justify-content-center" id="sidebarToggleBtn" aria-label="Toggle Sidebar" style="width: 38px; height: 38px;">
                        <i class="material-symbols-rounded fs-2">menu</i>
                    </button>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">
                            @yield('page_title', $convocationSettings->convocation_title ?? 'First Convocation 2026')
                        </h6>
                        <small class="text-muted text-xxs">
                            {{ $convocationSettings->institution_subtitle ?? 'Shahida Islam Medical College (MBBS) • Shahida Islam Dental College (BDS)' }} &bull; <strong>{{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 Nov 2026' }}</strong>
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 gap-md-3">
                    @if($isAdmin)
                        <span class="badge text-xxs py-2 px-2 px-sm-3" style="background: var(--surface-2); border: 1px solid var(--border); color: var(--text-2);">
                            <i class="fa fa-user-shield me-1" style="color: var(--primary);"></i> <span class="d-none d-sm-inline">Super </span>Admin
                        </span>
                        <a href="{{ route('admin.students', ['status' => 'pending_verification']) }}" class="btn btn-sm text-white mb-0 px-2 px-sm-3" style="background: var(--primary); font-weight: 500;">
                            <i class="fa fa-tasks me-1"></i> <span class="d-none d-sm-inline">Review </span>Queue
                        </a>
                    @else
                        <!-- Event Info Capsule -->
                        <div class="focal-person-pill d-none d-lg-block">
                            <span class="text-muted text-xxs">Convocation:</span>
                            <strong class="text-dark">{{ $convocationSettings->convocation_date_formatted ?? '28 Nov 2026' }}</strong>
                            <span class="mx-1">&bull;</span>
                            <span class="text-muted text-xxs">Deadline: {{ $convocationSettings->registration_deadline_formatted ?? '15 Nov 2026' }}</span>
                        </div>

                        <div class="text-end d-none d-sm-block">
                            <small class="text-muted d-block text-xxs">Total Fee</small>
                            <span class="fw-bold text-dark text-sm">PKR {{ number_format($feeAmount) }}</span>
                        </div>

                        @if($paymentStatus === 'paid')
                            <span class="badge px-2 px-sm-3 py-2 text-xxs" style="background: #e3f3ea; color: #17693f; border: 1px solid #b3dfc4;">
                                <i class="fa fa-check-circle me-1"></i> Paid Verified
                            </span>
                        @elseif($paymentStatus === 'pending_verification')
                            <span class="badge px-2 px-sm-3 py-2 text-xxs" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b2d4e5;">
                                <i class="fa fa-clock me-1"></i> Verification Pending
                            </span>
                        @else
                            <a href="{{ route('student.payment') }}" class="btn btn-sm text-white mb-0 px-2 px-sm-3" style="background: var(--primary); font-weight: 500;">
                                <i class="fa fa-credit-card me-1"></i> <span class="d-none d-sm-inline">Attach </span>Proof
                            </a>
                        @endif
                    @endif
                </div>
            </header>
        @endauth

        <main class="p-2 p-sm-3 p-md-4">
            @yield('Content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3500"
            };
        }

        // Mobile Sidebar Controls
        (function() {
            var toggleBtn = document.getElementById('sidebarToggleBtn');
            var closeBtn = document.getElementById('sidebarCloseBtn');
            var sidebar = document.getElementById('portalSidebar');
            var backdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('show');
                if (backdrop) backdrop.classList.add('show');
                document.body.classList.add('sidebar-open');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('show');
                if (backdrop) backdrop.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Close sidebar when navigating on mobile
            document.querySelectorAll('.sidebar-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });
        })();
    </script>
</body>

</html>
