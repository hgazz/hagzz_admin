@extends('Admin.Layouts.master')

@section('title', trans('admin.academies.show') . " | " . $academies->commercial_name)

@push('css')
<style>
    .partner-profile-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #fff;
        border-radius: 16px;
        padding: 24px;
    }
    .partner-logo-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 16px;
        border: 4px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .info-card {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .info-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .info-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 0.98rem;
        color: #1e293b;
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
</style>
@endpush

@section('content')
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMBS -->
    <div class="secondary-nav mb-4">
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
                    <h3 class="fw-bold mb-1 text-white">{{ $academies->commercial_name }}</h3>
                    <div class="d-flex flex-wrap align-items-center gap-2 text-white-50 small">
                        <span><i class="fa-solid fa-store me-1"></i> {{ $academies->app_name ?: 'اسم التطبيق غير محدد' }}</span>
                        <span>•</span>
                        <span><i class="fa-solid fa-user-tie me-1"></i> المالك: {{ $academies->owner_name ?: $academies->first_name . ' ' . $academies->last_name }}</span>
                        <span>•</span>
                        <span><i class="fa-solid fa-envelope me-1"></i> {{ $academies->email }}</span>
                    </div>
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <span class="badge {{ $academies->status === 'active' ? 'bg-success' : 'bg-danger' }} px-3 py-1">
                            <i class="fa-solid {{ $academies->status === 'active' ? 'fa-circle-check' : 'fa-ban' }} me-1"></i>
                            {{ $academies->status === 'active' ? 'حساب نشط' : 'حساب غير نشط' }}
                        </span>
                        <span class="badge bg-primary px-3 py-1">
                            <i class="fa-solid fa-building me-1"></i> {{ ucfirst($academies->business_type ?: 'academy') }}
                        </span>
                        @if($academies->country)
                            <span class="badge bg-secondary px-3 py-1">
                                <i class="fa-solid fa-globe me-1"></i> {{ $academies->country->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.academies.edit', $academies->id) }}" class="btn btn-warning btn-sm fw-bold">
                    <i class="fa-solid fa-pen-to-square me-1"></i> تعديل الشريك
                </a>
                <form method="POST" action="{{ route('admin.academies.updateStatus', $academies->id) }}" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm fw-bold {{ $academies->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                        <i class="fa-solid {{ $academies->status === 'active' ? 'fa-ban' : 'fa-check' }} me-1"></i>
                        {{ $academies->status === 'active' ? 'تجميد الشريك' : 'تفعيل الشريك' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- TABS NAVIGATION -->
    <ul class="nav nav-tabs nav-tabs-custom mb-4 bg-white rounded-3 shadow-sm px-3" id="partnerTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"><i class="fa-solid fa-circle-info me-1"></i> البيانات الأساسية والتجارية</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="legal-tab" data-bs-toggle="tab" data-bs-target="#legal" type="button" role="tab"><i class="fa-solid fa-file-contract me-1"></i> التفاصيل القانونية والبنكية</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="saas-tab" data-bs-toggle="tab" data-bs-target="#saas" type="button" role="tab"><i class="fa-solid fa-receipt me-1"></i> اشتراك SaaS والتراخيص</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="team-tab" data-bs-toggle="tab" data-bs-target="#team" type="button" role="tab"><i class="fa-solid fa-users-gear me-1"></i> طاقم العمل والـ Roles ({{ $academies->users->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="branches-tab" data-bs-toggle="tab" data-bs-target="#branches" type="button" role="tab"><i class="fa-solid fa-code-branch me-1"></i> الفروع التابعة ({{ $academies->branches->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs" type="button" role="tab"><i class="fa-solid fa-list-check me-1"></i> سجل الأنشطة والـ Audit Logs</button>
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
                                <div class="info-label">الاسم التجاري (Commercial Name)</div>
                                <div class="info-value">{{ $academies->getTranslation('commercial_name', 'ar') }} | {{ $academies->getTranslation('commercial_name', 'en') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">اسم التطبيق (App Name)</div>
                                <div class="info-value">{{ $academies->getTranslation('app_name', 'ar') ?? $academies->app_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">البريد الإلكتروني</div>
                                <div class="info-value"><a href="mailto:{{ $academies->email }}">{{ $academies->email }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">رقم الهاتف / الجوال</div>
                                <div class="info-value"><a href="tel:{{ $academies->phone }}">{{ $academies->phone }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">مدير الحساب في المنصة (Account Manager)</div>
                                <div class="info-value">{{ $academies->account_manager ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">العنوان والموقع</div>
                                <div class="info-value">{{ $academies->address ?: 'المملكة العربية السعودية' }}</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-share-nodes text-primary me-2"></i> روئية التواصل الاجتماعي والموقع</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="info-card p-3 text-center">
                                <div class="info-label">الموقع الإلكتروني</div>
                                <div class="info-value">
                                    @if($academies->website)
                                        <a href="{{ $academies->website }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1"><i class="fa-solid fa-globe me-1"></i> زيارة الموقع</a>
                                    @else - @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3 text-center">
                                <div class="info-label">فيسبوك (Facebook)</div>
                                <div class="info-value">
                                    @if($academies->facebook)
                                        <a href="{{ $academies->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1"><i class="fa-brands fa-facebook me-1"></i> الصفحة</a>
                                    @else - @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3 text-center">
                                <div class="info-label">انستغرام (Instagram)</div>
                                <div class="info-value">
                                    @if($academies->instagram)
                                        <a href="{{ $academies->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger mt-1"><i class="fa-brands fa-instagram me-1"></i> الحساب</a>
                                    @else - @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3 text-center">
                                <div class="info-label">لينكد إن (LinkedIn)</div>
                                <div class="info-value">
                                    @if($academies->linkedin)
                                        <a href="{{ $academies->linkedin }}" target="_blank" class="btn btn-sm btn-outline-info mt-1"><i class="fa-brands fa-linkedin me-1"></i> الملف</a>
                                    @else - @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: LEGAL & BANKING DETAILS -->
        <div class="tab-pane fade" id="legal" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fa-solid fa-scale-balanced text-primary me-2"></i> التفاصيل القانونية والضريبية</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">رقم السجل التجاري / الترخيص</div>
                                <div class="info-value">{{ $academies->trade_license_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">تاريخ انتهاء الترخيص</div>
                                <div class="info-value">{{ $academies->trade_license_expire_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">الرقم الضريبي (Tax Number)</div>
                                <div class="info-value">{{ $academies->tax_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">نسبة العمولة (Commission %)</div>
                                <div class="info-value">{{ $academies->commission_percentage ?: 0 }}%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">عدد أيام التسوية (Settlement Days)</div>
                                <div class="info-value">{{ $academies->settlement_days_count ?: 0 }} يوم</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">مهلة عدم الاسترداد (Non-refund Days)</div>
                                <div class="info-value">{{ $academies->non_refund_days_count ?: 0 }} يوم</div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-building-columns text-primary me-2"></i> الحساب البنكي للتسويات</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">اسم البنك</div>
                                <div class="info-value">{{ $academies->bank_name ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">اسم المستفيد (Beneficiary)</div>
                                <div class="info-value">{{ $academies->beneficiary_name ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-3">
                                <div class="info-label">رقم الحساب / الأيبان (IBAN)</div>
                                <div class="info-value"><code>{{ $academies->bank_account_number ?: '-' }}</code></div>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-3 border-bottom pb-2"><i class="fa-solid fa-file-contract text-primary me-2"></i> بيانات العقد</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label">رقم العقد</div>
                                <div class="info-value">{{ $academies->contract_number ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label">تاريخ توقيع العقد</div>
                                <div class="info-value">{{ $academies->contract_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label">تاريخ بداية العمل بالعقد</div>
                                <div class="info-value">{{ $academies->start_date ?: '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card p-3">
                                <div class="info-label">رابط العقد الموثق</div>
                                <div class="info-value">
                                    @if($academies->contract_link)
                                        <a href="{{ $academies->contract_link }}" target="_blank" class="btn btn-sm btn-primary"><i class="fa-solid fa-download me-1"></i> تحميل العقد</a>
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
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fa-solid fa-receipt text-primary me-2"></i> تفاصيل اشتراك باقة SaaS</h5>
                    @if($academies->currentSubscription)
                        @php $sub = $academies->currentSubscription; @endphp
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">اسم الباقة المسجلة</div>
                                    <div class="info-value text-primary fw-bold">{{ $sub->plan?->name ?: 'باقة مخصصة' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">دورة الفوترة (Cycle)</div>
                                    <div class="info-value"><span class="badge bg-info text-dark">{{ ucfirst($sub->billing_cycle) }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">حالة الاشتراك الحالية</div>
                                    <div class="info-value"><span class="badge {{ $sub->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ ucfirst($sub->status) }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">قيمة الاشتراك المعتمدة</div>
                                    <div class="info-value fs-5 fw-bold text-success">{{ number_format($sub->price_amount, 2) }} {{ $sub->currency_code }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">تاريخ بدء الاشتراك</div>
                                    <div class="info-value">{{ $sub->starts_at }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3">
                                    <div class="info-label">تاريخ انتهاء الاشتراك</div>
                                    <div class="info-value text-danger fw-bold">{{ $sub->ends_at ?: 'غير محدد' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center py-4">
                            <i class="fa-solid fa-circle-exclamation fa-2x mb-2 d-block"></i>
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
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-users-gear text-primary me-2"></i> مستخدمو الشريك وحسابات طاقم العمل</h5>
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
                                            {{ $user->name }}
                                            @if($user->is_owner)
                                                <span class="badge bg-warning text-dark ms-1"><i class="fa-solid fa-crown me-1"></i> المالك الرئيسي</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info text-dark me-1">{{ app()->getLocale() == 'ar' ? $role->display_name_ar : $role->display_name_en }}</span>
                                            @endforeach
                                            @if($user->is_owner && $user->roles->isEmpty())
                                                <span class="badge bg-warning text-dark">مالك الشريك</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->is_owner || $user->access_all_branches)
                                                <span class="badge bg-success">كافة الفروع</span>
                                            @else
                                                <span class="badge bg-secondary" title="{{ $user->assignedBranches->pluck('commercial_name')->join(', ') }}">
                                                    {{ $user->assignedBranches->count() }} فرع مخصص
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
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-code-branch text-primary me-2"></i> الفروع المباشرة التابعة لـ {{ $academies->commercial_name }}</h5>
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
                                        <td class="fw-bold">{{ $branch->commercial_name }}</td>
                                        <td>{{ $branch->app_name }}</td>
                                        <td>{{ $branch->email }}</td>
                                        <td>{{ $branch->phone }}</td>
                                        <td>{{ $branch->created_at?->format('Y-m-d') }}</td>
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
                    <h5 class="card-title m-0 fw-bold"><i class="fa-solid fa-list-check text-primary me-2"></i> سجل أحداث وأنشطة الشريك (Audit Trail Log)</h5>
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
                                        <td class="fw-bold">{{ $log->user_name ?? 'الشريك' }}</td>
                                        <td><span class="badge bg-primary px-2 py-1">{{ $log->action }}</span></td>
                                        <td>{{ $log->description }}</td>
                                        <td><code>{{ $log->ip_address ?: '-' }}</code></td>
                                        <td>{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
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
