@extends('Admin.Layouts.master')
@section('title', trans('admin.saas.plans'))
@section('content')
<div class="middle-content container-xxl p-0">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h3>{{ trans('admin.saas.plans') }}</h3><p class="text-muted mb-0">{{ trans('admin.saas.plans_hint') }}</p></div><a class="btn btn-primary" href="{{ route('admin.saas-plans.create') }}"><i class="fa-solid fa-plus me-1"></i>{{ trans('admin.saas.add_plan') }}</a></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="table-responsive bg-white rounded shadow-sm"><table class="table table-hover align-middle mb-0"><thead><tr><th>{{ trans('admin.saas.plan') }}</th><th>{{ trans('admin.saas.market_prices') }}</th><th>{{ trans('admin.saas.limits') }}</th><th>{{ trans('admin.status') }}</th><th>{{ trans('admin.actions') }}</th></tr></thead><tbody>
    @forelse($plans as $plan)<tr><td><strong>{{ $plan->name }}</strong><small class="d-block text-muted">{{ $plan->code }}</small></td><td>@forelse($plan->prices->where('active',true) as $price)<span class="badge bg-light text-dark border me-1 mb-1">{{ $price->country?->name }}: {{ number_format($price->monthly_price,2) }} {{ $price->currency_code }}</span>@empty<span class="text-muted">{{ trans('admin.saas.no_market_prices') }}</span>@endforelse</td><td>{{ $plan->max_venues }} / {{ $plan->max_spaces }} / {{ $plan->max_staff }}</td><td><span class="badge {{ $plan->active?'bg-success':'bg-secondary' }}">{{ $plan->active?trans('admin.saas.active'):trans('admin.saas.inactive') }}</span></td><td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.saas-plans.edit',$plan) }}"><i class="fa-solid fa-pen"></i></a><form method="POST" action="{{ route('admin.saas-plans.destroy',$plan) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button></form></div></td></tr>@empty<tr><td colspan="5" class="text-center py-5">{{ trans('admin.saas.empty') }}</td></tr>@endforelse
    </tbody></table></div><div class="mt-3">{{ $plans->links() }}</div>
</div>
@endsection
