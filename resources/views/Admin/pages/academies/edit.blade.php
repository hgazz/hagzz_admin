@extends('Admin.Layouts.master')

@section('title', trans('admin.academies.edit').' '.$academies->commercial_name)

@php
    $errorGroups = [
        ['first_name','last_name','role','business_type','country_id','email','password','phone'],
        ['app_name_en','app_name_ar','sport_id','branch_to','facebook','website','instagram','linkedin'],
        ['name','commercial_name_en','commercial_name_ar','trade_license_number','trade_license_expire_date','tax_number','commission_percentage'],
        ['bank_account_type','bank_name','beneficiary_name','bank_account_number'],
        ['contract_date','start_date','end_date','contract_number','account_manager','settlement_days_count','non_refund_days_count','contract_link','image','status'],
        ['saas_plan_id','billing_cycle','custom_price','subscription_starts_at','subscription_ends_at','trial_ends_at','auto_renew'],
    ];
    $initialTab = 0;
    foreach ($errorGroups as $tabIndex => $fields) {
        if ($errors->hasAny($fields)) { $initialTab = $tabIndex; break; }
    }
    $hasLogo = filled($academies->getRawOriginal('logo'));
    $initials = mb_strtoupper(mb_substr((string) $academies->first_name, 0, 1).mb_substr((string) $academies->last_name, 0, 1));
@endphp

@push('css')
    <link rel="stylesheet" href="{{ asset(app()->getLocale() === 'en' ? 'assetsAdmin/academy-ltr.css' : 'assetsAdmin/academy-rtl.css') }}">
    <style>
        .academy-edit-page {
            --edit-primary: #2563eb;
            --edit-ink: #172033;
            --edit-muted: #667085;
            --edit-border: #e4e9f0;
            --edit-surface: #f7f9fc;
        }
        .academy-edit-page svg { stroke-width: 2; }
        .edit-page-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 20px; }
        .edit-page-head h3 { color: var(--edit-ink); font-weight: 700; margin: 0 0 5px; }
        .edit-page-head p { color: var(--edit-muted); margin: 0; }
        .edit-back { width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 42px; border: 1px solid var(--edit-border); border-radius: 8px; background: #fff; color: var(--edit-ink); }
        .edit-back svg { width: 18px; height: 18px; }
        .partner-summary { display: flex; align-items: center; justify-content: space-between; gap: 22px; margin-bottom: 20px; padding: 18px 20px; border: 1px solid var(--edit-border); border-radius: 8px; background: #fff; box-shadow: 0 8px 24px rgba(23, 32, 51, .05); }
        .partner-main { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .partner-logo { width: 62px; height: 62px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 62px; overflow: hidden; border: 1px solid var(--edit-border); border-radius: 8px; background: #eff6ff; color: var(--edit-primary); font-size: 19px; font-weight: 700; }
        .partner-logo img { position: absolute; inset: 0; width: 100%; height: 100%; display: block; object-fit: cover; background: #eff6ff; }
        .partner-logo { position: relative; }
        .partner-logo-initials { position: relative; z-index: 0; }
        .partner-copy { min-width: 0; }
        .partner-copy h5 { overflow: hidden; color: var(--edit-ink); font-weight: 700; margin: 0 0 5px; text-overflow: ellipsis; white-space: nowrap; }
        .partner-copy p { color: var(--edit-muted); font-size: 13px; margin: 0; }
        .partner-facts { display: flex; align-items: stretch; gap: 8px; }
        .partner-fact { min-width: 118px; padding: 10px 12px; border-inline-start: 1px solid var(--edit-border); }
        .partner-fact small { display: flex; align-items: center; gap: 5px; color: var(--edit-muted); font-size: 10px; margin-bottom: 4px; }
        .partner-fact strong { display: block; max-width: 170px; overflow: hidden; color: var(--edit-ink); font-size: 12px; text-overflow: ellipsis; white-space: nowrap; }
        .partner-status { display: inline-flex; align-items: center; gap: 6px; color: #067647 !important; }
        .partner-status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #12b76a; }
        .partner-status.is-inactive { color: #b42318 !important; }
        .partner-status.is-inactive::before { background: #f04438; }
        #signUpForm.partner-edit-form { max-width: none; display: grid; grid-template-columns: 245px minmax(0, 1fr); gap: 18px; align-items: start; margin: 0; padding: 0; border-radius: 0; background: transparent; box-shadow: none; }
        .partner-edit-form > .alert { grid-column: 1 / -1; margin: 0; }
        .partner-edit-form .form-header { grid-column: 1; grid-row: 1 / span 2; display: flex !important; flex-direction: column; gap: 5px !important; position: sticky; top: 92px; margin: 0 !important; padding: 10px; border: 1px solid var(--edit-border); border-radius: 8px; background: #fff; box-shadow: 0 8px 24px rgba(23, 32, 51, .05); text-align: start !important; }
        .partner-edit-form .form-header .stepIndicator { display: flex; align-items: center; gap: 11px; position: relative; min-height: 49px; padding: 9px 10px !important; border: 1px solid transparent; border-radius: 7px; color: #475467; cursor: pointer; font-size: 12px; font-weight: 600; transition: all .18s ease; }
        .partner-edit-form .form-header .stepIndicator::before { content: attr(data-step-number); position: static !important; width: 28px !important; height: 28px !important; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 28px; transform: none !important; border: 1px solid var(--edit-border) !important; border-radius: 7px !important; background: var(--edit-surface) !important; color: #667085; font-size: 11px; }
        .partner-edit-form .form-header .stepIndicator::after { display: none !important; }
        .partner-edit-form .form-header .stepIndicator:hover { color: var(--edit-primary); background: #f8faff; }
        .partner-edit-form .form-header .stepIndicator.active { border-color: #bfd0f7; color: var(--edit-primary); background: #eff5ff; }
        .partner-edit-form .form-header .stepIndicator.active::before { border-color: var(--edit-primary) !important; background: var(--edit-primary) !important; color: #fff; }
        .partner-edit-form .form-header .stepIndicator > svg { width: 17px; height: 17px; flex: 0 0 17px; color: #667085; }
        .partner-edit-form .form-header .stepIndicator.active > svg { color: var(--edit-primary); }
        .partner-edit-form .form-header .stepIndicator.finish::after { display: none !important; }
        .partner-edit-form .step { grid-column: 2; grid-row: 1; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 17px 18px; min-width: 0; margin: 0; padding: 22px; border: 1px solid var(--edit-border); border-radius: 8px; background: #fff; box-shadow: 0 8px 24px rgba(23, 32, 51, .05); }
        .partner-edit-form .step > p:first-child { grid-column: 1 / -1; margin: 0 0 3px !important; padding-bottom: 15px; border-bottom: 1px solid var(--edit-border); color: var(--edit-ink); font-size: 17px; font-weight: 700; text-align: start !important; }
        .partner-edit-form .step > .mb-3 { min-width: 0; margin: 0 !important; }
        .partner-edit-form .step > p.text-danger,
        .partner-edit-form .step > span.text-danger { grid-column: 1 / -1; margin: -12px 0 0; font-size: 11px; }
        .partner-edit-form label,
        .partner-edit-form .step > .mb-3 > span:first-child { display: block; color: #344054; font-size: 12px; font-weight: 600; margin-bottom: 7px; }
        .partner-edit-form input:not([type="checkbox"]):not([type="radio"]),
        .partner-edit-form select,
        .partner-edit-form textarea { width: 100%; min-height: 45px; padding: 10px 12px; border: 1px solid #dfe4eb; border-radius: 7px; background: #fff; color: var(--edit-ink); font-size: 13px; }
        .partner-edit-form input:focus,
        .partner-edit-form select:focus,
        .partner-edit-form textarea:focus { border-color: var(--edit-primary); outline: 0; box-shadow: 0 0 0 3px rgba(37, 99, 235, .1); }
        .partner-edit-form input.invalid,
        .partner-edit-form select.invalid { border-color: #f04438 !important; box-shadow: 0 0 0 3px rgba(240, 68, 56, .08); }
        .partner-edit-form .select2-container { width: 100% !important; }
        .partner-edit-form .select2-container .select2-selection--multiple { min-height: 45px; border-color: #dfe4eb; border-radius: 7px; }
        .partner-edit-form #sports_wrap > div { width: 100%; }
        .partner-edit-form .password-toggle-eye { top: 33px; color: var(--edit-muted); }
        .partner-edit-form .subscription-step { position: relative; }
        .partner-edit-form .subscription-duration-card { grid-column: 1 / -1; display: flex; align-items: center; gap: 11px; padding: 13px 14px; border: 1px solid #b9cffd; border-radius: 8px; background: #f4f8ff; }
        .partner-edit-form .subscription-duration-icon { width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 38px; border-radius: 7px; background: #fff; color: var(--edit-primary); }
        .partner-edit-form .subscription-duration-card small { display: block; color: var(--edit-muted); font-size: 10px; margin-bottom: 3px; }
        .partner-edit-form .subscription-duration-card strong { display: block; color: var(--edit-ink); font-size: 13px; }
        .partner-edit-form .subscription-step #market_price_preview { grid-column: 1 / -1; margin: 0; border: 1px solid #b9cffd; border-radius: 7px; background: #eff6ff; color: #1849a9; font-size: 13px; }
        .partner-edit-form .subscription-step .form-check { grid-column: 1 / -1; display: flex; align-items: center; gap: 9px; min-height: 48px; padding: 11px 14px; border: 1px solid var(--edit-border); border-radius: 7px; background: var(--edit-surface); }
        .partner-edit-form .subscription-step .form-check-input { float: none; width: 38px; height: 20px; min-height: 20px; margin: 0; padding: 0; }
        .partner-edit-form .subscription-step .form-check-label { margin: 0; }
        .partner-edit-form .form-footer { grid-column: 2; grid-row: 2; position: sticky; bottom: 8px; z-index: 20; display: flex !important; justify-content: flex-end; gap: 9px !important; margin: 0; padding: 12px; border: 1px solid var(--edit-border); border-radius: 8px; background: rgba(255,255,255,.96); box-shadow: 0 12px 30px rgba(23,32,51,.12); backdrop-filter: blur(8px); overflow: visible; }
        .partner-edit-form .form-footer button { flex: 0 0 auto !important; min-width: 125px; min-height: 43px; margin: 0 !important; padding: 9px 17px !important; border-radius: 7px !important; font-size: 13px !important; font-weight: 600; }
        .partner-edit-form .form-footer #prevBtn { border: 1px solid var(--edit-border) !important; background: #fff !important; color: #344054 !important; }
        .partner-edit-form .form-footer #nextBtn { border-color: var(--edit-primary) !important; background: var(--edit-primary) !important; }
        @media (max-width: 991.98px) {
            .partner-summary { align-items: flex-start; flex-direction: column; }
            .partner-facts { width: 100%; overflow-x: auto; }
            .partner-fact { flex: 1 0 125px; border-inline-start: 0; border-top: 1px solid var(--edit-border); }
            #signUpForm.partner-edit-form { grid-template-columns: 1fr; }
            .partner-edit-form .form-header { grid-column: 1; grid-row: 1; flex-direction: row; position: static; overflow-x: auto; padding: 8px; }
            .partner-edit-form .form-header .stepIndicator { flex: 0 0 175px !important; }
            .partner-edit-form .step { grid-column: 1; grid-row: 2; }
            .partner-edit-form .form-footer { grid-column: 1; grid-row: 3; }
        }
        @media (max-width: 575.98px) {
            .edit-page-head h3 { font-size: 20px; }
            .edit-page-head p { font-size: 12px; }
            .partner-summary { padding: 14px; }
            .partner-logo { width: 52px; height: 52px; flex-basis: 52px; }
            .partner-edit-form .step { grid-template-columns: 1fr; padding: 16px; }
            .partner-edit-form .step > p:first-child,
            .partner-edit-form .subscription-duration-card,
            .partner-edit-form .subscription-step #market_price_preview,
            .partner-edit-form .subscription-step .form-check { grid-column: 1; }
            .partner-edit-form .form-footer { display: grid !important; grid-template-columns: 1fr 1fr; bottom: 5px; }
            .partner-edit-form .form-footer button { min-width: 0; width: 100%; }
        }
    </style>
@endpush

@section('content')
<div class="middle-content container-xxl p-0 academy-edit-page">
    <div class="edit-page-head">
        <div><h3>{{ trans('admin.academies.edit') }} {{ $academies->commercial_name }}</h3><p>{{ trans('admin.saas.business_type') }}: {{ trans('admin.saas.business_types.'.($academies->business_type ?? 'academy')) }}</p></div>
        <a class="edit-back" href="{{ route('admin.academies.index') }}" title="{{ trans('admin.user.back') }}"><x-feather-icon :name="app()->getLocale() === 'ar' ? 'arrow-right' : 'arrow-left'" /></a>
    </div>

    <section class="partner-summary">
        <div class="partner-main">
            <span class="partner-logo"><span class="partner-logo-initials">{{ $initials ?: '#' }}</span>@if($hasLogo)<img src="{{ $academies->image }}" alt="{{ $academies->commercial_name }}" onerror="this.style.display='none'">@endif</span>
            <div class="partner-copy"><h5>{{ $academies->commercial_name }}</h5><p>{{ $academies->email }} · {{ $academies->phone }}</p></div>
        </div>
        <div class="partner-facts">
            <div class="partner-fact"><small><x-feather-icon name="globe" size="13" />{{ trans('admin.saas.market_country') }}</small><strong>{{ $academies->country?->name ?? '-' }}</strong></div>
            <div class="partner-fact"><small><x-feather-icon name="package" size="13" />{{ trans('admin.saas.plan') }}</small><strong>{{ $currentSubscription?->plan?->name ?? trans('admin.saas.no_plan') }}</strong></div>
            <div class="partner-fact"><small><x-feather-icon name="activity" size="13" />{{ trans('admin.status') }}</small><strong class="partner-status {{ $academies->status === 'active' ? '' : 'is-inactive' }}">{{ trans('admin.academies.'.$academies->status) }}</strong></div>
        </div>
    </section>

    <form id="signUpForm" class="partner-edit-form" action="{{ route('admin.academies.update', $academies) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        <input type="hidden" name="id_unique" value="{{ $academies->id }}">
        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-start gap-2"><x-feather-icon name="alert-circle" /><div><strong>{{ $errors->count() }}</strong><ul class="mb-0 mt-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
        @endif
        @include('Admin.pages.academies.partials._form')
    </form>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signUpForm');
    const steps = Array.from(form.querySelectorAll('.step'));
    const indicators = Array.from(form.querySelectorAll('.stepIndicator'));
    const previousButton = document.getElementById('prevBtn');
    const nextButton = document.getElementById('nextBtn');
    const nextLabel = @json(trans('admin.academies.Next'));
    const submitLabel = @json(trans('admin.submit'));
    let currentTab = {{ $initialTab }};

    form.querySelectorAll('.formInput').forEach(function (field) {
        field.dataset.stepRequired = '1';
        field.addEventListener('input', function () {
            field.classList.remove('invalid');
            field.classList.add('formInput');
        });
        field.addEventListener('change', function () {
            field.classList.remove('invalid');
            field.classList.add('formInput');
        });
    });

    function showTab(index) {
        currentTab = Math.max(0, Math.min(index, steps.length - 1));
        steps.forEach(function (step, stepIndex) {
            step.style.display = stepIndex === currentTab ? 'grid' : 'none';
        });
        indicators.forEach(function (indicator, indicatorIndex) {
            indicator.classList.toggle('active', indicatorIndex === currentTab);
        });
        previousButton.style.visibility = currentTab === 0 ? 'hidden' : 'visible';
        nextButton.textContent = currentTab === steps.length - 1 ? submitLabel : nextLabel;
        if (window.innerWidth < 992) indicators[currentTab]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    function validateCurrentTab() {
        let valid = true;
        steps[currentTab].querySelectorAll('[data-step-required="1"]').forEach(function (field) {
            if (field.disabled || field.closest('.d-none')) return;
            const empty = field.tagName === 'SELECT' && field.multiple ? field.selectedOptions.length === 0 : String(field.value || '').trim() === '';
            field.classList.toggle('invalid', empty);
            if (empty) valid = false;
        });
        if (valid) indicators[currentTab]?.classList.add('finish');
        return valid;
    }

    indicators.forEach(function (indicator) {
        indicator.addEventListener('click', function () { showTab(Number(indicator.dataset.stepIndex)); });
        indicator.setAttribute('role', 'button');
        indicator.setAttribute('tabindex', '0');
        indicator.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); showTab(Number(indicator.dataset.stepIndex)); }
        });
    });

    previousButton.onclick = function () { showTab(currentTab - 1); };
    nextButton.onclick = function () {
        if (!validateCurrentTab()) return false;
        if (currentTab === steps.length - 1) { form.submit(); return false; }
        showTab(currentTab + 1);
        return false;
    };

    showTab(currentTab);
});
</script>
@endpush
