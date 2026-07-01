@extends('Admin.Layouts.master')

@section('title', trans('admin.saas.plans'))

@push('css')
<style>
    .saas-plans-page {
        --plans-primary: #2563eb;
        --plans-ink: #172033;
        --plans-muted: #667085;
        --plans-border: #e6eaf0;
        --plans-surface: #f7f9fc;
    }
    .plans-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }
    .plans-header h3 { color: var(--plans-ink); font-weight: 700; margin: 0 0 6px; }
    .plans-header p { color: var(--plans-muted); margin: 0; }
    .plans-header .btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        border-radius: 8px;
        padding-inline: 18px;
        font-weight: 600;
        white-space: nowrap;
    }
    .plans-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }
    .summary-item {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 78px;
        padding: 15px 17px;
        background: #fff;
        border: 1px solid var(--plans-border);
        border-radius: 8px;
        box-shadow: 0 5px 18px rgba(23, 32, 51, .04);
    }
    .summary-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--plans-primary);
        background: #eff6ff;
        font-size: 17px;
    }
    .summary-item strong { display: block; color: var(--plans-ink); font-size: 21px; line-height: 1.1; }
    .summary-item small { color: var(--plans-muted); font-size: 12px; }
    .plans-table-shell {
        background: #fff;
        border: 1px solid var(--plans-border);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(23, 32, 51, .05);
        overflow: hidden;
    }
    .plans-table-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        min-height: 62px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--plans-border);
    }
    .plans-table-toolbar strong { color: var(--plans-ink); }
    .plans-table-toolbar span { color: var(--plans-muted); font-size: 13px; }
    .plans-table { margin: 0; min-width: 1040px; }
    .plans-table thead th {
        padding: 13px 18px;
        border: 0;
        border-bottom: 1px solid var(--plans-border);
        background: var(--plans-surface);
        color: #475467;
        font-size: 12px;
        font-weight: 700;
        text-transform: none;
        vertical-align: middle;
    }
    .plans-table tbody td {
        padding: 18px;
        border-color: #edf0f4;
        color: #344054;
        vertical-align: middle;
    }
    .plans-table tbody tr { transition: background .18s ease; }
    .plans-table tbody tr:hover { background: #fafcff; }
    .plan-identity { display: flex; align-items: center; gap: 12px; min-width: 210px; }
    .plan-avatar {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--plans-primary);
        background: #eff6ff;
        font-size: 17px;
    }
    .plan-identity strong { display: block; color: var(--plans-ink); font-size: 14px; margin-bottom: 3px; }
    .plan-code {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--plans-muted);
        font-family: monospace;
        font-size: 12px;
    }
    .market-price-list { display: flex; flex-wrap: wrap; gap: 7px; max-width: 390px; }
    .market-price {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 9px;
        border: 1px solid var(--plans-border);
        border-radius: 7px;
        background: #fff;
        white-space: nowrap;
    }
    .market-price i { color: var(--plans-primary); font-size: 12px; }
    .market-price b { color: var(--plans-ink); font-size: 12px; }
    .market-price small { color: var(--plans-muted); font-size: 11px; }
    .plan-limits { display: flex; align-items: center; gap: 7px; }
    .limit-item {
        min-width: 58px;
        padding: 7px 6px;
        border-radius: 7px;
        background: var(--plans-surface);
        text-align: center;
    }
    .limit-item i { display: block; color: #667085; font-size: 12px; margin-bottom: 4px; }
    .limit-item b { color: var(--plans-ink); font-size: 13px; }
    .plan-features { display: flex; gap: 5px; flex-wrap: wrap; max-width: 190px; }
    .feature-dot {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        color: #475467;
        background: var(--plans-surface);
        font-size: 12px;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }
    .status-pill::before { content: ''; width: 7px; height: 7px; border-radius: 50%; }
    .status-pill.is-active { color: #067647; background: #ecfdf3; }
    .status-pill.is-active::before { background: #12b76a; }
    .status-pill.is-inactive { color: #475467; background: #f2f4f7; }
    .status-pill.is-inactive::before { background: #98a2b3; }
    .saas-actions .action-trigger {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--plans-border);
        border-radius: 8px;
        background: #fff;
        color: #475467;
        box-shadow: none;
    }
    .saas-actions .action-trigger:hover,
    .saas-actions .action-trigger[aria-expanded="true"] { color: var(--plans-primary); border-color: #b9cffd; background: #f4f8ff; }
    .saas-actions .dropdown-menu {
        min-width: 180px;
        padding: 7px;
        border: 1px solid var(--plans-border);
        border-radius: 8px;
        box-shadow: 0 14px 36px rgba(23, 32, 51, .14);
    }
    .saas-actions .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 11px;
        border-radius: 6px;
        font-size: 13px;
    }
    .saas-actions .dropdown-item i { width: 18px; text-align: center; }
    .saas-actions .dropdown-item.text-danger:hover { color: #d92d20 !important; background: #fff4f3; }
    .plans-empty { padding: 64px 20px !important; text-align: center; }
    .plans-empty-icon {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        border-radius: 8px;
        color: var(--plans-primary);
        background: #eff6ff;
        font-size: 22px;
    }
    .plans-pagination { margin-top: 18px; }
    @media (max-width: 991.98px) {
        .plans-summary { grid-template-columns: 1fr; }
        .summary-item { min-height: 68px; }
        .plans-table-shell { border: 0; box-shadow: none; background: transparent; overflow: visible; }
        .plans-table-toolbar { margin-bottom: 12px; border: 1px solid var(--plans-border); border-radius: 8px; background: #fff; }
        .plans-table-responsive { overflow: visible; }
        .plans-table { min-width: 0; }
        .plans-table thead { display: none; }
        .plans-table tbody, .plans-table tr, .plans-table td { display: block; width: 100%; }
        .plans-table tbody { display: grid; gap: 14px; }
        .plans-table tbody tr { position: relative; padding: 17px; border: 1px solid var(--plans-border); border-radius: 8px; background: #fff; box-shadow: 0 5px 18px rgba(23, 32, 51, .04); }
        .plans-table tbody td { padding: 12px 0; border: 0; border-bottom: 1px solid #edf0f4; }
        .plans-table tbody td:last-child { border: 0; }
        .plans-table tbody td::before { content: attr(data-label); display: block; margin-bottom: 8px; color: var(--plans-muted); font-size: 11px; font-weight: 700; }
        .plans-table tbody td:first-child { padding-top: 0; padding-inline-end: 48px; }
        .plans-table tbody td:first-child::before,
        .plans-table tbody td:last-child::before { display: none; }
        .plans-table tbody td:last-child { position: absolute; top: 16px; inset-inline-end: 16px; width: auto; padding: 0; }
        .market-price-list, .plan-features { max-width: none; }
    }
    @media (max-width: 575.98px) {
        .plans-header { align-items: stretch; flex-direction: column; }
        .plans-header .btn { justify-content: center; }
        .plans-header p { font-size: 13px; }
        .plans-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px; }
        .summary-item { min-height: 90px; padding: 10px 6px; flex-direction: column; justify-content: center; gap: 7px; text-align: center; }
        .summary-icon { width: 34px; height: 34px; flex-basis: 34px; font-size: 14px; }
        .summary-item strong { font-size: 17px; }
        .summary-item small { font-size: 10px; line-height: 1.25; }
        .plans-table-toolbar { padding: 12px 14px; }
        .market-price { width: 100%; justify-content: space-between; }
    }
</style>
@endpush

@section('content')
@php
    $pagePlans = $plans->getCollection();
    $activePlans = $pagePlans->where('active', true)->count();
    $activeMarkets = $pagePlans->sum(fn ($plan) => $plan->prices->where('active', true)->count());
    $featureIcons = [
        'academy' => 'fa-solid fa-graduation-cap',
        'venues' => 'fa-solid fa-map-location-dot',
        'reports' => 'fa-solid fa-chart-column',
        'mobile_marketplace' => 'fa-solid fa-mobile-screen-button',
    ];
@endphp
<div class="middle-content container-xxl p-0 saas-plans-page">
    <div class="plans-header">
        <div>
            <h3>{{ trans('admin.saas.plans') }}</h3>
            <p>{{ trans('admin.saas.plans_hint') }}</p>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.saas-plans.create') }}"><i class="fa-solid fa-plus"></i><span>{{ trans('admin.saas.add_plan') }}</span></a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif

    <div class="plans-summary">
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-layer-group"></i></span><div><strong>{{ $plans->total() }}</strong><small>{{ trans('admin.saas.plans') }}</small></div></div>
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-circle-check"></i></span><div><strong>{{ $activePlans }}</strong><small>{{ trans('admin.saas.active') }}</small></div></div>
        <div class="summary-item"><span class="summary-icon"><i class="fa-solid fa-earth-americas"></i></span><div><strong>{{ $activeMarkets }}</strong><small>{{ trans('admin.saas.market_prices') }}</small></div></div>
    </div>

    <div class="plans-table-shell">
        <div class="plans-table-toolbar">
            <strong>{{ trans('admin.saas.plans') }}</strong>
            <span>{{ $plans->firstItem() ?? 0 }} - {{ $plans->lastItem() ?? 0 }} / {{ $plans->total() }}</span>
        </div>
        <div class="table-responsive plans-table-responsive">
            <table class="table plans-table align-middle">
                <thead>
                    <tr>
                        <th>{{ trans('admin.saas.plan') }}</th>
                        <th>{{ trans('admin.saas.market_prices') }}</th>
                        <th>{{ trans('admin.saas.limits') }}</th>
                        <th>{{ trans('admin.saas.features') }}</th>
                        <th>{{ trans('admin.status') }}</th>
                        <th class="text-center">{{ trans('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td>
                                <a class="plan-identity" href="{{ route('admin.saas-plans.edit', $plan) }}">
                                    <span class="plan-avatar"><i class="fa-solid fa-cube"></i></span>
                                    <span><strong>{{ $plan->name }}</strong><span class="plan-code"><i class="fa-solid fa-code"></i>{{ $plan->code }}</span></span>
                                </a>
                            </td>
                            <td data-label="{{ trans('admin.saas.market_prices') }}">
                                <div class="market-price-list">
                                    @forelse($plan->prices->where('active', true) as $price)
                                        <span class="market-price"><i class="fa-solid fa-location-dot"></i><b>{{ $price->country?->name }}</b><small>{{ number_format($price->monthly_price, 2) }} {{ $price->currency_code }} / {{ trans('admin.saas.monthly') }}</small></span>
                                    @empty
                                        <span class="text-muted small"><i class="fa-solid fa-circle-minus me-1"></i>{{ trans('admin.saas.no_market_prices') }}</span>
                                    @endforelse
                                </div>
                            </td>
                            <td data-label="{{ trans('admin.saas.limits') }}">
                                <div class="plan-limits">
                                    <span class="limit-item" title="{{ trans('admin.saas.max_venues') }}"><i class="fa-solid fa-building"></i><b>{{ $plan->max_venues }}</b></span>
                                    <span class="limit-item" title="{{ trans('admin.saas.max_spaces') }}"><i class="fa-solid fa-futbol"></i><b>{{ $plan->max_spaces }}</b></span>
                                    <span class="limit-item" title="{{ trans('admin.saas.max_staff') }}"><i class="fa-solid fa-user-group"></i><b>{{ $plan->max_staff }}</b></span>
                                </div>
                            </td>
                            <td data-label="{{ trans('admin.saas.features') }}">
                                <div class="plan-features">
                                    @foreach($plan->features ?? [] as $feature)
                                        @if(isset($featureIcons[$feature]))
                                            <span class="feature-dot" title="{{ trans('admin.saas.feature_names.'.$feature) }}"><i class="{{ $featureIcons[$feature] }}"></i></span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td data-label="{{ trans('admin.status') }}"><span class="status-pill {{ $plan->active ? 'is-active' : 'is-inactive' }}">{{ $plan->active ? trans('admin.saas.active') : trans('admin.saas.inactive') }}</span></td>
                            <td class="text-center">
                                <div class="dropdown saas-actions">
                                    <button class="action-trigger" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ trans('admin.actions') }}"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.saas-plans.edit', $plan) }}"><i class="fa-solid fa-pen-to-square text-primary"></i><span>{{ trans('admin.edit') }}</span></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.saas-plans.destroy', $plan) }}" onsubmit="return confirm('{{ trans('admin.delete') }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash-can"></i><span>{{ trans('admin.delete') }}</span></button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="plans-empty"><span class="plans-empty-icon"><i class="fa-solid fa-layer-group"></i></span><strong class="d-block mb-1">{{ trans('admin.saas.empty') }}</strong><a href="{{ route('admin.saas-plans.create') }}" class="btn btn-sm btn-primary mt-3">{{ trans('admin.saas.add_plan') }}</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="plans-pagination">{{ $plans->links() }}</div>
</div>
@endsection
