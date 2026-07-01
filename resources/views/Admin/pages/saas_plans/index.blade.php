@extends('Admin.Layouts.master')

@section('title', trans('admin.saas.plans'))

@push('css')
<style>
    .saas-plans-page {
        --plans-primary: #2563eb;
        --plans-ink: #172033;
        --plans-muted: #667085;
        --plans-border: #e4e9f0;
        --plans-surface: #f7f9fc;
    }
    .plans-header { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 24px; }
    .plans-header h3 { color: var(--plans-ink); font-weight: 700; margin: 0 0 6px; }
    .plans-header p { color: var(--plans-muted); margin: 0; }
    .plans-header .btn { min-height: 44px; display: inline-flex; align-items: center; justify-content: center; gap: 9px; border-radius: 8px; padding-inline: 18px; font-weight: 600; white-space: nowrap; }
    .plans-summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 20px; }
    .summary-item { display: flex; align-items: center; gap: 13px; min-height: 78px; padding: 15px 17px; background: #fff; border: 1px solid var(--plans-border); border-radius: 8px; box-shadow: 0 5px 18px rgba(23, 32, 51, .04); }
    .summary-icon { width: 42px; height: 42px; flex: 0 0 42px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: var(--plans-primary); background: #eff6ff; font-size: 17px; }
    .summary-item strong { display: block; color: var(--plans-ink); font-size: 21px; line-height: 1.1; }
    .summary-item small { color: var(--plans-muted); font-size: 12px; }
    .plans-list { display: grid; gap: 18px; }
    .plan-card { background: #fff; border: 1px solid var(--plans-border); border-radius: 8px; box-shadow: 0 8px 24px rgba(23, 32, 51, .05); overflow: hidden; transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .plan-card:hover { transform: translateY(-2px); border-color: #cbd8ef; box-shadow: 0 14px 34px rgba(23, 32, 51, .09); }
    .plan-card-head { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 18px 20px; border-bottom: 1px solid var(--plans-border); }
    .plan-identity { display: flex; align-items: center; gap: 13px; min-width: 0; }
    .plan-avatar { width: 46px; height: 46px; flex: 0 0 46px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: #fff; background: #2563eb; font-size: 18px; box-shadow: 0 7px 16px rgba(37, 99, 235, .22); }
    .plan-identity h5 { color: var(--plans-ink); font-weight: 700; margin: 0 0 5px; }
    .plan-code { display: inline-flex; align-items: center; gap: 6px; color: var(--plans-muted); font-family: monospace; font-size: 12px; }
    .plan-head-tools { display: flex; align-items: center; gap: 9px; }
    .status-pill { display: inline-flex; align-items: center; gap: 7px; padding: 7px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .status-pill::before { content: ''; width: 7px; height: 7px; border-radius: 50%; }
    .status-pill.is-active { color: #067647; background: #ecfdf3; }
    .status-pill.is-active::before { background: #12b76a; }
    .status-pill.is-inactive { color: #475467; background: #f2f4f7; }
    .status-pill.is-inactive::before { background: #98a2b3; }
    .plan-actions { display: flex; align-items: center; gap: 7px; }
    .plan-action { min-height: 38px; display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 8px 12px; border: 1px solid var(--plans-border); border-radius: 7px; background: #fff; color: #344054; font-size: 12px; font-weight: 600; transition: all .18s ease; }
    .plan-action:hover { color: var(--plans-primary); border-color: #9bb8f5; background: #f4f8ff; }
    .plan-action.delete { width: 38px; padding: 0; color: #d92d20; }
    .plan-action.delete:hover { border-color: #f5b7b1; background: #fff4f3; }
    .plan-card-body { display: grid; grid-template-columns: minmax(0, 1fr) 285px; }
    .plan-markets { padding: 20px; min-width: 0; }
    .section-label { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 13px; }
    .section-label strong { color: #344054; font-size: 13px; }
    .section-label small { color: var(--plans-muted); font-size: 11px; }
    .market-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    .market-card { display: grid; grid-template-columns: auto minmax(0, 1fr) auto; align-items: center; gap: 11px; min-height: 72px; padding: 12px 13px; border: 1px solid var(--plans-border); border-radius: 8px; background: #fff; }
    .country-flag { width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; flex: 0 0 42px; border: 1px solid #e8ebf0; border-radius: 8px; background: var(--plans-surface); font-size: 25px; line-height: 1; }
    .country-info { min-width: 0; }
    .country-info strong { display: block; overflow: hidden; color: var(--plans-ink); font-size: 13px; text-overflow: ellipsis; white-space: nowrap; }
    .country-info small { color: var(--plans-muted); font-size: 11px; text-transform: uppercase; }
    .country-prices { text-align: end; white-space: nowrap; }
    .country-prices b { display: block; color: var(--plans-ink); font-size: 14px; }
    .country-prices small { display: block; color: var(--plans-muted); font-size: 10px; margin-top: 3px; }
    .country-prices small span { color: #079455; font-weight: 700; }
    .no-markets { display: flex; align-items: center; gap: 10px; min-height: 72px; padding: 14px; border: 1px dashed #cfd6df; border-radius: 8px; color: var(--plans-muted); background: var(--plans-surface); font-size: 13px; }
    .plan-meta { padding: 20px; border-inline-start: 1px solid var(--plans-border); background: #fbfcfe; }
    .limits-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px; }
    .limit-item { padding: 10px 5px; border: 1px solid var(--plans-border); border-radius: 7px; background: #fff; text-align: center; }
    .limit-item i { display: block; color: var(--plans-primary); font-size: 13px; margin-bottom: 6px; }
    .limit-item b { display: block; color: var(--plans-ink); font-size: 14px; }
    .limit-item small { display: block; overflow: hidden; color: var(--plans-muted); font-size: 9px; margin-top: 2px; text-overflow: ellipsis; white-space: nowrap; }
    .features-list { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 10px; }
    .feature-item { display: inline-flex; align-items: center; gap: 7px; padding: 7px 9px; border: 1px solid var(--plans-border); border-radius: 7px; background: #fff; color: #475467; font-size: 10px; line-height: 1.25; }
    .feature-item i { color: var(--plans-primary); }
    .plans-empty { padding: 64px 20px; border: 1px dashed #cfd6df; border-radius: 8px; background: #fff; text-align: center; }
    .plans-empty-icon { width: 58px; height: 58px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; border-radius: 8px; color: var(--plans-primary); background: #eff6ff; font-size: 22px; }
    .plans-pagination { margin-top: 18px; }
    @media (max-width: 1199.98px) { .plan-card-body { grid-template-columns: 1fr; } .plan-meta { border-inline-start: 0; border-top: 1px solid var(--plans-border); } .plan-meta-inner { display: grid; grid-template-columns: 320px 1fr; gap: 22px; align-items: start; } }
    @media (max-width: 767.98px) {
        .plans-summary { grid-template-columns: 1fr; }
        .summary-item { min-height: 68px; }
        .plan-card-head { align-items: flex-start; flex-direction: column; }
        .plan-head-tools { width: 100%; justify-content: space-between; }
        .market-grid { grid-template-columns: 1fr; }
        .plan-meta-inner { grid-template-columns: 1fr; }
    }
    @media (max-width: 575.98px) {
        .plans-header { align-items: stretch; flex-direction: column; }
        .plans-header p { font-size: 13px; }
        .plans-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px; }
        .summary-item { min-height: 90px; padding: 10px 5px; flex-direction: column; justify-content: center; gap: 7px; text-align: center; }
        .summary-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 14px; }
        .summary-item strong { font-size: 17px; }
        .summary-item small { font-size: 10px; line-height: 1.2; }
        .plan-card-head, .plan-markets, .plan-meta { padding: 15px; }
        .plan-head-tools { align-items: stretch; flex-direction: column; }
        .plan-actions { display: grid; grid-template-columns: 1fr 42px; }
        .plan-action { min-height: 42px; }
        .plan-action.delete { width: 42px; }
        .market-card { grid-template-columns: auto minmax(0, 1fr); }
        .country-prices { grid-column: 1 / -1; display: flex; align-items: center; justify-content: space-between; padding-top: 9px; border-top: 1px solid #edf0f4; text-align: start; }
        .country-prices small { margin: 0; }
    }
</style>
@endpush

@section('content')
@php
    $pagePlans = $plans->getCollection();
    $activePlans = $pagePlans->where('active', true)->count();
    $activeMarkets = $pagePlans->sum(fn ($plan) => $plan->prices->where('active', true)->count());
    $flagFromIso = function (?string $iso2): string {
        if (! $iso2 || strlen($iso2) !== 2) return '';
        return mb_chr(127397 + ord(strtoupper($iso2[0]))) . mb_chr(127397 + ord(strtoupper($iso2[1])));
    };
    $featureIcons = ['academy' => 'fa-solid fa-graduation-cap', 'venues' => 'fa-solid fa-map-location-dot', 'reports' => 'fa-solid fa-chart-column', 'mobile_marketplace' => 'fa-solid fa-mobile-screen-button'];
@endphp
<div class="middle-content container-xxl p-0 saas-plans-page">
    <div class="plans-header">
        <div><h3>{{ trans('admin.saas.plans') }}</h3><p>{{ trans('admin.saas.plans_hint') }}</p></div>
        <a class="btn btn-primary" href="{{ route('admin.saas-plans.create') }}"><i class="fa-solid fa-plus"></i><span>{{ trans('admin.saas.add_plan') }}</span></a>
    </div>

    @if(session('success'))<div class="alert alert-success d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></div>@endif

    <div class="plans-summary">
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-layer-group"></i></span><div><strong>{{ $plans->total() }}</strong><small>{{ trans('admin.saas.plans') }}</small></div></div>
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-circle-check"></i></span><div><strong>{{ $activePlans }}</strong><small>{{ trans('admin.saas.active') }}</small></div></div>
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-earth-americas"></i></span><div><strong>{{ $activeMarkets }}</strong><small>{{ trans('admin.saas.market_prices') }}</small></div></div>
    </div>

    <div class="plans-list">
        @forelse($plans as $plan)
            @php $enabledPrices = $plan->prices->where('active', true); @endphp
            <article class="plan-card">
                <header class="plan-card-head">
                    <a class="plan-identity" href="{{ route('admin.saas-plans.edit', $plan) }}">
                        <span class="plan-avatar"><i class="fa-solid fa-cube"></i></span>
                        <span><h5>{{ $plan->name }}</h5><span class="plan-code"><i class="fa-solid fa-code"></i>{{ $plan->code }}</span></span>
                    </a>
                    <div class="plan-head-tools">
                        <span class="status-pill {{ $plan->active ? 'is-active' : 'is-inactive' }}">{{ $plan->active ? trans('admin.saas.active') : trans('admin.saas.inactive') }}</span>
                        <div class="plan-actions">
                            <a class="plan-action" href="{{ route('admin.saas-plans.edit', $plan) }}"><i class="fa-solid fa-pen-to-square"></i><span>{{ trans('admin.edit') }}</span></a>
                            <form method="POST" action="{{ route('admin.saas-plans.destroy', $plan) }}" onsubmit="return confirm('{{ trans('admin.delete') }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="plan-action delete" title="{{ trans('admin.delete') }}"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </div>
                </header>

                <div class="plan-card-body">
                    <section class="plan-markets">
                        <div class="section-label"><strong>{{ trans('admin.saas.market_prices') }}</strong><small>{{ $enabledPrices->count() }} {{ trans('admin.saas.active') }}</small></div>
                        @if($enabledPrices->isNotEmpty())
                            <div class="market-grid">
                                @foreach($enabledPrices as $price)
                                    @php
                                        $annualSaving = max(0, ((float) $price->monthly_price * 12) - (float) $price->annual_price);
                                        $savingPercent = $price->monthly_price > 0 ? round(($annualSaving / ((float) $price->monthly_price * 12)) * 100) : 0;
                                    @endphp
                                    <div class="market-card">
                                        <span class="country-flag" aria-hidden="true">{{ $flagFromIso($price->country?->iso2) ?: '🌐' }}</span>
                                        <span class="country-info"><strong>{{ $price->country?->name }}</strong><small>{{ $price->currency_code }}</small></span>
                                        <span class="country-prices">
                                            <b>{{ number_format($price->monthly_price, 2) }} {{ $price->currency_code }} / {{ trans('admin.saas.monthly') }}</b>
                                            <small>{{ number_format($price->annual_price, 2) }} {{ $price->currency_code }} / {{ trans('admin.saas.annual') }} @if($savingPercent > 0)<span>(-{{ $savingPercent }}%)</span>@endif</small>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-markets"><i class="fa-solid fa-circle-exclamation"></i><span>{{ trans('admin.saas.no_market_prices') }}</span></div>
                        @endif
                    </section>

                    <aside class="plan-meta">
                        <div class="plan-meta-inner">
                            <div>
                                <div class="section-label"><strong>{{ trans('admin.saas.limits') }}</strong></div>
                                <div class="limits-grid">
                                    <span class="limit-item"><i class="fa-solid fa-building"></i><b>{{ $plan->max_venues }}</b><small>{{ trans('admin.saas.max_venues') }}</small></span>
                                    <span class="limit-item"><i class="fa-solid fa-futbol"></i><b>{{ $plan->max_spaces }}</b><small>{{ trans('admin.saas.max_spaces') }}</small></span>
                                    <span class="limit-item"><i class="fa-solid fa-user-group"></i><b>{{ $plan->max_staff }}</b><small>{{ trans('admin.saas.max_staff') }}</small></span>
                                </div>
                            </div>
                            <div>
                                <div class="section-label"><strong>{{ trans('admin.saas.features') }}</strong></div>
                                <div class="features-list">
                                    @forelse($plan->features ?? [] as $feature)
                                        @if(isset($featureIcons[$feature]))<span class="feature-item"><i class="{{ $featureIcons[$feature] }}"></i><span>{{ trans('admin.saas.feature_names.'.$feature) }}</span></span>@endif
                                    @empty
                                        <span class="text-muted small">-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </article>
        @empty
            <div class="plans-empty"><span class="plans-empty-icon"><i class="fa-solid fa-layer-group"></i></span><strong class="d-block mb-1">{{ trans('admin.saas.empty') }}</strong><a href="{{ route('admin.saas-plans.create') }}" class="btn btn-sm btn-primary mt-3">{{ trans('admin.saas.add_plan') }}</a></div>
        @endforelse
    </div>
    <div class="plans-pagination">{{ $plans->links() }}</div>
</div>
@endsection
