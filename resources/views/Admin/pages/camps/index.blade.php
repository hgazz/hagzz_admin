@extends('Admin.Layouts.master')

@php
    $isArabic = app()->getLocale() === 'ar';
@endphp

@section('title', $isArabic ? 'متابعة المعسكرات التدريبية' : 'Training Camps Monitoring')

@section('content')
<div class="container-fluid py-4">
    <!-- TOP PAGE HEADER -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-plane-departure text-primary me-2"></i>
                {{ $isArabic ? 'إدارة ومتابعة المعسكرات التدريبية' : 'Training Camps Global Monitoring' }}
            </h3>
            <p class="text-muted small mb-0">
                {{ $isArabic ? 'متابعة كافة المعسكرات الدولية والمحلية المنظمة بواسطة الأكاديميات الشريكة وإحصائيات المسافرين.' : 'Monitor all domestic & international camps organized by partner academies across the platform.' }}
            </p>
        </div>
    </div>

    <!-- GLOBAL STATS STRIP -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="fa-solid fa-campground fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ $isArabic ? 'إجمالي معسكرات المنصة' : 'Total Platform Camps' }}</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalCamps) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                        <i class="fa-solid fa-flag-checkered fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ $isArabic ? 'معسكرات محليه (مصر)' : 'Domestic Camps' }}</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($domesticCamps) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info">
                        <i class="fa-solid fa-earth-americas fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ $isArabic ? 'معسكرات دولية (خارجية)' : 'International Camps' }}</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($internationalCamps) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">{{ $isArabic ? 'إجمالي المشاركين والمسافرين' : 'Total Campers' }}</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalParticipants) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.camps.index') }}" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <select name="academy_id" class="form-select">
                        <option value="">{{ $isArabic ? 'جميع الأكاديميات الشريكة' : 'All Partner Academies' }}</option>
                        @foreach($academies as $ac)
                            <option value="{{ $ac->id }}" {{ request('academy_id') == $ac->id ? 'selected' : '' }}>{{ $ac->commercial_name ?: $ac->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">{{ $isArabic ? 'نوع المعسكر' : 'All Types' }}</option>
                        <option value="domestic" {{ request('type') === 'domestic' ? 'selected' : '' }}>{{ $isArabic ? '🇪🇬 محلي (مصر)' : 'Domestic' }}</option>
                        <option value="international" {{ request('type') === 'international' ? 'selected' : '' }}>{{ $isArabic ? '✈️ دولي (خارجي)' : 'International' }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ $isArabic ? 'بحث باسم المعسكر أو الفندق...' : 'Search camp name, hotel...' }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">{{ $isArabic ? 'جميع الحالات' : 'All Statuses' }}</option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>{{ $isArabic ? 'قادم' : 'Upcoming' }}</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ $isArabic ? 'جاري' : 'Active' }}</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ $isArabic ? 'مكتمل' : 'Completed' }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fa-solid fa-filter me-1"></i> {{ $isArabic ? 'تصفية' : 'Filter' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- CAMPS TABLE -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'الأكاديمية المنظمة' : 'Academy' }}</th>
                            <th>{{ $isArabic ? 'عنوان المعسكر' : 'Camp Title' }}</th>
                            <th>{{ $isArabic ? 'النوع والوجهة' : 'Type & Destination' }}</th>
                            <th>{{ $isArabic ? 'التواريخ' : 'Dates' }}</th>
                            <th>{{ $isArabic ? 'المشاركون' : 'Campers' }}</th>
                            <th>{{ $isArabic ? 'سعر الفرد' : 'Price/Person' }}</th>
                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                            <th>{{ $isArabic ? 'الإجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($camps as $index => $camp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong class="text-dark d-block">{{ $camp->academy?->commercial_name ?: $camp->academy?->name }}</strong>
                                    <small class="text-muted"><i class="fa-solid fa-trophy me-1"></i> {{ $camp->sport?->name ?: ($isArabic ? 'متعدد الرياضات' : 'Multi-Sport') }}</small>
                                </td>
                                <td>
                                    <strong class="text-primary d-block">{{ $camp->title }}</strong>
                                    <small class="text-muted"><i class="fa-solid fa-hotel me-1"></i> {{ $camp->hotel_name ?: '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $camp->type === 'international' ? 'bg-purple text-white' : 'bg-info text-white' }} px-2 py-1">
                                        {{ $camp->type === 'international' ? ($isArabic ? '✈️ دولي' : 'International') : ($isArabic ? '🇪🇬 محلي' : 'Domestic') }}
                                    </span>
                                    <small class="d-block text-muted mt-1">{{ $camp->country?->name ?: ($camp->city_name ?: '-') }}</small>
                                </td>
                                <td>
                                    <small class="d-block text-dark fw-bold">{{ $camp->starts_on?->format('d M') }} - {{ $camp->ends_on?->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
                                        {{ $camp->participants_count }} / {{ $camp->capacity }}
                                    </span>
                                </td>
                                <td><strong>{{ number_format($camp->price, 0) }} {{ $camp->currency_code }}</strong></td>
                                <td>
                                    <span class="badge {{ $camp->status === 'active' ? 'bg-success' : ($camp->status === 'upcoming' ? 'bg-primary' : 'bg-secondary') }} px-2 py-1">
                                        {{ $camp->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.camps.show', $camp->id) }}" class="btn btn-sm btn-outline-primary fw-bold">
                                        <i class="fa-solid fa-eye me-1"></i> {{ $isArabic ? 'معاينة التفاصيل' : 'View Hub' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">{{ $isArabic ? 'لا توجد معسكرات مطابقة لشروط البحث' : 'No camps found matching criteria' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $camps->links() }}
    </div>
</div>
@endsection
