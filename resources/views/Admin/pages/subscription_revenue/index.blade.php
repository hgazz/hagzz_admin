@extends('Admin.Layouts.master')

@section('title', trans('admin.subscription_revenue.title'))

@push('css')
<style>
    .subscription-report { --sr-blue:#2563eb; --sr-ink:#172033; --sr-muted:#667085; --sr-line:#e5eaf1; }
    .subscription-report .hero { border:0; border-radius:16px; color:#fff; background:linear-gradient(125deg,#172554,#1d4ed8 60%,#0ea5e9); box-shadow:0 18px 45px rgba(30,64,175,.18); }
    .subscription-report .hero .card-body { padding:24px; }
    .subscription-report .hero h3 { color:#fff; margin:0 0 7px; font-weight:750; }
    .subscription-report .hero p { margin:0; opacity:.82; }
    .subscription-report .hero-actions { display:flex; gap:9px; flex-wrap:wrap; justify-content:flex-end; }
    .subscription-report .hero-actions .btn { border-radius:9px; font-weight:650; }
    .subscription-report .metric { height:100%; border:1px solid var(--sr-line); border-radius:13px; box-shadow:none; }
    .subscription-report .metric .card-body { padding:17px; }
    .subscription-report .metric small { color:var(--sr-muted); display:block; min-height:36px; }
    .subscription-report .metric strong { display:block; color:var(--sr-ink); font-size:25px; line-height:1.15; margin-top:7px; }
    .subscription-report .metric.danger strong { color:#b42318; }
    .subscription-report .currency-strip { border:1px solid #bfdbfe; background:#eff6ff; border-radius:12px; padding:15px; }
    .subscription-report .currency-grid { display:grid; grid-template-columns:repeat(5,minmax(115px,1fr)); gap:12px; }
    .subscription-report .currency-grid small { display:block; color:#475467; margin-bottom:3px; }
    .subscription-report .currency-grid strong { color:#102a56; font-size:16px; }
    .subscription-report .report-card { border:1px solid var(--sr-line); border-radius:14px; box-shadow:none; overflow:hidden; }
    .subscription-report .report-card .card-header { background:#fff; border-bottom:1px solid var(--sr-line); padding:17px 19px; }
    .subscription-report .filter-grid { display:grid; grid-template-columns:2fr 1.2fr 1.2fr 1fr auto; gap:10px; align-items:end; }
    .subscription-report label { color:#344054; font-size:12px; font-weight:650; margin-bottom:5px; }
    .subscription-report .form-control { min-height:42px; border-color:#d0d5dd; border-radius:8px; }
    .subscription-report .table { margin:0; }
    .subscription-report .table th { white-space:nowrap; color:#475467; font-size:11px; text-transform:uppercase; letter-spacing:.03em; background:#f8fafc; }
    .subscription-report .table td { vertical-align:middle; color:#344054; }
    .subscription-report .partner-name { color:var(--sr-ink); font-weight:700; }
    .subscription-report .subtext { color:var(--sr-muted); font-size:11px; display:block; margin-top:2px; }
    .subscription-report .status-pill { display:inline-flex; padding:5px 9px; border-radius:999px; font-size:11px; font-weight:700; white-space:nowrap; background:#f2f4f7; color:#475467; }
    .subscription-report .status-pill.free_offer,.subscription-report .status-pill.not_started { background:#eff8ff;color:#175cd3; }
    .subscription-report .status-pill.discounted,.subscription-report .status-pill.paying,.subscription-report .status-pill.paid { background:#ecfdf3;color:#027a48; }
    .subscription-report .status-pill.overdue,.subscription-report .status-pill.cancelled { background:#fef3f2;color:#b42318; }
    .subscription-report .status-pill.due,.subscription-report .status-pill.ready_to_invoice,.subscription-report .status-pill.partial { background:#fffaeb;color:#b54708; }
    .subscription-report .status-pill.suspended,.subscription-report .status-pill.expired,.subscription-report .status-pill.void { background:#f2f4f7;color:#475467; }
    .subscription-report .amount { font-variant-numeric:tabular-nums; white-space:nowrap; font-weight:650; }
    .subscription-report .empty { padding:40px 15px; text-align:center; color:var(--sr-muted); }
    @media(max-width:991px){ .subscription-report .filter-grid{grid-template-columns:1fr 1fr}.subscription-report .hero-actions{justify-content:flex-start;margin-top:16px}.subscription-report .currency-grid{grid-template-columns:repeat(2,1fr)} }
    @media(max-width:575px){ .subscription-report .filter-grid{grid-template-columns:1fr}.subscription-report .currency-grid{grid-template-columns:1fr}.subscription-report .hero .card-body{padding:18px} }
</style>
@endpush

@section('content')
<div class="middle-content container-xxl p-0 subscription-report">
    <div class="secondary-nav"><div class="breadcrumbs-container"><header class="header navbar navbar-expand-sm"><a href="javascript:void(0);" class="btn-toggle sidebarCollapse"><x-feather-icon name="menu" /></a><div class="d-flex breadcrumb-content"><div class="page-header"><nav class="breadcrumb-style-one"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ trans('admin.dashboard') }}</a></li><li class="breadcrumb-item active">{{ trans('admin.subscription_revenue.title') }}</li></ol></nav></div></div></header></div></div>

    @if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger mt-3">{{ $errors->first() }}</div>@endif

    <div class="card hero mt-4"><div class="card-body"><div class="row align-items-center"><div class="col-lg-7"><h3>{{ trans('admin.subscription_revenue.title') }}</h3><p>{{ trans('admin.subscription_revenue.subtitle') }}</p></div><div class="col-lg-5 hero-actions">
        <a class="btn btn-light" href="{{ route('admin.report.subscriptions.export', request()->query()) }}"><x-feather-icon name="download" /> {{ trans('admin.subscription_revenue.export') }}</a>
        <form method="POST" action="{{ route('admin.report.subscriptions.generate') }}">@csrf<button class="btn btn-warning" type="submit"><x-feather-icon name="file-plus" /> {{ trans('admin.subscription_revenue.generate_due') }}</button></form>
    </div></div></div></div>

    <div class="row g-3 mt-1">
        @foreach(['partners','free_offer','discounted','paying','due','overdue'] as $metric)
        <div class="col-6 col-md-4 col-xl-2"><div class="card metric {{ $metric === 'overdue' ? 'danger' : '' }}"><div class="card-body"><small>{{ trans('admin.subscription_revenue.metrics.'.$metric) }}</small><strong>{{ number_format($counts[$metric]) }}</strong></div></div></div>
        @endforeach
    </div>

    @if($counts['without_subscription'] > 0)<div class="alert alert-warning mt-3 mb-0">{{ trans_choice('admin.subscription_revenue.without_subscription_alert', $counts['without_subscription'], ['count'=>$counts['without_subscription']]) }}</div>@endif

    @foreach($totals as $total)
    <div class="currency-strip mt-3"><div class="d-flex justify-content-between mb-3"><strong>{{ $total['currency'] }}</strong><span class="text-muted">{{ trans('admin.subscription_revenue.financial_summary') }}</span></div><div class="currency-grid">
        @foreach(['mrr','arr','invoiced','collected','outstanding'] as $key)<div><small>{{ trans('admin.subscription_revenue.metrics.'.$key) }}</small><strong>{{ number_format($total[$key],2) }} {{ $total['currency'] }}</strong></div>@endforeach
    </div></div>
    @endforeach

    <div class="card report-card mt-3"><div class="card-header"><form method="GET" action="{{ route('admin.report.subscriptions.index') }}"><div class="filter-grid">
        <div><label>{{ trans('admin.subscription_revenue.partner') }}</label><select name="academy_id" class="form-control"><option value="">{{ trans('admin.subscription_revenue.all_partners') }}</option>@foreach($academies as $academy)<option value="{{ $academy->id }}" @selected(request('academy_id')==$academy->id)>{{ $academy->commercial_name }}</option>@endforeach</select></div>
        <div><label>{{ trans('admin.subscription_revenue.offer_status') }}</label><select name="offer_status" class="form-control"><option value="">{{ trans('admin.subscription_revenue.all') }}</option>@foreach(['scheduled','free_offer','discounted','standard'] as $status)<option value="{{ $status }}" @selected(request('offer_status')===$status)>{{ trans('admin.subscription_revenue.offers.'.$status) }}</option>@endforeach</select></div>
        <div><label>{{ trans('admin.subscription_revenue.billing_status') }}</label><select name="billing_status" class="form-control"><option value="">{{ trans('admin.subscription_revenue.all') }}</option>@foreach(['not_started','ready_to_invoice','due','overdue','paying','suspended','cancelled','expired'] as $status)<option value="{{ $status }}" @selected(request('billing_status')===$status)>{{ trans('admin.subscription_revenue.statuses.'.$status) }}</option>@endforeach</select></div>
        <div><label>{{ trans('admin.subscription_revenue.contract_status') }}</label><select name="subscription_status" class="form-control"><option value="">{{ trans('admin.subscription_revenue.all') }}</option>@foreach(['active','suspended','cancelled'] as $status)<option value="{{ $status }}" @selected(request('subscription_status')===$status)>{{ trans('admin.subscription_revenue.statuses.'.$status) }}</option>@endforeach</select></div>
        <button class="btn btn-primary" type="submit">{{ trans('admin.subscription_revenue.filter') }}</button>
    </div></form></div><div class="table-responsive"><table class="table table-hover"><thead><tr>
        <th>{{ trans('admin.subscription_revenue.partner') }}</th><th>{{ trans('admin.subscription_revenue.plan') }}</th><th>{{ trans('admin.subscription_revenue.offer') }}</th><th>{{ trans('admin.subscription_revenue.billing') }}</th><th>{{ trans('admin.subscription_revenue.price') }}</th><th>{{ trans('admin.subscription_revenue.billing_start') }}</th><th>{{ trans('admin.subscription_revenue.next_invoice') }}</th><th>{{ trans('admin.subscription_revenue.collected') }}</th><th>{{ trans('admin.subscription_revenue.outstanding') }}</th><th></th>
    </tr></thead><tbody>
        @forelse($rows as $row)
        <tr><td><span class="partner-name">{{ $row['academy']->commercial_name }}</span><span class="subtext">{{ $row['academy']->country?->name }}</span></td>
            <td>{{ $row['subscription']->plan?->name ?? '—' }}<span class="subtext">{{ trans('admin.saas.'.$row['subscription']->billing_cycle) }}</span></td>
            <td><span class="status-pill {{ $row['offer_status'] }}">{{ trans('admin.subscription_revenue.offers.'.$row['offer_status']) }}</span>@if($row['subscription']->offer_name)<span class="subtext">{{ $row['subscription']->offer_name }}</span>@endif</td>
            <td><span class="status-pill {{ $row['billing_status'] }}">{{ trans('admin.subscription_revenue.statuses.'.$row['billing_status']) }}</span></td>
            <td><span class="amount">{{ number_format($row['effective_price'],2) }} {{ $row['currency'] }}</span>@if($row['effective_price'] != $row['list_price'])<span class="subtext"><s>{{ number_format($row['list_price'],2) }}</s></span>@endif</td>
            <td>{{ $row['billing_start']->format('Y-m-d') }}</td><td>{{ $row['subscription']->next_billing_at?->format('Y-m-d') ?? '—' }}</td>
            <td class="amount text-success">{{ number_format($row['collected'],2) }}</td><td class="amount {{ $row['outstanding'] > 0 ? 'text-danger' : '' }}">{{ number_format($row['outstanding'],2) }}</td>
            <td><form method="POST" action="{{ route('admin.report.subscriptions.generate') }}">@csrf<input type="hidden" name="subscription_id" value="{{ $row['subscription']->id }}"><button class="btn btn-sm btn-outline-primary" title="{{ trans('admin.subscription_revenue.generate_partner') }}"><x-feather-icon name="file-plus" /></button></form></td>
        </tr>
        @empty<tr><td colspan="10" class="empty">{{ trans('admin.subscription_revenue.empty') }}</td></tr>@endforelse
    </tbody></table></div></div>

    <div class="card report-card mt-3 mb-4"><div class="card-header"><strong>{{ trans('admin.subscription_revenue.invoices') }}</strong><span class="subtext">{{ trans('admin.subscription_revenue.invoices_hint') }}</span></div><div class="table-responsive"><table class="table table-hover"><thead><tr>
        <th>{{ trans('admin.subscription_revenue.invoice_number') }}</th><th>{{ trans('admin.subscription_revenue.partner') }}</th><th>{{ trans('admin.subscription_revenue.period') }}</th><th>{{ trans('admin.subscription_revenue.due_at') }}</th><th>{{ trans('admin.subscription_revenue.total') }}</th><th>{{ trans('admin.subscription_revenue.paid') }}</th><th>{{ trans('admin.subscription_revenue.balance') }}</th><th>{{ trans('admin.status') }}</th><th></th>
    </tr></thead><tbody>@forelse($invoices as $invoice)
        @php($displayStatus = in_array($invoice->status,['issued','partial']) && $invoice->due_at->isPast() && $invoice->balance > 0 ? 'overdue' : $invoice->status)
        <tr><td class="amount">{{ $invoice->invoice_number }}</td><td><span class="partner-name">{{ $invoice->academy?->commercial_name }}</span></td><td>{{ $invoice->period_starts_at->format('Y-m-d') }}<span class="subtext">{{ $invoice->period_ends_at->format('Y-m-d') }}</span></td><td>{{ $invoice->due_at->format('Y-m-d') }}</td><td class="amount">{{ number_format($invoice->total_amount,2) }} {{ $invoice->currency_code }}</td><td class="amount text-success">{{ number_format($invoice->paid_amount,2) }}</td><td class="amount {{ $invoice->balance > 0 ? 'text-danger' : '' }}">{{ number_format($invoice->balance,2) }}</td><td><span class="status-pill {{ $displayStatus }}">{{ trans('admin.subscription_revenue.statuses.'.$displayStatus) }}</span></td><td><div class="d-flex gap-1">
            <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ route('admin.invoices.subscriptions.print',['invoice'=>$invoice,'paper'=>'a4']) }}" title="{{ app()->getLocale()==='ar'?'طباعة الفاتورة':'Print invoice' }}"><i class="fa-solid fa-print"></i></a>
            @if($invoice->balance > 0 && $invoice->status !== 'void')<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payment-{{ $invoice->id }}">{{ trans('admin.subscription_revenue.record_payment') }}</button>@endif
            @if((float)$invoice->paid_amount===0.0 && $invoice->status !== 'void')<form method="POST" action="{{ route('admin.report.subscriptions.invoices.void',$invoice) }}" data-message="{{ trans('admin.subscription_revenue.void_confirm') }}" onsubmit="return confirm(this.dataset.message)">@csrf @method('PUT')<button class="btn btn-sm btn-outline-danger">{{ trans('admin.subscription_revenue.void') }}</button></form>@endif
        </div></td></tr>
        @empty<tr><td colspan="9" class="empty">{{ trans('admin.subscription_revenue.no_invoices') }}</td></tr>@endforelse</tbody></table></div></div>

    @foreach($invoices->where('status','!=','void')->filter(fn($invoice) => $invoice->balance > 0) as $invoice)
    <div class="modal fade" id="payment-{{ $invoice->id }}" tabindex="-1"><div class="modal-dialog"><form method="POST" action="{{ route('admin.report.subscriptions.payments.store',$invoice) }}" class="modal-content">@csrf<div class="modal-header"><h5 class="modal-title">{{ trans('admin.subscription_revenue.record_payment') }} — {{ $invoice->invoice_number }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">
        <div class="alert alert-info">{{ trans('admin.subscription_revenue.remaining') }}: <strong>{{ number_format($invoice->balance,2) }} {{ $invoice->currency_code }}</strong></div>
        <div class="mb-3"><label>{{ trans('admin.subscription_revenue.amount') }}</label><input class="form-control" type="number" name="amount" min="0.01" max="{{ $invoice->balance }}" step="0.01" value="{{ $invoice->balance }}" required></div>
        <div class="mb-3"><label>{{ trans('admin.subscription_revenue.payment_date') }}</label><input class="form-control" type="datetime-local" name="paid_at" value="{{ now()->format('Y-m-d\TH:i') }}" required></div>
        <div class="mb-3"><label>{{ trans('admin.subscription_revenue.payment_method') }}</label><select class="form-control" name="payment_method">@foreach(['bank_transfer','cash','card','online','other'] as $method)<option value="{{ $method }}">{{ trans('admin.subscription_revenue.methods.'.$method) }}</option>@endforeach</select></div>
        <div class="mb-3"><label>{{ trans('admin.subscription_revenue.reference') }}</label><input class="form-control" name="reference"></div>
        <div><label>{{ trans('admin.subscription_revenue.notes') }}</label><textarea class="form-control" name="notes" rows="2"></textarea></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('admin.saas.cancel') }}</button><button class="btn btn-success">{{ trans('admin.subscription_revenue.save_payment') }}</button></div></form></div></div>
    @endforeach
</div>
@endsection
