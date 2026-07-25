@extends('Admin.Layouts.master')

@section('title', trans('admin.academies.show') . " | " . $academies->commercial_name)

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .partner-profile-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #fff;
        border-radius: 16px;
        padding: 28px;
    }
    .partner-logo-img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 16px;
        border: 4px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    .info-card {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
    }
    .info-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: rgba(37, 99, 235, 0.2);
    }
    .info-label {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .info-label i {
        color: #2563eb;
        font-size: 1rem;
    }
    .info-value {
        font-size: 1rem;
        color: #0f172a;
        font-weight: 600;
        word-break: break-word;
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        padding: 12px 20px;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
    }
    .nav-tabs-custom .nav-link.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background: transparent;
    }

    /* SOCIAL MEDIA BADGES */
    .social-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        color: #fff !important;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .social-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.18);
        opacity: 0.95;
    }
    .social-facebook { background: #1877f2; }
    .social-instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .social-linkedin { background: #0a66c2; }
    .social-twitter { background: #000000; }
    .social-whatsapp { background: #25d366; }
    .social-website { background: #2563eb; }

    /* PRINT STYLES */
    @media print {
        body {
            background: #fff !important;
            color: #000 !important;
            font-size: 12pt;
        }
        .secondary-nav, .sidebar-wrapper, header, .nav-tabs, .btn, .no-print {
            display: none !important;
        }
        .main-content, .middle-content, .container-xxl {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .partner-profile-header {
            background: #f8fafc !important;
            color: #000 !important;
            border: 2px solid #cbd5e1 !important;
            box-shadow: none !important;
        }
        .partner-profile-header h3, .partner-profile-header span, .partner-profile-header div {
            color: #000 !important;
        }
        .tab-pane {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .info-card {
            border: 1px solid #cbd5e1 !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMBS -->
    <div class="secondary-nav mb-4 no-print">
        <div class="breadcrumbs-container">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <div class="d-flex breadcrumb-content">
                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ trans('admin.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.academies.index') }}">{{ trans('admin.academies.academies') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $academies->commercial_name }}</li>
                        </ol>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <!-- EXECUTIVE PARTNER HEADER CARD -->
    <div class="partner-profile-header mb-4 shadow">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ $academies->image }}" class="partner-logo-img" alt="{{ $academies->commercial_name }}" onerror="this.src='{{ asset('assetsAdmin/logo/Icon-Primary.svg') }}'">
                <div>
                    <h3 class="fw-bold mb-1 text-white"><i class="fa-solid fa-building-circle-check text-primary me-2"></i> {{ $academies->commercial_name }}</h3>
                    <div class="d-flex flex-wrap align-items-center gap-2 text-white-50 small">
                        <span><i class="fa-solid fa-mobile-screen-button me-1"></i> {{ $academies->app_name ?: 'اسم التطبيق غير محدد' }}</span>
                        <span>•</span>
                        <span><i class="fa-solid fa-user-tie me-1"></i> المالك: {{ $academies->owner_name ?: $academies->first_name . ' ' . $academies->last_name }}</span>
                        <span>•</span>
                        <span><i class="fa-solid fa-envelope me-1"></i> {{ $academies->email }}</span>
                    </div>
                    <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                        <span class="badge {{ $academies->status === 'active' ? 'bg-success' : 'bg-danger' }} px-3 py-1 fs-6">
                            <i class="fa-solid {{ $academies->status === 'active' ? 'fa-circle-check' : 'fa-ban' }} me-1"></i>
                            {{ $academies->status === 'active' ? 'حساب نشط' : 'حساب غير نشط' }}
                        </span>
                        <span class="badge bg-primary px-3 py-1 fs-6">
                            <i class="fa-solid fa-store me-1"></i> {{ ucfirst($academies->business_type ?: 'academy') }}
                        </span>
                        @if($academies->country)
                            <span class="badge bg-secondary px-3 py-1 fs-6">
                                <i class="fa-solid fa-earth-americas me-1"></i> {{ $academies->country->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="d-flex align-items-center gap-2 no-print">
                <button onclick="window.print()" class="btn btn-light btn-sm fw-bold shadow-sm">
                    <i class="fa-solid fa-print me-1 text-primary"></i> طباعة الملف
                </button>
                <a href="{{ route('admin.academies.edit', $academies->id) }}" class="btn btn-warning btn-sm fw-bold shadow-sm">
                    <i class="fa-solid fa-pen-to-square me-1"></i> تعديل الشريك
                </a>
                <form method="POST" action="{{ route('admin.academies.updateStatus', $academies->id) }}" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm fw-bold {{ $academies->status === 'active' ? 'btn-danger' : 'btn-success' }} shadow-sm">
                        <i class="fa-solid {{ $academies->status === 'active' ? 'fa-ban' : 'fa-check' }} me-1"></i>
                        {{ $academies->status === 'active' ? 'تجميد الحساب' : 'تفعيل الحساب' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- TABS NAVIGATION -->
    <ul class="nav nav-tabs nav-tabs-custom mb-4 bg-white rounded-3 shadow-sm px-3 no-print" id="partnerTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"><i class="fa-solid fa-id-card me-1 text-primary"></i> البيانات الأساسية والتجارية</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="legal-tab" data-bs-toggle="tab" data-bs-target="#legal" type="button" role="tab"><i class="fa-solid fa-scale-balanced me-1 text-success"></i> التفاصيل القانونية والبنكية</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="saas-tab" data-bs-toggle="tab" data-bs-target="#saas" type="button" role="tab"><i class="fa-solid fa-file-invoice-dollar me-1 text-warning"></i> اشتراك SaaS والتراخيص</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="team-tab" data-bs-toggle="tab" data-bs-target="#team" type="button" role="tab"><i class="fa-solid fa-users-gear me-1 text-info"></i> طاقم العمل والـ Roles ({{ $academies->users->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="branches-tab" data-bs-toggle="tab" data-bs-target="#branches" type="button" role="tab"><i class="fa-solid fa-code-branch me-1 text-purple"></i> الفروع التابعة ({{ $academies->branches->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs" type="button" role="tab"><i class="fa-solid fa-clock-rotate-left me-1 text-secondary"></i> سجل الأنشطة والـ Audit Logs</button>
        </li>
    </ul>

    <!-- TAB CONTENTS -->
    <div class="tab-content" id="partnerTabsContent">

        <!-- TAB 1: GENERAL & BUSINESS INFO -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fa-solid fa-id-card text-primary me-2"></i> معلومات الهوية والتواصل</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-signature"></i> الاسم التجاري (Commercial Name)</div>
                                <div class="info-value">{{ $academies->getTranslation('commercial_name', 'ar') }} | {{ $academies->getTranslation('commercial_name', 'en') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-mobile-screen-button"></i> اسم التطبيق (App Name)</div>
                                <div class="info-value">{{ $academies->getTranslation('app_name', 'ar') ?? $academies->app_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-envelope"></i> البريد الإلكتروني الرئيسي</div>
                                <div class="info-value"><a href="mailto:{{ $academies->email }}">{{ $academies->email }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-phone-volume"></i> رقم الهاتف / الجوال</div>
                                <div class="info-value"><a href="tel:{{ $academies->phone }}">{{ $academies->phone }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-user-tie"></i> مدير الحساب في المنصة</div>
                                <div class="info-value">{{ $academies->account_manager ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-location-dot"></i> العنوان والموقع</div>
                                <div class="info-value">{{ $academies->address ?: 'المملكة العربية السعودية' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- SOCIAL MEDIA CHANNELS BAR -->
                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-share-nodes text-primary me-2"></i> قنوات التواصل الاجتماعي والموقع الإلكتروني</h5>
                    <div class="d-flex flex-wrap align-items-center gap-3 py-2">
                        @if($academies->website)
                            <a href="{{ $academies->website }}" target="_blank" class="social-badge social-website">
                                <i class="fa-solid fa-globe fa-lg"></i>
                                <span>الموقع الإلكتروني</span>
                            </a>
                        @endif

                        @if($academies->facebook)
                            <a href="{{ $academies->facebook }}" target="_blank" class="social-badge social-facebook">
                                <i class="fa-brands fa-facebook-f fa-lg"></i>
                                <span>فيسبوك (Facebook)</span>
                            </a>
                        @endif

                        @if($academies->instagram)
                            <a href="{{ $academies->instagram }}" target="_blank" class="social-badge social-instagram">
                                <i class="fa-brands fa-instagram fa-lg"></i>
                                <span>انستغرام (Instagram)</span>
                            </a>
                        @endif

                        @if($academies->linkedin)
                            <a href="{{ $academies->linkedin }}" target="_blank" class="social-badge social-linkedin">
                                <i class="fa-brands fa-linkedin-in fa-lg"></i>
                                <span>لينكد إن (LinkedIn)</span>
                            </a>
                        @endif

                        @if($academies->twitter)
                            <a href="{{ $academies->twitter }}" target="_blank" class="social-badge social-twitter">
                                <i class="fa-brands fa-x-twitter fa-lg"></i>
                                <span>تويتر / منصة X</span>
                            </a>
                        @endif

                        @if($academies->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $academies->phone) }}" target="_blank" class="social-badge social-whatsapp">
                                <i class="fa-brands fa-whatsapp fa-lg"></i>
                                <span>واتساب (WhatsApp)</span>
                            </a>
                        @endif

                        @if(!$academies->website && !$academies->facebook && !$academies->instagram && !$academies->linkedin && !$academies->twitter)
                            <span class="text-muted small"><i class="fa-solid fa-circle-info me-1"></i> لم يتم إضافة روابط تواصل اجتماعي لهذا الشريك بعد.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: LEGAL & BANKING DETAILS -->
        <div class="tab-pane fade" id="legal" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fa-solid fa-file-certificate text-success me-2"></i> التفاصيل القانونية والضريبية</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-hashtag"></i> رقم السجل التجاري / الترخيص</div>
                                <div class="info-value">{{ $academies->trade_license_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-calendar-xmark"></i> تاريخ انتهاء الترخيص</div>
                                <div class="info-value">{{ $academies->trade_license_expire_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-percent"></i> الرقم الضريبي (Tax Number)</div>
                                <div class="info-value">{{ $academies->tax_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-chart-line"></i> نسبة العمولة (Commission %)</div>
                                <div class="info-value">{{ $academies->commission_percentage ?: 0 }}%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-business-time"></i> عدد أيام التسوية (Settlement Days)</div>
                                <div class="info-value">{{ $academies->settlement_days_count ?: 0 }} يوم</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-hand-holding-dollar"></i> مهلة عدم الاسترداد (Non-refund Days)</div>
                                <div class="info-value">{{ $academies->non_refund_days_count ?: 0 }} يوم</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-building-columns text-primary me-2"></i> الحساب البنكي للتسويات</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-building-bank"></i> اسم البنك</div>
                                <div class="info-value">{{ $academies->bank_name ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-user-check"></i> اسم المستفيد (Beneficiary)</div>
                                <div class="info-value">{{ $academies->beneficiary_name ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-credit-card"></i> رقم الحساب / الأيبان (IBAN)</div>
                                <div class="info-value"><code>{{ $academies->bank_account_number ?: '-' }}</code></div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-file-signature text-warning me-2"></i> بيانات وثائق العقد</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-file-contract"></i> رقم العقد</div>
                                <div class="info-value">{{ $academies->contract_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-calendar-check"></i> تاريخ توقيع العقد</div>
                                <div class="info-value">{{ $academies->contract_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-calendar-days"></i> تاريخ بداية سريان العقد</div>
                                <div class="info-value">{{ $academies->start_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label"><i class="fa-solid fa-cloud-arrow-down"></i> وثيقة العقد الموثقة</div>
                                <div class="info-value">
                                    @if($academies->contract_link)
                                        <a href="{{ $academies->contract_link }}" target="_blank" class="btn btn-sm btn-primary mt-1"><i class="fa-solid fa-file-pdf me-1"></i> تحميل العقد</a>
                                    @else - @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: SAAS SUBSCRIPTION -->
        <div class="tab-pane fade" id="saas" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fa-solid fa-receipt text-warning me-2"></i> تفاصيل اشتراك باقة SaaS والتراخيص</h5>
                    @if($academies->currentSubscription)
                        @php $sub = $academies->currentSubscription; @endphp
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-box-open"></i> اسم الباقة المسجلة</div>
                                    <div class="info-value text-primary fw-bold">{{ $sub->plan?->name ?: 'باقة مخصصة' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-arrows-rotate"></i> دورة الفوترة (Cycle)</div>
                                    <div class="info-value"><span class="badge bg-info text-dark fs-6">{{ ucfirst($sub->billing_cycle) }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-signal"></i> حالة الاشتراك الحالية</div>
                                    <div class="info-value"><span class="badge {{ $sub->status === 'active' ? 'bg-success' : 'bg-danger' }} fs-6">{{ ucfirst($sub->status) }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-money-bill-wave"></i> قيمة الاشتراك المعتمدة</div>
                                    <div class="info-value fs-5 fw-bold text-success">{{ number_format($sub->price_amount, 2) }} {{ $sub->currency_code }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-calendar-plus"></i> تاريخ بدء الاشتراك</div>
                                    <div class="info-value">{{ $sub->starts_at }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label"><i class="fa-solid fa-calendar-minus"></i> تاريخ انتهاء الاشتراك</div>
                                    <div class="info-value text-danger fw-bold">{{ $sub->ends_at ?: 'غير محدد' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center py-4">
                            <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 d-block text-warning"></i>
                            لا يوجد اشتراك SaaS نشط مسجل لهذه المنشأة حالياً.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TAB 4: TEAM MEMBERS & ROLES -->
        <div class="tab-pane fade" id="team" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-users-gear text-info me-2"></i> مستخدمو الشريك وحسابات طاقم العمل</h5>
                    <span class="badge bg-primary fs-6">{{ $academies->users->count() }} مستخدم</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الدور الوظيفي (Role)</th>
                                    <th>نطاق الفروع المتاحة</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academies->users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">
                                            <i class="fa-solid fa-user-circle text-secondary me-1"></i> {{ $user->name }}
                                            @if($user->is_owner)
                                                <span class="badge bg-warning text-dark ms-1"><i class="fa-solid fa-crown me-1"></i> المالك الرئيسي</span>
                                            @endif
                                        </td>
                                        <td><i class="fa-solid fa-envelope text-muted me-1"></i> {{ $user->email }}</td>
                                        <td><i class="fa-solid fa-phone text-muted me-1"></i> {{ $user->phone ?? '-' }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info text-dark me-1"><i class="fa-solid fa-user-shield me-1"></i> {{ app()->getLocale() == 'ar' ? $role->display_name_ar : $role->display_name_en }}</span>
                                            @endforeach
                                            @if($user->is_owner && $user->roles->isEmpty())
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-crown me-1"></i> مالك الشريك</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->is_owner || $user->access_all_branches)
                                                <span class="badge bg-success"><i class="fa-solid fa-globe me-1"></i> كافة الفروع</span>
                                            @else
                                                <span class="badge bg-secondary" title="{{ $user->assignedBranches->pluck('commercial_name')->join(', ') }}">
                                                    <i class="fa-solid fa-code-branch me-1"></i> {{ $user->assignedBranches->count() }} فرع مخصص
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $user->status === 'active' ? 'نشط' : 'مجمد' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>
                                            لا يوجد مستخدمون مسجلون لهذا الشريك بعد.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: BRANCHES -->
        <div class="tab-pane fade" id="branches" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-code-branch text-purple me-2"></i> الفروع المباشرة التابعة لـ {{ $academies->commercial_name }}</h5>
                    <span class="badge bg-primary fs-6">{{ $academies->branches->count() }} فرع</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم الفرع التجاري</th>
                                    <th>اسم الفرع بالتطبيق</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academies->branches as $branch)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold"><i class="fa-solid fa-store text-primary me-1"></i> {{ $branch->commercial_name }}</td>
                                        <td>{{ $branch->app_name }}</td>
                                        <td><i class="fa-solid fa-envelope text-muted me-1"></i> {{ $branch->email }}</td>
                                        <td><i class="fa-solid fa-phone text-muted me-1"></i> {{ $branch->phone }}</td>
                                        <td><i class="fa-solid fa-calendar me-1"></i> {{ $branch->created_at?->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.academies.show', $branch->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye me-1"></i> عرض التفاصيل
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fa-solid fa-store-slash fa-2x mb-2 d-block"></i>
                                            لا توجد فروع مسجلة تابعة لهذا الشريك حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 6: AUDIT LOGS TIMELINE -->
        <div class="tab-pane fade" id="logs" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i> سجل أحداث وأنشطة الشريك (Audit Trail Log)</h5>
                    <span class="badge bg-secondary fs-6">{{ $academies->activityLogs->count() }} سجل</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم الموظف / المستخدم</th>
                                    <th>نوع الحدث (Action)</th>
                                    <th>وصف العملية</th>
                                    <th>IP Address</th>
                                    <th>التاريخ والوقت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academies->activityLogs->take(50) as $log)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold"><i class="fa-solid fa-user-gear text-secondary me-1"></i> {{ $log->user_name ?? 'الشريك' }}</td>
                                        <td><span class="badge bg-primary px-2 py-1"><i class="fa-solid fa-bolt me-1"></i> {{ $log->action }}</span></td>
                                        <td>{{ $log->description }}</td>
                                        <td><code><i class="fa-solid fa-network-wired me-1"></i> {{ $log->ip_address ?: '-' }}</code></td>
                                        <td><i class="fa-solid fa-clock text-muted me-1"></i> {{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fa-solid fa-clock-rotate-left fa-2x mb-2 d-block"></i>
                                            لا يوجد أنشطة مسجلة في السجل الزمني لهذا الشريك بعد.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerTabList = [].slice.call(document.querySelectorAll('#partnerTabs button'));
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            });
        });
    });
</script>
@endpush
