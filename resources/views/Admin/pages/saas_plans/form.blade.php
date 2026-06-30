@extends('Admin.layouts.app')
@section('title', trans('admin.saas.plans'))
@section('content')
<div class="middle-content container-xxl p-0">
    <h3 class="mb-4">{{ $plan->exists ? trans('admin.saas.edit_plan') : trans('admin.saas.add_plan') }}</h3>
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ $plan->exists ? route('admin.saas-plans.update',$plan) : route('admin.saas-plans.store') }}" class="bg-white p-4 rounded shadow-sm">
        @csrf @if($plan->exists)@method('PUT')@endif
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">{{ trans('admin.saas.code') }}</label><input class="form-control" name="code" required value="{{ old('code',$plan->code) }}"></div>
            <div class="col-md-4"><label class="form-label">{{ trans('admin.saas.name_ar') }}</label><input class="form-control" name="name_ar" required value="{{ old('name_ar',$plan->getTranslation('name','ar',false)) }}"></div>
            <div class="col-md-4"><label class="form-label">{{ trans('admin.saas.name_en') }}</label><input class="form-control" name="name_en" required value="{{ old('name_en',$plan->getTranslation('name','en',false)) }}"></div>
            @foreach(['max_venues','max_spaces','max_staff'] as $limit)<div class="col-md-4"><label class="form-label">{{ trans('admin.saas.'.$limit) }}</label><input type="number" min="1" class="form-control" name="{{ $limit }}" required value="{{ old($limit,$plan->$limit ?: 1) }}"></div>@endforeach
            <div class="col-12"><label class="form-label d-block">{{ trans('admin.saas.features') }}</label>@foreach(['academy','venues','reports','mobile_marketplace'] as $feature)<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature }}" @checked(in_array($feature,old('features',$plan->features ?? [])))><label class="form-check-label">{{ trans('admin.saas.feature_names.'.$feature) }}</label></div>@endforeach</div>
        </div>

        <hr class="my-4">
        <div class="d-flex align-items-center gap-2 mb-3"><i class="fa-solid fa-earth-americas text-primary"></i><div><h5 class="mb-0">{{ trans('admin.saas.market_prices') }}</h5><small class="text-muted">{{ trans('admin.saas.market_prices_hint') }}</small></div></div>
        <div class="row g-3">
            @foreach($countries as $index => $country)
                @php
                    $saved = $plan->exists ? $plan->prices->firstWhere('country_id', $country->id) : null;
                    $enabled = old("prices.$index.enabled", $saved?->active ? 1 : 0);
                @endphp
                <div class="col-xl-6">
                    <div class="border rounded p-3 h-100">
                        <input type="hidden" name="prices[{{ $index }}][country_id]" value="{{ $country->id }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong>{{ $country->name }}</strong>
                            <div class="form-check form-switch"><input class="form-check-input market-toggle" type="checkbox" name="prices[{{ $index }}][enabled]" value="1" @checked($enabled)><label class="form-check-label">{{ trans('admin.saas.enable_market') }}</label></div>
                        </div>
                        <div class="row g-2 market-fields">
                            <div class="col-sm-4"><label class="form-label">{{ trans('admin.saas.currency') }}</label><input class="form-control text-uppercase" maxlength="3" name="prices[{{ $index }}][currency_code]" value="{{ old("prices.$index.currency_code",$saved?->currency_code ?? $country->currency_code) }}"></div>
                            <div class="col-sm-4"><label class="form-label">{{ trans('admin.saas.monthly_price') }}</label><input type="number" min="0" step="0.01" class="form-control" name="prices[{{ $index }}][monthly_price]" value="{{ old("prices.$index.monthly_price",$saved?->monthly_price) }}"></div>
                            <div class="col-sm-4"><label class="form-label">{{ trans('admin.saas.annual_price') }}</label><input type="number" min="0" step="0.01" class="form-control" name="prices[{{ $index }}][annual_price]" value="{{ old("prices.$index.annual_price",$saved?->annual_price) }}"></div>
                            <div class="col-sm-6"><label class="form-label">{{ trans('admin.saas.tax_rate') }}</label><div class="input-group"><input type="number" min="0" max="100" step="0.01" class="form-control" name="prices[{{ $index }}][tax_rate]" value="{{ old("prices.$index.tax_rate",$saved?->tax_rate ?? 0) }}"><span class="input-group-text">%</span></div></div>
                            <div class="col-sm-6 d-flex align-items-end pb-2"><div class="form-check"><input class="form-check-input" type="checkbox" name="prices[{{ $index }}][tax_included]" value="1" @checked(old("prices.$index.tax_included",$saved?->tax_included))><label class="form-check-label">{{ trans('admin.saas.tax_included') }}</label></div></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-check form-switch mt-4"><input class="form-check-input" type="checkbox" name="active" value="1" @checked(old('active',$plan->exists?$plan->active:true))><label class="form-check-label">{{ trans('admin.saas.active') }}</label></div>
        <div class="mt-4 d-flex gap-2"><button class="btn btn-primary">{{ trans('admin.submit') }}</button><a class="btn btn-light" href="{{ route('admin.saas-plans.index') }}">{{ trans('admin.saas.cancel') }}</a></div>
    </form>
</div>
@endsection
