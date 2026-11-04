@extends('theme')

@section('title', 'Official Bank Challan - ' . ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' | ' . ($convocationSettings->institution_name ?? 'Shahida Islam Medical Complex'))
@section('page_title', ($convocationSettings->convocation_title ?? 'First Convocation 2026') . ' Fee Challan Voucher')

@section('Content')

    <style>
        /* ========================================================
           SIMC Enterprise Challan & Mobile Invoice Styles
           ======================================================== */
        .challan-container {
            max-width: 1240px;
            margin: 0 auto;
        }

        /* Top Action Card */
        .challan-actions-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #dde3e8;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(16, 24, 40, 0.05);
        }

        /* ========================================================
           Desktop 3-Copy Bank Challan Sheet
           ======================================================== */
        .challan-sheet {
            background: #ffffff;
            border: 1.5px solid #0b4f6c;
            border-radius: 8px;
            padding: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .challan-copy {
            border: 1px dashed #7a8b99;
            border-radius: 6px;
            padding: 12px 10px;
            height: 100%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 0.77rem;
        }

        .copy-header {
            text-align: center;
            border-bottom: 1.5px solid #0b4f6c;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }

        .copy-title-badge {
            background: #0b4f6c;
            color: #ffffff;
            display: inline-block;
            font-weight: 700;
            font-size: 0.70rem;
            padding: 2px 10px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .challan-meta-table td {
            padding: 2.5px 3px;
            font-size: 0.75rem;
            vertical-align: top;
        }

        .fee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 0.75rem;
        }

        .fee-table th,
        .fee-table td {
            border: 1px solid #c3ccd4;
            padding: 4px 6px;
        }

        .fee-table th {
            background: #f4f6f8;
            font-weight: 700;
            color: #16212b;
        }

        .bank-box {
            background: #f8fafb;
            border: 1px solid #dde3e8;
            border-radius: 4px;
            padding: 6px 8px;
            font-size: 0.72rem;
            margin-bottom: 6px;
        }

        .signature-box {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #94a3b8;
            font-size: 0.68rem;
            text-align: center;
        }

        /* ========================================================
           Dedicated Mobile Invoice View (Clean Enterprise Card)
           ======================================================== */
        .mobile-invoice-card {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #dde3e8;
            box-shadow: 0 1px 4px rgba(16, 24, 40, 0.06);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .mobile-invoice-header {
            background: #0f2533;
            color: #ffffff;
            padding: 16px;
            border-bottom: 3px solid #0b4f6c;
        }

        .mobile-bank-card {
            background: #f8fafb;
            border: 1px solid #dde3e8;
            border-radius: 8px;
            padding: 14px;
            margin-top: 14px;
        }

        .copy-pill-btn {
            background: #e3eff5;
            color: #0b4f6c;
            border: 1px solid #b2d4e5;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .copy-pill-btn:hover {
            background: #0b4f6c;
            color: #ffffff;
        }

        /* ========================================================
           Print Media: Standard A4 Landscape
           ======================================================== */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .portal-sidebar,
            .portal-header-bar,
            .challan-actions-card,
            .mobile-invoice-card,
            .mobile-challan-switch,
            .btn,
            nav {
                display: none !important;
            }
            .portal-main {
                margin: 0 !important;
                padding: 0 !important;
            }
            .challan-sheet {
                display: block !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .challan-container {
                max-width: 100% !important;
                width: 100% !important;
            }
            @page {
                size: A4 landscape;
                margin: 6mm;
            }
        }
    </style>

    <div class="challan-container">
        <!-- Action Bar (Hidden when printing) -->
        <div class="challan-actions-card d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <span class="badge text-xxs font-weight-bold" style="background: #e3eff5; color: #0b4f6c; border: 1px solid #b2d4e5;">
                        {{ strtoupper($convocationSettings->convocation_date_formatted ?? 'SATURDAY, 28 NOVEMBER 2026') }}
                    </span>
                    <span class="badge text-xxs" style="background: #fbf0d9; color: #8a5a0b; border: 1px solid #ecd8b4;">
                        DEADLINE: {{ strtoupper($convocationSettings->registration_deadline_formatted ?? '15 NOVEMBER 2026') }}
                    </span>
                </div>
                <h5 class="fw-bold text-dark mb-1">
                    {{ $convocationSettings->institution_name ?? 'Shahida Islam Medical Complex' }} &bull; {{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }} Challan
                </h5>
                <div class="text-xs text-muted">
                    Challan No: <strong class="text-dark font-monospace">{{ $registration->challan_no }}</strong> | 
                    Total Payable: <strong class="text-dark fs-6">PKR {{ number_format($registration->fee_amount) }}</strong>
                    <span class="ms-1">
                        ({{ (int)$registration->guests_count === 0 ? 'Candidate Alone: ' . number_format($convocationSettings->base_registration_fee ?? 15000) : ((int)$registration->guests_count === 1 ? 'Candidate + 1 Guest: ' . number_format(($convocationSettings->base_registration_fee ?? 15000) + ($convocationSettings->guest_fee_per_person ?? 5000)) : 'Candidate + 2 Guests: ' . number_format(($convocationSettings->base_registration_fee ?? 15000) + (2 * ($convocationSettings->guest_fee_per_person ?? 5000)))) }})
                    </span>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                <button type="button" onclick="window.print()" class="btn btn-sm text-white mb-0 px-3 py-2 text-center" style="background: #0f2533; font-weight: 500;">
                    <i class="fa fa-print me-1"></i> Print Challan Form (A4)
                </button>
                <a href="{{ route('student.payment') }}" class="btn btn-sm text-white mb-0 px-3 py-2 text-center" style="background: #0b4f6c; font-weight: 500;">
                    <i class="fa fa-upload me-1"></i> Attach Paid Voucher
                </a>
            </div>
        </div>

        <!-- ========================================================
             1. MOBILE-ONLY INVOICE VOUCHER VIEW (Clean, single card, readable)
             ======================================================== -->
        <div class="d-block d-lg-none">
            <div class="mobile-invoice-card">
                <!-- Mobile Header -->
                <div class="mobile-invoice-header">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge text-xxs" style="background: rgba(255,255,255,0.15); color: #fff;">
                            OFFICIAL CHALLAN VOUCHER
                        </span>
                        @if($registration->payment_status === 'paid')
                            <span class="badge text-xxs" style="background: #e3f3ea; color: #17693f;">Paid & Verified</span>
                        @elseif($registration->payment_status === 'pending_verification')
                            <span class="badge text-xxs" style="background: #e3eff5; color: #0b4f6c;">Under Verification</span>
                        @else
                            <span class="badge text-xxs" style="background: #fbf0d9; color: #8a5a0b;">Payment Due</span>
                        @endif
                    </div>
                    <h6 class="text-white fw-bold mb-0" style="font-size: 0.95rem;">
                        {{ strtoupper($convocationSettings->institution_name ?? 'SHAHIDA ISLAM MEDICAL COMPLEX') }}
                    </h6>
                    <small class="text-white-50 text-xxs d-block mb-2">
                        {{ $convocationSettings->convocation_title ?? 'First Convocation 2026' }} &bull; {{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 Nov 2026' }}
                    </small>

                    <div class="p-2 rounded" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                        <div class="row g-1 text-xs">
                            <div class="col-6">
                                <span class="text-white-50 d-block text-xxs">Challan Number</span>
                                <strong class="font-monospace text-white">{{ $registration->challan_no }}</strong>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-white-50 d-block text-xxs">Due Date</span>
                                <strong class="text-warning">{{ $convocationSettings->registration_deadline_formatted ?? '15 Nov 2026' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <!-- Candidate Info Table -->
                    <h6 class="text-xs fw-bold text-dark text-uppercase mb-2 pb-1 border-bottom">
                        Candidate Registration Details
                    </h6>
                    <table class="w-100 mb-3 text-xs" style="line-height: 1.6;">
                        <tr>
                            <td class="text-muted" style="width: 40%;">Candidate Name:</td>
                            <td class="fw-bold text-dark">{{ $registration->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Father's Name:</td>
                            <td class="text-dark">{{ $registration->father_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Roll Number:</td>
                            <td class="fw-bold text-dark font-monospace">{{ $registration->roll_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Degree / Department:</td>
                            <td class="fw-bold text-dark">{{ $registration->department }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Graduation Session:</td>
                            <td class="text-dark">Batch {{ $registration->class ?? '2022' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">CNIC:</td>
                            <td class="font-monospace">{{ $registration->cnic_formatted ?? $registration->cnic }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Guests Allowed:</td>
                            <td class="fw-bold text-dark">{{ (int)$registration->guests_count }} Guest(s) (Parents/Siblings)</td>
                        </tr>
                    </table>

                    <!-- Fee Breakdown -->
                    <h6 class="text-xs fw-bold text-dark text-uppercase mb-2 pb-1 border-bottom">
                        Payable Fee Breakdown
                    </h6>
                    <div class="border rounded p-2 mb-3 bg-light text-xs">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Graduate Registration (Gown Included)</span>
                            <span class="font-monospace fw-bold">PKR {{ number_format($convocationSettings->base_registration_fee ?? 15000) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Guest Fee ({{ (int)$registration->guests_count }} &times; {{ number_format($convocationSettings->guest_fee_per_person ?? 5000) }})</span>
                            <span class="font-monospace fw-bold">PKR {{ number_format((int)$registration->guests_count * ($convocationSettings->guest_fee_per_person ?? 5000)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 fw-bold text-dark" style="font-size: 0.90rem;">
                            <span>Total Payable Amount</span>
                            <span class="font-monospace" style="color: #0b4f6c;">PKR {{ number_format($registration->fee_amount) }}</span>
                        </div>
                    </div>

                    <!-- Bank Account Info with 1-Tap Copy -->
                    <h6 class="text-xs fw-bold text-dark text-uppercase mb-2 pb-1 border-bottom">
                        Designated Bank Deposit Details
                    </h6>
                    <div class="mobile-bank-card">
                        <div class="mb-2">
                            <span class="text-muted text-xxs d-block">Authorized Bank</span>
                            <strong class="text-dark">{{ $convocationSettings->bank_name ?? 'The Bank of Punjab (BOP)' }} {{ $convocationSettings->secondary_bank ? '/ ' . $convocationSettings->secondary_bank : '' }}</strong>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted text-xxs d-block">Account Title</span>
                            <strong class="text-dark">{{ $convocationSettings->account_title ?? 'SIMC - Convocation Fund' }}</strong>
                        </div>
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted text-xxs d-block">Account Number</span>
                                <strong class="font-monospace text-dark fs-6" id="mb_acc_no">{{ $convocationSettings->account_number ?? '00100458920001' }}</strong>
                            </div>
                            <button type="button" class="copy-pill-btn" onclick="copyToClipboard('{{ $convocationSettings->account_number ?? '00100458920001' }}', this)">
                                <i class="fa fa-copy me-1"></i> Copy
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                            <div style="overflow: hidden; max-width: 80%;">
                                <span class="text-muted text-xxs d-block">IBAN (1Link / Raast)</span>
                                <strong class="font-monospace text-dark text-xxs text-truncate d-block" id="mb_iban">{{ $convocationSettings->iban ?? 'PK36BOPB00100458920001' }}</strong>
                            </div>
                            <button type="button" class="copy-pill-btn" onclick="copyToClipboard('{{ $convocationSettings->iban ?? 'PK36BOPB00100458920001' }}', this)">
                                <i class="fa fa-copy me-1"></i> Copy
                            </button>
                        </div>
                    </div>

                    <!-- Focal Persons Helpline -->
                    @if(isset($convocationFocalPersons) && $convocationFocalPersons->count() > 0)
                        <div class="mt-3 pt-2 border-top text-center text-xxs text-muted">
                            <strong class="text-dark d-block mb-1">Convocation Organizing Committee Focal Persons:</strong>
                            @foreach($convocationFocalPersons as $fp)
                                <div class="mb-1">{{ $fp->name }} ({{ $fp->designation }}): <a href="tel:{{ preg_replace('/[^0-9+]/', '', $fp->mobile) }}" class="fw-bold font-monospace" style="color: #0b4f6c;">{{ $fp->mobile }}</a></div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Mobile Action Buttons -->
                    <div class="mt-3 pt-2 d-grid gap-2">
                        <button type="button" onclick="window.print()" class="btn text-white w-100 py-2 mb-0" style="background: #0f2533; font-weight: 500;">
                            <i class="fa fa-print me-1"></i> Print / Save 3-Part Bank Challan (PDF)
                        </button>
                        <a href="{{ route('student.payment') }}" class="btn text-white w-100 py-2 mb-0" style="background: #0b4f6c; font-weight: 500;">
                            <i class="fa fa-upload me-1"></i> Attach Paid Voucher / Screenshot
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================
             2. DESKTOP / PRINT VIEW (Official 3-Part Bank Challan Sheet)
             ======================================================== -->
        <div class="challan-sheet d-none d-lg-block">
            <div class="row g-2">
                @php
                    $copies = [
                        ['title' => 'Bank Copy', 'sub' => 'To be retained by receiving bank branch'],
                        ['title' => 'Complex / University Copy', 'sub' => 'To be uploaded by student for admin verification'],
                        ['title' => 'Student Copy', 'sub' => 'To be retained by student as proof']
                    ];
                @endphp

                @foreach($copies as $copy)
                    <div class="col-md-4">
                        <div class="challan-copy">
                            <div>
                                <!-- Copy Header -->
                                <div class="copy-header">
                                    <div class="fw-bold text-dark text-uppercase" style="font-size: 0.78rem; letter-spacing: 0.3px;">
                                        {{ strtoupper($convocationSettings->institution_name ?? 'SHAHIDA ISLAM MEDICAL COMPLEX') }}
                                    </div>
                                    <div class="text-xxs text-muted" style="font-size: 0.68rem;">
                                        {{ $convocationSettings->institution_subtitle ?? 'Shahida Islam Medical College • Shahida Islam Dental College' }}
                                    </div>
                                    <div class="fw-bold mt-1" style="font-size: 0.74rem; color: #0b4f6c;">
                                        {{ strtoupper($convocationSettings->convocation_title ?? 'FIRST CONVOCATION 2026') }}
                                    </div>
                                    <div class="text-xxs text-dark font-monospace">
                                        Date: <strong>{{ $convocationSettings->convocation_date_formatted ?? 'Saturday, 28 November 2026' }}</strong>
                                    </div>
                                    <span class="copy-title-badge">{{ $copy['title'] }}</span>
                                </div>

                                <!-- Bank Deposit Details Box -->
                                <div class="bank-box">
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong>Bank:</strong>
                                        <span class="text-dark fw-bold">{{ $convocationSettings->bank_name ?? $bank['bank_name'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong>Account Title:</strong>
                                        <span class="text-dark fw-bold" style="font-size: 0.68rem;">{{ $convocationSettings->account_title ?? 'SIMC - Convocation Fund' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <strong>Account No:</strong>
                                        <span class="font-monospace fw-bold text-dark">{{ $convocationSettings->account_number ?? $bank['account_number'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>IBAN / 1Link:</strong>
                                        <span class="font-monospace text-xxs">{{ $convocationSettings->iban ?? $bank['iban'] }}</span>
                                    </div>
                                </div>

                                <!-- Challan Meta -->
                                <table class="w-100 challan-meta-table mb-2">
                                    <tr>
                                        <td class="text-muted" style="width: 44%;">Challan No:</td>
                                        <td class="font-monospace fw-bold text-dark">{{ $registration->challan_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Issue Date:</td>
                                        <td class="text-dark">{{ now()->format('d-M-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Due Date:</td>
                                        <td class="text-dark fw-bold" style="color: #8a5a0b;">{{ $convocationSettings->registration_deadline_formatted ?? '15-Nov-2026' }} (Deadline)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Graduate Name:</td>
                                        <td class="text-dark fw-bold">{{ $registration->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Father's Name:</td>
                                        <td class="text-dark">{{ $registration->father_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">College Roll No:</td>
                                        <td class="text-dark fw-bold font-monospace">{{ $registration->roll_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Degree / College:</td>
                                        <td class="text-dark fw-bold">{{ $registration->department }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Passing Session:</td>
                                        <td class="text-dark">Batch {{ $registration->class ?? '2022' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">CNIC / B-Form:</td>
                                        <td class="font-monospace">{{ $registration->cnic_formatted ?? $registration->cnic }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Eligible Guests:</td>
                                        <td class="text-dark fw-bold">{{ (int)$registration->guests_count }} Guest(s) (Parents/Siblings)</td>
                                    </tr>
                                </table>

                                <!-- Fee Breakdown Table -->
                                <table class="fee-table">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th class="text-end" style="width: 36%;">Amount (PKR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Graduate Registration Fee
                                                <small class="d-block text-muted" style="font-size: 0.64rem;">({{ $convocationSettings->gown_fee_notice ?? 'Including Convocation Gown' }})</small>
                                            </td>
                                            <td class="text-end font-monospace">{{ number_format($convocationSettings->base_registration_fee ?? 15000) }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Guest Fee ({{ (int)$registration->guests_count }} &times; {{ number_format($convocationSettings->guest_fee_per_person ?? 5000) }})
                                                <small class="d-block text-muted" style="font-size: 0.64rem;">({{ $convocationSettings->guest_eligibility_notice ?? 'Parents/Siblings only' }})</small>
                                            </td>
                                            <td class="text-end font-monospace">
                                                {{ number_format((int)$registration->guests_count * ($convocationSettings->guest_fee_per_person ?? 5000)) }}
                                            </td>
                                        </tr>
                                        <tr style="background: #f8fafb; font-weight: bold;">
                                            <td>Total Fee Payable:</td>
                                            <td class="text-end font-monospace" style="font-size: 0.82rem; color: #0b4f6c;">
                                                {{ number_format($registration->fee_amount) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <small class="text-muted text-xxs d-block mt-1">
                                    Amount in words: <strong>
                                        @php
                                            $totalAmt = (int)$registration->fee_amount;
                                            $amtWords = '';
                                            if (class_exists('\NumberFormatter')) {
                                                try {
                                                    $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
                                                    $amtWords = ucwords($f->format($totalAmt)) . ' Rupees Only';
                                                } catch (\Throwable $e) {
                                                    $amtWords = 'PKR ' . number_format($totalAmt) . ' Only';
                                                }
                                            } else {
                                                $amtWords = 'PKR ' . number_format($totalAmt) . ' Only';
                                            }
                                        @endphp
                                        {{ $amtWords }}
                                    </strong>
                                </small>
                            </div>

                            <!-- Footer & Signatures -->
                            <div>
                                <div class="signature-box">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div style="border-bottom: 1px solid #7a8b99; height: 18px;"></div>
                                            <span class="text-xxs text-muted">Graduate Signature</span>
                                        </div>
                                        <div class="col-6">
                                            <div style="border-bottom: 1px solid #7a8b99; height: 18px;"></div>
                                            <span class="text-xxs text-muted">Bank Cashier / Stamp</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center text-muted text-xxs mt-2 pt-1 border-top" style="font-size: 0.62rem;">
                                    Focal Persons: 
                                    @if(isset($convocationFocalPersons) && $convocationFocalPersons->count() > 0)
                                        {{ $convocationFocalPersons->map(fn($f) => "{$f->name} ({$f->mobile})")->implode(' • ') }}
                                    @else
                                        Convocation Organizing Committee
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(function() {
                var oldHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa fa-check me-1"></i> Copied';
                btn.style.background = '#0b4f6c';
                btn.style.color = '#ffffff';
                setTimeout(function() {
                    btn.innerHTML = oldHtml;
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2000);
            }).catch(function() {
                alert('Account details: ' + text);
            });
        }
    </script>

@endsection
