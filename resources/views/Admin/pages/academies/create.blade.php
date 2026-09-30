@extends('Admin.Layouts.master')

@section('title', trans('admin.academies.create'))

@php
    $errorGroups = [
        ['first_name','last_name','role','business_type','country_id','email','password','phone'],
        ['app_name_en','app_name_ar','sport_id','branch_to','facebook','website','instagram','linkedin'],
        ['name','commercial_name_en','commercial_name_ar','trade_license_number','trade_license_expire_date','tax_number','commission_percentage'],
        ['bank_account_type','bank_name','beneficiary_name','bank_account_number'],
        ['contract_date','start_date','end_date','contract_number','account_manager','settlement_days_count','non_refund_days_count','contract_link','image','status'],
        ['saas_plan_id','billing_cycle','custom_price','offer_name','free_months','discount_type','discount_value','discount_starts_at','discount_ends_at','subscription_starts_at','subscription_ends_at','billing_starts_at','grace_days','billing_notes','subscription_status','auto_renew'],
    ];
    $initialTab = 0;
    foreach ($errorGroups as $tabIndex => $fields) {
        if ($errors->hasAny($fields)) { $initialTab = $tabIndex; break; }
    }
@endphp

@push('css')
    <link rel="stylesheet" href="{{ asset(app()->getLocale() === 'en' ? 'assetsAdmin/academy-ltr.css' : 'assetsAdmin/academy-rtl.css') }}">
    <style>
        .academy-create-page {
            --create-primary: #2563eb;
            --create-primary-hover: #1d4ed8;
            --create-ink: #172033;
            --create-muted: #667085;
            --create-border: #e4e9f0;
            --create-surface: #f8fafc;
            --create-danger: #ef4444;
            --create-success: #10b981;
        }
        .academy-create-page svg { stroke-width: 2; }

        /* Top Header */
        .create-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
            padding: 18px 22px;
            background: #fff;
            border: 1px solid var(--create-border);
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(23, 32, 51, 0.04);
        }
        .create-page-head h3 {
            color: var(--create-ink);
            font-weight: 700;
            font-size: 19px;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .create-page-head p {
            color: var(--create-muted);
            margin: 0;
            font-size: 13px;
        }
        .create-back {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 42px;
            border: 1px solid var(--create-border);
            border-radius: 8px;
            background: #fff;
            color: var(--create-ink);
            transition: all .2s;
        }
        .create-back:hover {
            background: var(--create-surface);
            color: var(--create-primary);
        }

        /* Stepper progress */
        .stepper-progress-wrap {
            margin-bottom: 20px;
            background: #fff;
            border: 1px solid var(--create-border);
            border-radius: 10px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 2px 10px rgba(23, 32, 51, 0.03);
        }
        .stepper-progress-text {
            font-size: 13px;
            font-weight: 600;
            color: var(--create-ink);
            white-space: nowrap;
        }
        .stepper-progress-bar-bg {
            flex: 1;
            height: 8px;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
        }
        .stepper-progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            border-radius: 99px;
            transition: width 0.35s ease;
        }
        .stepper-progress-pct {
            font-size: 12px;
            font-weight: 700;
            color: var(--create-primary);
            min-width: 38px;
            text-align: end;
        }

        /* Global Alert */
        .create-global-alert {
            margin-bottom: 20px;
            padding: 16px 20px;
            border-radius: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.08);
        }
        .create-global-alert ul {
            margin: 6px 0 0;
            padding-inline-start: 22px;
        }
        .create-global-alert li {
            margin-bottom: 3px;
            font-size: 13px;
        }

        /* Form Grid Layout */
        #signUpForm.partner-edit-form {
            max-width: none;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            gap: 20px;
            align-items: start;
            margin: 0;
            padding: 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
        }

        /* Sidebar Stepper */
        .partner-edit-form .form-header {
            grid-column: 1;
            grid-row: 1 / span 2;
            display: flex !important;
            flex-direction: column;
            gap: 6px !important;
            position: sticky;
            top: 85px;
            margin: 0 !important;
            padding: 12px;
            border: 1px solid var(--create-border);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(23, 32, 51, 0.04);
            text-align: start !important;
        }
        .partner-edit-form .form-header .stepIndicator {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            min-height: 52px;
            padding: 10px 12px !important;
            border: 1px solid transparent;
            border-radius: 8px;
            color: #475467;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all .2s ease;
            user-select: none;
        }
        .partner-edit-form .form-header .stepIndicator::before {
            content: attr(data-step-number);
            position: static !important;
            width: 30px !important;
            height: 30px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 30px;
            transform: none !important;
            border: 1px solid var(--create-border) !important;
            border-radius: 8px !important;
            background: var(--create-surface) !important;
            color: #667085;
            font-size: 12px;
            font-weight: 700;
            transition: all .2s;
        }
        .partner-edit-form .form-header .stepIndicator::after {
            display: none !important;
        }
        .partner-edit-form .form-header .stepIndicator:hover {
            color: var(--create-primary);
            background: #f8faff;
        }
        .partner-edit-form .form-header .stepIndicator.active {
            border-color: #bfd0f7;
            color: var(--create-primary);
            background: #eff5ff;
        }
        .partner-edit-form .form-header .stepIndicator.active::before {
            border-color: var(--create-primary) !important;
            background: var(--create-primary) !important;
            color: #fff;
        }
        .partner-edit-form .form-header .stepIndicator.finish::before {
            content: "✓";
            border-color: #10b981 !important;
            background: #10b981 !important;
            color: #fff;
        }
        .partner-edit-form .form-header .stepIndicator.has-error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #dc2626;
        }
        .partner-edit-form .form-header .stepIndicator.has-error::before {
            border-color: #ef4444 !important;
            background: #ef4444 !important;
            color: #fff;
        }
        .step-err-badge {
            margin-inline-start: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 99px;
            font-weight: 700;
        }
        .partner-edit-form .form-header .stepIndicator > svg {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
            color: #667085;
        }
        .partner-edit-form .form-header .stepIndicator.active > svg {
            color: var(--create-primary);
        }

        /* Step Content Card */
        .partner-edit-form .step {
            grid-column: 2;
            grid-row: 1;
            display: none;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 20px;
            min-width: 0;
            margin: 0;
            padding: 26px;
            border: 1px solid var(--create-border);
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(23, 32, 51, 0.04);
        }
        .partner-edit-form .step > p:first-child {
            grid-column: 1 / -1;
            margin: 0 0 6px !important;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--create-border);
            color: var(--create-ink);
            font-size: 18px;
            font-weight: 700;
            text-align: start !important;
        }
        .partner-edit-form .step > .mb-3 {
            min-width: 0;
            margin: 0 !important;
            position: relative;
        }
        .partner-edit-form label,
        .partner-edit-form .step > .mb-3 > span:first-child {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #344054;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }
        .partner-edit-form label code,
        .partner-edit-form .step > .mb-3 > span:first-child code {
            color: #ef4444;
            font-weight: bold;
        }
        .partner-edit-form input:not([type="checkbox"]):not([type="radio"]),
        .partner-edit-form select,
        .partner-edit-form textarea {
            width: 100%;
            min-height: 46px;
            padding: 10px 14px;
            border: 1px solid #dfe4eb;
            border-radius: 8px;
            background: #fff;
            color: var(--create-ink);
            font-size: 13px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .partner-edit-form input:focus,
        .partner-edit-form select:focus,
        .partner-edit-form textarea:focus {
            border-color: var(--create-primary);
            outline: 0;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        /* Field Invalid & Error Messages */
        .partner-edit-form input.invalid,
        .partner-edit-form select.invalid,
        .partner-edit-form textarea.invalid,
        .partner-edit-form input.is-invalid,
        .partner-edit-form select.is-invalid {
            border-color: #ef4444 !important;
            background-color: #fffbfa;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1) !important;
            animation: shakeInput 0.35s ease-in-out;
        }
        @keyframes shakeInput {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }
        .field-error-text {
            color: #dc2626;
            font-size: 11.5px;
            font-weight: 600;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: fadeIn .2s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-3px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .step-warning-alert {
            grid-column: 1 / -1;
            padding: 12px 16px;
            border-radius: 8px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 4px;
        }

        .partner-edit-form .select2-container { width: 100% !important; }
        .partner-edit-form .select2-container .select2-selection--multiple {
            min-height: 46px;
            border-color: #dfe4eb;
            border-radius: 8px;
        }
        .partner-edit-form #sports_wrap > div { width: 100%; }
        .partner-edit-form .password-toggle-eye {
            position: absolute;
            top: 36px;
            inset-inline-end: 14px;
            color: var(--create-muted);
            cursor: pointer;
            z-index: 5;
        }

        /* SaaS Subscription styling */
        .partner-edit-form .subscription-step { position: relative; }
        .partner-edit-form .subscription-duration-card {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid #b9cffd;
            border-radius: 8px;
            background: #f4f8ff;
        }
        .partner-edit-form .subscription-duration-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 40px;
            border-radius: 8px;
            background: #fff;
            color: var(--create-primary);
        }
        .partner-edit-form .subscription-duration-card small {
            display: block;
            color: var(--create-muted);
            font-size: 11px;
            margin-bottom: 3px;
        }
        .partner-edit-form .subscription-duration-card strong {
            display: block;
            color: var(--create-ink);
            font-size: 14px;
        }
        .partner-edit-form .subscription-step #market_price_preview {
            grid-column: 1 / -1;
            margin: 0;
            border: 1px solid #b9cffd;
            border-radius: 8px;
            background: #eff6ff;
            color: #1849a9;
            font-size: 13px;
        }
        .partner-edit-form .subscription-step .form-check {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 48px;
            padding: 12px 16px;
            border: 1px solid var(--create-border);
            border-radius: 8px;
            background: var(--create-surface);
        }
        .partner-edit-form .subscription-step .form-check-input {
            float: none;
            width: 38px;
            height: 20px;
            min-height: 20px;
            margin: 0;
        }

        /* Sticky Footer */
        .partner-edit-form .form-footer {
            grid-column: 2;
            grid-row: 2;
            position: sticky;
            bottom: 12px;
            z-index: 30;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 14px 20px;
            border: 1px solid var(--create-border);
            border-radius: 12px;
            background: rgba(255, 255, 255, .97);
            box-shadow: 0 10px 30px rgba(23, 32, 51, .1);
            backdrop-filter: blur(10px);
        }
        .partner-edit-form .form-footer-buttons {
            display: flex;
            gap: 10px;
        }
        .partner-edit-form .form-footer button {
            min-width: 130px;
            min-height: 44px;
            margin: 0 !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }
        .partner-edit-form .form-footer #prevBtn {
            border: 1px solid var(--create-border) !important;
            background: #fff !important;
            color: #344054 !important;
        }
        .partner-edit-form .form-footer #prevBtn:hover {
            background: #f8fafc !important;
        }
        .partner-edit-form .form-footer #nextBtn {
            border: 1px solid var(--create-primary) !important;
            background: var(--create-primary) !important;
            color: #fff !important;
        }
        .partner-edit-form .form-footer #nextBtn:hover {
            background: var(--create-primary-hover) !important;
        }

        @media (max-width: 991.98px) {
            #signUpForm.partner-edit-form { grid-template-columns: 1fr; }
            .partner-edit-form .form-header {
                grid-column: 1;
                grid-row: 1;
                flex-direction: row;
                position: static;
                overflow-x: auto;
                padding: 10px;
            }
            .partner-edit-form .form-header .stepIndicator { flex: 0 0 190px !important; }
            .partner-edit-form .step { grid-column: 1; grid-row: 2; }
            .partner-edit-form .form-footer { grid-column: 1; grid-row: 3; }
        }
        @media (max-width: 575.98px) {
            .partner-edit-form .step { grid-template-columns: 1fr; padding: 16px; }
            .partner-edit-form .form-footer { flex-direction: column-reverse; gap: 10px; }
            .partner-edit-form .form-footer-buttons { width: 100%; display: grid; grid-template-columns: 1fr 1fr; }
            .partner-edit-form .form-footer button { width: 100%; min-width: 0; }
        }
    </style>
@endpush

@section('content')
<div class="middle-content container-xxl p-0 academy-create-page">
    <!-- Top Header -->
    <div class="create-page-head">
        <div>
            <h3>
                <x-feather-icon name="plus-circle" class="text-primary" />
                {{ trans('admin.academies.create') }}
            </h3>
            <p>{{ app()->getLocale() === 'ar' ? 'أدخل بيانات المكان أو الأكاديمية خطوة بخطوة مع تدقيق فوري لمنع تكرار الإدخال' : 'Enter academy or venue details step by step with real-time field validation' }}</p>
        </div>
        <a class="create-back" href="{{ route('admin.academies.index') }}" title="{{ trans('admin.user.back') }}">
            <x-feather-icon :name="app()->getLocale() === 'ar' ? 'arrow-right' : 'arrow-left'" />
        </a>
    </div>

    <!-- Stepper Progress Bar -->
    <div class="stepper-progress-wrap">
        <span class="stepper-progress-text" id="stepperProgressLabel">{{ app()->getLocale() === 'ar' ? 'الخطوة 1 من 6: البيانات الأساسية' : 'Step 1 of 6: Basic Information' }}</span>
        <div class="stepper-progress-bar-bg">
            <div class="stepper-progress-bar-fill" id="stepperProgressBar" style="width: 16.66%;"></div>
        </div>
        <span class="stepper-progress-pct" id="stepperProgressPct">17%</span>
    </div>

    <!-- Clean Global Alert Outside the Grid -->
    @if ($errors->any())
        <div class="create-global-alert d-flex align-items-start gap-3">
            <x-feather-icon name="alert-triangle" class="text-danger flex-shrink-0 mt-1" style="width:22px;height:22px;" />
            <div class="w-100">
                <strong class="d-block mb-1 text-danger font-size-14">{{ app()->getLocale() === 'ar' ? 'تعذر حفظ البيانات لوجود أخطاء (تم فتح الخطوة المعنية تلقائياً لتصحيحها):' : 'Could not save data due to errors (automatically opened the relevant step to fix):' }}</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form id="signUpForm" class="partner-edit-form" action="{{ route('admin.academies.store') }}" method="post" enctype="multipart/form-data">
        @include('Admin.pages.academies.partials._form')
    </form>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signUpForm');
    if (!form) return;

    const steps = Array.from(form.querySelectorAll('.step'));
    const indicators = Array.from(form.querySelectorAll('.stepIndicator'));
    const progressBar = document.getElementById('stepperProgressBar');
    const progressLabel = document.getElementById('stepperProgressLabel');
    const progressPct = document.getElementById('stepperProgressPct');
    const isAr = {{ app()->getLocale() === 'ar' ? 'true' : 'false' }};

    const nextLabel = @json(trans('admin.academies.Next'));
    const submitLabel = @json(trans('admin.submit'));

    const stepTitles = [
        isAr ? 'البيانات الأساسية' : 'Basic Information',
        isAr ? 'تفاصيل الشريك' : 'Partner Details',
        isAr ? 'البيانات القانونية والضريبية' : 'Legal & Tax Details',
        isAr ? 'بيانات الفوترة والبنك' : 'Billing Details',
        isAr ? 'بيانات العقد' : 'Contract Details',
        isAr ? 'باقة الاشتراك' : 'Subscription'
    ];

    // Explicit required field names per step
    const requiredFields = {
        0: ['first_name', 'last_name', 'role', 'business_type', 'country_id', 'email', 'password', 'phone'],
        1: ['app_name_en', 'app_name_ar'],
        2: ['name', 'commercial_name_en', 'commercial_name_ar', 'commission_percentage'],
        3: ['bank_account_type', 'bank_name', 'beneficiary_name', 'bank_account_number'],
        4: ['contract_date', 'start_date', 'end_date', 'contract_number', 'account_manager', 'settlement_days_count', 'non_refund_days_count', 'status'],
        5: []
    };

    const min3Fields = ['first_name', 'last_name', 'commercial_name_en', 'commercial_name_ar', 'app_name_en', 'app_name_ar', 'name', 'account_manager'];

    let currentTab = {{ $initialTab }};

    // Replace footer with clean responsive buttons
    const footer = form.querySelector('.form-footer');
    if (footer) {
        footer.innerHTML = `
            <div class="text-muted small fw-semibold" id="footerStepIndicator">
                ${isAr ? 'الخطوة' : 'Step'} <span id="currentStepNum">1</span> ${isAr ? 'من 6' : 'of 6'}
            </div>
            <div class="form-footer-buttons">
                <button type="button" id="prevBtn" class="btn">${@json(trans('admin.academies.Previous'))}</button>
                <button type="button" id="nextBtn" class="btn">${nextLabel}</button>
            </div>
        `;
    }

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const currentStepNum = document.getElementById('currentStepNum');

    function updateProgress(tab) {
        const pct = Math.round(((tab + 1) / steps.length) * 100);
        if (progressBar) progressBar.style.width = pct + '%';
        if (progressPct) progressPct.textContent = pct + '%';
        if (progressLabel) {
            progressLabel.textContent = `${isAr ? 'الخطوة' : 'Step'} ${tab + 1} ${isAr ? 'من' : 'of'} ${steps.length}: ${stepTitles[tab] || ''}`;
        }
        if (currentStepNum) currentStepNum.textContent = (tab + 1);
    }

    function showTab(n) {
        currentTab = Math.max(0, Math.min(n, steps.length - 1));
        steps.forEach((step, idx) => {
            step.style.display = (idx === currentTab) ? 'grid' : 'none';
        });

        indicators.forEach((ind, idx) => {
            ind.classList.toggle('active', idx === currentTab);
        });

        if (prevBtn) prevBtn.style.visibility = (currentTab === 0) ? 'hidden' : 'visible';
        if (nextBtn) nextBtn.textContent = (currentTab === steps.length - 1) ? submitLabel : nextLabel;

        updateProgress(currentTab);

        if (window.innerWidth < 992) {
            indicators[currentTab]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    function getFieldLabel(field) {
        const parent = field.closest('.mb-3');
        const lbl = parent ? parent.querySelector('label, span:first-child') : null;
        if (lbl) {
            const clone = lbl.cloneNode(true);
            clone.querySelectorAll('code, .badge, svg').forEach(el => el.remove());
            return clone.textContent.trim();
        }
        return field.name || (isAr ? 'هذا الحقل' : 'This field');
    }

    function showFieldError(field, message) {
        field.classList.add('invalid', 'is-invalid');
        const parent = field.closest('.mb-3') || field.parentElement;
        let errDiv = parent.querySelector('.field-error-text');
        if (!errDiv) {
            errDiv = document.createElement('div');
            errDiv.className = 'field-error-text';
            parent.appendChild(errDiv);
        }
        errDiv.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> ${message}`;
    }

    function clearFieldError(field) {
        field.classList.remove('invalid', 'is-invalid');
        const parent = field.closest('.mb-3') || field.parentElement;
        const errDiv = parent ? parent.querySelector('.field-error-text') : null;
        if (errDiv) errDiv.remove();
    }

    function validateField(field) {
        if (!field || field.disabled || field.closest('.d-none') || field.offsetParent === null) {
            return true;
        }

        const name = field.getAttribute('name') || '';
        const cleanName = name.replace('[]', '');
        const val = String(field.value || '').trim();
        const stepReqs = requiredFields[currentTab] || [];
        const isRequired = stepReqs.includes(cleanName) || field.hasAttribute('required') || field.classList.contains('formInput');

        // Required check
        if (isRequired) {
            if (field.tagName === 'SELECT' && field.multiple) {
                if (field.selectedOptions.length === 0) {
                    showFieldError(field, isAr ? 'يرجى اختيار قيمة واحدة على الأقل' : 'Please select at least one option');
                    return false;
                }
            } else if (val === '') {
                const label = getFieldLabel(field);
                showFieldError(field, isAr ? `${label} مطلوب ولا يمكن تركه فارغاً` : `${label} is required`);
                return false;
            }
        }

        // Min 3 characters check
        if (min3Fields.includes(cleanName) && val !== '' && val.length < 3) {
            const label = getFieldLabel(field);
            showFieldError(field, isAr ? `${label} يجب ألا يقل عن 3 أحرف` : `${label} must be at least 3 characters`);
            return false;
        }

        // Email validation
        if (cleanName === 'email' || field.type === 'email') {
            if (val !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                showFieldError(field, isAr ? 'يرجى إدخال بريد إلكتروني صالح (مثال: name@domain.com)' : 'Please enter a valid email address');
                return false;
            }
        }

        // Phone validation
        if (cleanName === 'phone' || field.type === 'tel') {
            const digits = val.replace(/\D/g, '');
            if (val !== '' && digits.length < 8) {
                showFieldError(field, isAr ? 'رقم الهاتف غير مكتمل (8 أرقام على الأقل)' : 'Phone number must have at least 8 digits');
                return false;
            }
        }

        // Password validation
        if (cleanName === 'password') {
            if (val !== '' && val.length < 8) {
                showFieldError(field, isAr ? 'كلمة المرور يجب أن تتكون من 8 خانات على الأقل' : 'Password must be at least 8 characters');
                return false;
            }
        }

        // Commission percentage
        if (cleanName === 'commission_percentage') {
            const num = Number(val);
            if (val !== '' && (isNaN(num) || num < 0 || num > 100)) {
                showFieldError(field, isAr ? 'نسبة العمولة يجب أن تكون رقماً بين 0 و 100' : 'Commission must be between 0 and 100');
                return false;
            }
        }

        // Dates comparison
        if (cleanName === 'end_date') {
            const startInput = steps[currentTab].querySelector('input[name="start_date"]');
            if (startInput && startInput.value && val && val <= startInput.value) {
                showFieldError(field, isAr ? 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء' : 'End date must be after start date');
                return false;
            }
        }

        // Discount type check if discount value > 0
        if (cleanName === 'discount_value' && val !== '' && Number(val) > 0) {
            const discType = steps[currentTab].querySelector('select[name="discount_type"]');
            if (discType && discType.value === '') {
                showFieldError(discType, isAr ? 'يرجى اختيار نوع الخصم عند إدخال قيمة للخصم' : 'Please select discount type');
                return false;
            }
        }

        clearFieldError(field);
        return true;
    }

    function validateCurrentStep() {
        const step = steps[currentTab];
        const fields = Array.from(step.querySelectorAll('input, select, textarea'));
        let firstInvalid = null;
        let invalidCount = 0;

        fields.forEach(field => {
            if (!validateField(field)) {
                invalidCount++;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        let warningAlert = step.querySelector('.step-warning-alert');
        if (invalidCount > 0) {
            if (!warningAlert) {
                warningAlert = document.createElement('div');
                warningAlert.className = 'step-warning-alert';
                const firstChild = step.querySelector('p:first-child');
                if (firstChild) firstChild.after(warningAlert);
                else step.prepend(warningAlert);
            }
            warningAlert.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>${isAr ? `يوجد ${invalidCount} حقل به خطأ في هذه الخطوة، يرجى استكمالها للمتابعة.` : `There are ${invalidCount} invalid fields in this step. Please correct them to proceed.`}</span>
            `;

            indicators[currentTab]?.classList.add('has-error');
            let badge = indicators[currentTab]?.querySelector('.step-err-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'step-err-badge';
                indicators[currentTab]?.appendChild(badge);
            }
            badge.textContent = invalidCount;

            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        } else {
            if (warningAlert) warningAlert.remove();
            indicators[currentTab]?.classList.remove('has-error');
            indicators[currentTab]?.classList.add('finish');
            indicators[currentTab]?.querySelector('.step-err-badge')?.remove();
            return true;
        }
    }

    // Attach instant clearing listeners
    form.querySelectorAll('input, select, textarea').forEach(field => {
        const handler = function () {
            if (field.classList.contains('invalid') || field.classList.contains('is-invalid')) {
                validateField(field);
            }
        };
        field.addEventListener('input', handler);
        field.addEventListener('change', handler);
    });

    // Step indicator click navigation
    indicators.forEach((indicator, idx) => {
        indicator.addEventListener('click', function () {
            if (idx === currentTab) return;
            if (idx > currentTab) {
                if (!validateCurrentStep()) return;
            }
            showTab(idx);
        });
    });

    // Previous and Next buttons
    if (prevBtn) {
        prevBtn.onclick = function () {
            if (currentTab > 0) showTab(currentTab - 1);
        };
    }

    if (nextBtn) {
        nextBtn.onclick = function () {
            if (!validateCurrentStep()) return false;

            if (currentTab === steps.length - 1) {
                nextBtn.disabled = true;
                nextBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> ${isAr ? 'جاري الحفظ...' : 'Saving...'}`;
                form.submit();
                return false;
            }

            showTab(currentTab + 1);
            window.scrollTo({ top: form.offsetTop - 50, behavior: 'smooth' });
            return false;
        };
    }

    // Password toggle eye helper
    window.togglePasswordVisibility = function () {
        const passwordInput = document.getElementById("password");
        if (!passwordInput) return;
        passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
    };

    // Initial show
    showTab(currentTab);
});
</script>
@endpush
