@extends('Admin.Layouts.master')

@section('title', trans('admin.saas.plans'))

@push('css')
<style>
    .plan-form-page {
        --plan-primary: #2563eb;
        --plan-ink: #172033;
        --plan-muted: #667085;
        --plan-border: #e6eaf0;
        --plan-surface: #f7f9fc;
    }
    .plan-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }
    .plan-form-header h3 { color: var(--plan-ink); font-weight: 700; margin: 0 0 6px; }
    .plan-form-header p { color: var(--plan-muted); margin: 0; }
    .plan-back {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--plan-border);
        border-radius: 8px;
        background: #fff;
        color: var(--plan-ink);
    }
    .plan-panel {
        background: #fff;
        border: 1px solid var(--plan-border);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(23, 32, 51, .05);
        overflow: hidden;
    }
    .plan-panel + .plan-panel { margin-top: 20px; }
    .plan-panel-head {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--plan-border);
    }
    .plan-panel-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--plan-primary);
        background: #eff6ff;
        font-size: 18px;
    }
    .plan-panel-head h5 { color: var(--plan-ink); font-weight: 700; margin: 0 0 3px; }
    .plan-panel-head p { color: var(--plan-muted); font-size: 13px; margin: 0; }
    .plan-panel-body { padding: 22px; }
    .plan-form-page .form-label { color: #344054; font-weight: 600; font-size: 13px; margin-bottom: 8px; }
    .plan-form-page .form-control {
        min-height: 46px;
        border-color: #dfe4eb;
        border-radius: 7px;
    }
    .plan-form-page .form-control:focus {
        border-color: var(--plan-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }
    .feature-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
    .feature-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 64px;
        padding: 13px;
        border: 1px solid var(--plan-border);
        border-radius: 8px;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }
    .feature-option:has(input:checked) { border-color: #93b4ff; background: #f4f8ff; }
    .feature-option i { width: 22px; text-align: center; color: var(--plan-primary); font-size: 17px; }
    .feature-option .form-check-input { margin: 0; flex: 0 0 auto; }
    .feature-option span { color: #344054; font-size: 13px; font-weight: 600; line-height: 1.4; }
    .market-card {
        height: 100%;
        border: 1px solid var(--plan-border);
        border-radius: 8px;
        background: #fff;
        overflow: hidden;
        transition: opacity .2s ease, border-color .2s ease, box-shadow .2s ease;
    }
    .market-card.is-enabled { border-color: #b9cffd; box-shadow: 0 8px 20px rgba(37, 99, 235, .07); }
    .market-card:not(.is-enabled) .market-fields { opacity: .48; }
    .market-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border-bottom: 1px solid var(--plan-border);
        background: var(--plan-surface);
    }
    .market-name { display: flex; align-items: center; gap: 10px; min-width: 0; }
    .market-name-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 34px;
        border-radius: 7px;
        background: #fff;
        color: #475467;
        border: 1px solid var(--plan-border);
        overflow: hidden;
    }
    .market-name-icon img { width: 100%; height: 100%; display: block; object-fit: cover; }
    .market-name-icon svg { width: 16px; height: 16px; }
    .market-name strong { color: var(--plan-ink); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .market-fields { padding: 18px; transition: opacity .2s ease; }
    .market-saving {
        display: flex;
        align-items: center;
        gap: 7px;
        min-height: 22px;
        margin-top: 12px;
        color: #079455;
        font-size: 12px;
        font-weight: 600;
    }
    .plan-status-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 18px 20px;
        background: #fff;
        border: 1px solid var(--plan-border);
        border-radius: 8px;
    }
    .plan-status-card strong { display: block; color: var(--plan-ink); margin-bottom: 3px; }
    .plan-status-card small { color: var(--plan-muted); }
    .plan-submit-bar {
        position: sticky;
        bottom: 12px;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 20px;
        padding: 14px 16px;
        background: rgba(255, 255, 255, .96);
        border: 1px solid var(--plan-border);
        border-radius: 8px;
        box-shadow: 0 12px 32px rgba(23, 32, 51, .12);
        backdrop-filter: blur(8px);
    }
    .plan-submit-bar .btn { min-height: 44px; border-radius: 7px; padding-inline: 22px; font-weight: 600; }
    .plan-submit-note { display: flex; align-items: center; gap: 9px; color: var(--plan-muted); font-size: 13px; }
    .plan-submit-note i { color: #079455; }
    .plan-form-page svg { stroke-width: 2; }
    .plan-back svg, .plan-panel-icon svg { width: 19px; height: 19px; }
    .plan-form-page .input-group-text svg { width: 16px; height: 16px; }
    .feature-option svg { width: 18px; height: 18px; flex: 0 0 18px; color: var(--plan-primary); }
    .market-saving svg { width: 14px; height: 14px; }
    .plan-submit-note svg, .plan-submit-actions svg { width: 16px; height: 16px; }
    @media (max-width: 991.98px) { .feature-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 575.98px) {
        .plan-form-header { align-items: flex-start; }
        .plan-form-header p { font-size: 13px; }
        .plan-panel-head, .plan-panel-body { padding: 16px; }
        .feature-grid { grid-template-columns: 1fr; }
        .plan-submit-bar { bottom: 6px; align-items: stretch; flex-direction: column; }
        .plan-submit-note { display: none; }
        .plan-submit-actions { display: grid !important; grid-template-columns: 1fr 1fr; }
        .market-card-head { padding: 14px; }
        .market-fields { padding: 14px; }
    }
</style>
@endpush

@section('content')
@php
    $featureIcons = ['academy' => 'award', 'venues' => 'map-pin', 'reports' => 'bar-chart-2', 'mobile_marketplace' => 'smartphone'];
@endphp
<div class="middle-content container-xxl p-0 plan-form-page">
    <div class="plan-form-header">
        <div>
            <h3>{{ $plan->exists ? trans('admin.saas.edit_plan') : trans('admin.saas.add_plan') }}</h3>
            <p>{{ trans('admin.saas.plans_hint') }}</p>
        </div>
        <a class="plan-back" href="{{ route('admin.saas-plans.index') }}" title="{{ trans('admin.saas.cancel') }}">
            <i data-feather="arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}"></i>
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger d-flex gap-3 align-items-start" role="alert">
            <i data-feather="alert-circle" class="mt-1"></i>
            <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ $plan->exists ? route('admin.saas-plans.update', $plan) : route('admin.saas-plans.store') }}" id="saas-plan-form">
        @csrf
        @if($plan->exists) @method('PUT') @endif

        <section class="plan-panel">
            <div class="plan-panel-head">
                <span class="plan-panel-icon"><i data-feather="layers"></i></span>
                <div><h5>{{ trans('admin.saas.plan') }}</h5><p>{{ trans('admin.saas.plans_hint') }}</p></div>
            </div>
            <div class="plan-panel-body">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label" for="plan-code">{{ trans('admin.saas.code') }}</label>
                        <div class="input-group"><span class="input-group-text"><i data-feather="code"></i></span><input id="plan-code" class="form-control" name="code" required value="{{ old('code', $plan->code) }}"></div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label" for="plan-name-ar">{{ trans('admin.saas.name_ar') }}</label>
                        <input id="plan-name-ar" class="form-control" name="name_ar" required dir="rtl" value="{{ old('name_ar', $plan->getTranslation('name', 'ar', false)) }}">
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label" for="plan-name-en">{{ trans('admin.saas.name_en') }}</label>
                        <input id="plan-name-en" class="form-control" name="name_en" required dir="ltr" value="{{ old('name_en', $plan->getTranslation('name', 'en', false)) }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    @foreach(['max_venues' => 'home', 'max_spaces' => 'map', 'max_staff' => 'users'] as $limit => $icon)
                        <div class="col-md-4">
                            <label class="form-label" for="{{ $limit }}">{{ trans('admin.saas.'.$limit) }}</label>
                            <div class="input-group"><span class="input-group-text"><i data-feather="{{ $icon }}"></i></span><input id="{{ $limit }}" type="number" min="1" class="form-control" name="{{ $limit }}" required value="{{ old($limit, $plan->$limit ?: 1) }}"></div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <label class="form-label d-block">{{ trans('admin.saas.features') }}</label>
                    <div class="feature-grid">
                        @foreach(['academy','venues','reports','mobile_marketplace'] as $feature)
                            <label class="feature-option">
                                <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature }}" @checked(in_array($feature, old('features', $plan->features ?? [])))>
                                <i data-feather="{{ $featureIcons[$feature] }}"></i>
                                <span>{{ trans('admin.saas.feature_names.'.$feature) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="plan-panel">
            <div class="plan-panel-head">
                <span class="plan-panel-icon"><i data-feather="globe"></i></span>
                <div><h5>{{ trans('admin.saas.market_prices') }}</h5><p>{{ trans('admin.saas.market_prices_hint') }}</p></div>
            </div>
            <div class="plan-panel-body">
                <div class="row g-3">
                    @foreach($countries as $index => $country)
                        @php
                            $saved = $plan->exists ? $plan->prices->firstWhere('country_id', $country->id) : null;
                            $enabled = old("prices.$index.enabled", $saved?->active ? 1 : 0);
                        @endphp
                        <div class="col-xl-6">
                            <div class="market-card {{ $enabled ? 'is-enabled' : '' }}">
                                <input type="hidden" name="prices[{{ $index }}][country_id]" value="{{ $country->id }}">
                                <div class="market-card-head">
                                    <div class="market-name">
                                        <span class="market-name-icon">
                                            @if($country->iso2)<img src="https://flagcdn.com/w80/{{ strtolower($country->iso2) }}.png" alt="{{ $country->name }}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='block';">@endif
                                            <i data-feather="globe" style="{{ $country->iso2 ? 'display:none' : '' }}"></i>
                                        </span>
                                        <strong>{{ $country->name }}</strong>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input market-toggle" type="checkbox" name="prices[{{ $index }}][enabled]" value="1" role="switch" @checked($enabled)>
                                        <label class="form-check-label">{{ trans('admin.saas.enable_market') }}</label>
                                    </div>
                                </div>
                                <div class="market-fields">
                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <label class="form-label">{{ trans('admin.saas.currency') }}</label>
                                            <input class="form-control text-uppercase currency-input" maxlength="3" name="prices[{{ $index }}][currency_code]" value="{{ old("prices.$index.currency_code", $saved?->currency_code ?? $country->currency_code) }}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">{{ trans('admin.saas.monthly_price') }}</label>
                                            <input type="number" min="0" step="0.01" class="form-control monthly-price" name="prices[{{ $index }}][monthly_price]" value="{{ old("prices.$index.monthly_price", $saved?->monthly_price) }}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">{{ trans('admin.saas.annual_price') }}</label>
                                            <input type="number" min="0" step="0.01" class="form-control annual-price" name="prices[{{ $index }}][annual_price]" value="{{ old("prices.$index.annual_price", $saved?->annual_price) }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{ trans('admin.saas.tax_rate') }}</label>
                                            <div class="input-group"><input type="number" min="0" max="100" step="0.01" class="form-control" name="prices[{{ $index }}][tax_rate]" value="{{ old("prices.$index.tax_rate", $saved?->tax_rate ?? 0) }}"><span class="input-group-text">%</span></div>
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-end pb-2">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" name="prices[{{ $index }}][tax_included]" value="1" @checked(old("prices.$index.tax_included", $saved?->tax_included))><label class="form-check-label">{{ trans('admin.saas.tax_included') }}</label></div>
                                        </div>
                                    </div>
                                    <div class="market-saving" aria-live="polite"><i data-feather="tag"></i><span></span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="plan-status-card mt-3">
            <div><strong>{{ trans('admin.saas.active') }}</strong><small>{{ trans('admin.saas.plans_hint') }}</small></div>
            <div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" name="active" value="1" role="switch" @checked(old('active', $plan->exists ? $plan->active : true))></div>
        </div>

        <div class="plan-submit-bar">
            <div class="plan-submit-note"><i data-feather="shield"></i><span>{{ trans('admin.saas.market_prices_hint') }}</span></div>
            <div class="plan-submit-actions d-flex gap-2">
                <a class="btn btn-light" href="{{ route('admin.saas-plans.index') }}">{{ trans('admin.saas.cancel') }}</a>
                <button class="btn btn-primary" type="submit"><i data-feather="save" class="me-2"></i>{{ trans('admin.submit') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="{{ asset('assetsAdmin/src/plugins/src/font-icons/feather/feather.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.feather) window.feather.replace();
    document.querySelectorAll('.market-card').forEach(function (card) {
        const toggle = card.querySelector('.market-toggle');
        const monthly = card.querySelector('.monthly-price');
        const annual = card.querySelector('.annual-price');
        const currency = card.querySelector('.currency-input');
        const saving = card.querySelector('.market-saving');
        const savingText = saving.querySelector('span');

        function refreshState() {
            card.classList.toggle('is-enabled', toggle.checked);
            card.querySelectorAll('.market-fields input').forEach(function (input) {
                input.disabled = !toggle.checked;
            });
            toggle.disabled = false;
            updateSaving();
        }

        function updateSaving() {
            const monthlyValue = parseFloat(monthly.value);
            const annualValue = parseFloat(annual.value);
            if (!toggle.checked || !monthlyValue || !annualValue || annualValue >= monthlyValue * 12) {
                saving.style.display = 'none';
                savingText.textContent = '';
                return;
            }
            const amount = (monthlyValue * 12 - annualValue).toFixed(2);
            const percentage = Math.round((amount / (monthlyValue * 12)) * 100);
            saving.style.display = 'flex';
            savingText.textContent = percentage + '% (' + amount + ' ' + currency.value.toUpperCase() + ')';
        }

        toggle.addEventListener('change', refreshState);
        [monthly, annual, currency].forEach(function (input) { input.addEventListener('input', updateSaving); });
        refreshState();
    });
});
</script>
@endpush
