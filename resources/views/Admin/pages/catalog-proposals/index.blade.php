@extends('Admin.Layouts.master')
@section('title', trans('admin.catalog.title'))
@push('css')
<style>
.catalog-proposals {--catalog-border:#ccd3dd;--catalog-muted:#536477; color:#172a3b}
.catalog-proposals .catalog-hero {background:#101b22;color:white;border-radius:18px;padding:28px; margin:24px 0}
.catalog-proposals .catalog-hero img {width:145px;height:auto;margin-bottom:16px}
.catalog-proposals .catalog-hero h1 {color:white;font-size:26px;line-height:1.5}
.catalog-proposals .catalog-hero p {color:#d7e2e8;line-height:1.9;max-width:850px;margin-bottom:0}
.catalog-proposals .catalog-stats {display:flex;gap:12px;flex-wrap:wrap;margin:16px 0}
.catalog-proposals .catalog-stats span {background:#eafaD5;color:#254114;border-radius:9px;padding:8px 14px;font-weight:600}
.catalog-proposals .catalog-filters,.catalog-proposals .academy-proposal {border:1px solid var(--catalog-border);border-radius:14px;padding:20px;background:#fff}
.catalog-proposals .catalog-filters {margin-bottom:22px}
.catalog-proposals .form-control,.catalog-proposals .form-select {border:1px solid #7b8799;min-height:44px}
.catalog-proposals .proposal-grid {display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
.catalog-proposals .academy-proposal {min-width:0}
.catalog-proposals .academy-proposal h2 {font-size:19px;line-height:1.7;margin:0 0 4px;color:inherit}
.catalog-proposals .proposal-name {color:var(--catalog-muted);overflow-wrap:anywhere}
.catalog-proposals .proposal-tag {display:inline-block;background:#eef3f9;border-radius:6px;padding:4px 9px;margin:6px 0;color:#274b76}
.catalog-proposals .proposal-logo {font-size:12px;color:var(--catalog-muted);border:1px dashed #a3afbc;border-radius:8px;padding:8px 10px;display:inline-block;margin-bottom:12px}
.catalog-proposals .training-proposal {border-top:1px solid var(--catalog-border);margin-top:14px;padding-top:14px}
.catalog-proposals .training-proposal h3 {font-size:16px;color:inherit;line-height:1.7;margin:0 0 8px}
.catalog-proposals .proposal-price {font-size:23px;font-weight:700;color:#163b29;margin-inline-end:8px}
.catalog-proposals .proposal-price-label {color:#755311;background:#fff5d7;border-radius:5px;padding:3px 6px;font-size:12px}
.catalog-proposals .proposal-meta {color:var(--catalog-muted);font-size:13px;margin-top:6px;line-height:1.8}
.catalog-proposals .proposal-empty {grid-column:1/-1;padding:30px;text-align:center}
body.dark .catalog-proposals {color:#e2e8f0;--catalog-border:#465469;--catalog-muted:#b7c4d5}
body.dark .catalog-proposals .catalog-filters,body.dark .catalog-proposals .academy-proposal {background:#172333}
body.dark .catalog-proposals .proposal-price {color:#b7f580}
@media(max-width:1000px){.catalog-proposals .proposal-grid {grid-template-columns:1fr}}
@media(max-width:575px){.catalog-proposals .catalog-hero,.catalog-proposals .academy-proposal {padding:17px}.catalog-proposals .catalog-hero h1 {font-size:22px}}
</style>
@endpush
@section('content')
<div class="middle-content container-xxl p-0 catalog-proposals">
    <header class="catalog-hero">
        <img src="{{ asset('assetsAdmin/catalog/hagzz.svg') }}" alt="Hagzz">
        <h1>{{ trans('admin.catalog.title') }}</h1>
        <p>{{ trans('admin.catalog.notice') }}</p>
    </header>
    <div class="catalog-stats"><span>15 {{ trans('admin.catalog.eg') }}</span><span>15 {{ trans('admin.catalog.qa') }}</span><span>90 {{ trans('admin.catalog.trainings') }}</span><span>23 {{ trans('admin.catalog.sports') }}</span></div>
    <form class="catalog-filters row g-3 mx-0" method="GET" action="{{ route('admin.catalog-proposals.index') }}">
        @if($errors->any())<div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>@endif
        <div class="col-md-3"><label for="catalog-country" class="form-label">{{ trans('admin.catalog.country') }}</label><select id="catalog-country" name="country" class="form-select"><option value="">{{ trans('admin.catalog.all') }}</option>@foreach(['eg','qa'] as $country)<option value="{{ $country }}" @selected(($filters['country'] ?? '') === $country)>{{ trans('admin.catalog.'.$country) }}</option>@endforeach</select></div>
        <div class="col-md-3"><label for="catalog-sport" class="form-label">{{ trans('admin.catalog.sport') }}</label><select id="catalog-sport" name="sport" class="form-select"><option value="">{{ trans('admin.catalog.all') }}</option>@foreach($sports as $key => $label)<option value="{{ $key }}" @selected(($filters['sport'] ?? '') === $key)>{{ $label }}</option>@endforeach</select></div>
        <div class="col-md-4"><label for="catalog-query" class="form-label">{{ trans('admin.catalog.search') }}</label><input class="form-control" id="catalog-query" name="q" maxlength="100" value="{{ $filters['q'] ?? '' }}"></div>
        <div class="col-12 d-flex flex-wrap gap-2"><button class="btn btn-primary" type="submit">{{ trans('admin.catalog.filter') }}</button><a class="btn btn-outline-secondary" href="{{ route('admin.catalog-proposals.index') }}">{{ trans('admin.catalog.reset') }}</a><a class="btn btn-success" href="{{ route('admin.catalog-proposals.download') }}">{{ trans('admin.catalog.download') }}</a></div>
    </form>
    <div class="proposal-grid">
    @forelse($academies as $academy)
        <article class="academy-proposal">
            <div class="proposal-logo">{{ trans('admin.catalog.logo_pending') }}</div>
            <h2>{{ app()->getLocale() === 'ar' ? $academy['name_ar_proposed'] : $academy['name'] }}</h2>
            <div class="proposal-name" dir="auto">{{ $academy['name'] }}</div>
            <div class="proposal-meta">{{ trans('admin.catalog.'.$academy['country']) }} · <span dir="auto">{{ $academy['city_region_from_lead'] }}</span></div>
            <span class="proposal-tag">{{ app()->getLocale() === 'ar' ? $academy['sport_ar'] : $academy['sport_en'] }}</span>
            @foreach($academy['trainings'] as $training)
                <section class="training-proposal">
                    <h3>{{ app()->getLocale() === 'ar' ? $training['name_ar'] : $training['name_en'] }}</h3>
                    <div><span class="proposal-price">{{ number_format($training['proposed_price']) }} {{ $training['currency'] }}</span><span class="proposal-price-label">{{ trans('admin.catalog.price_proposal') }}</span></div>
                    <div class="proposal-meta">{{ $training['proposed_sessions'] }} {{ trans('admin.catalog.sessions') }} · {{ trans('admin.catalog.package') }} · {{ trans('admin.catalog.not_bookable') }}</div>
                </section>
            @endforeach
            <p class="proposal-meta mt-3">{{ trans('admin.catalog.missing_details') }}</p>
        </article>
    @empty
        <p class="proposal-empty">{{ trans('admin.catalog.empty') }}</p>
    @endforelse
    </div>
    <div class="mt-4">{{ $academies->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
