@extends('Admin.Layouts.master')

@php
    $isArabic = app()->getLocale() === 'ar';
@endphp

@section('title', $camp->title)

@section('content')
<div class="container-fluid py-4">
    <!-- TOP HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge bg-primary px-3 py-2 fw-bold mb-2">{{ $camp->academy?->commercial_name ?: $camp->academy?->name }}</span>
            <h3 class="fw-bold text-dark mb-1">{{ $camp->title }}</h3>
            <p class="text-muted small mb-0">
                <i class="fa-solid fa-calendar me-1"></i> {{ $camp->starts_on?->format('d M Y') }} - {{ $camp->ends_on?->format('d M Y') }}
                <span class="mx-2">|</span>
                <i class="fa-solid fa-hotel me-1"></i> {{ $camp->hotel_name ?: ($isArabic ? 'غير محدد' : 'N/A') }}
            </p>
        </div>
        <a href="{{ route('admin.camps.index') }}" class="btn btn-outline-secondary fw-bold">
            <i class="fa-solid fa-arrow-right me-1"></i> {{ $isArabic ? 'عودة لمعسكرات المنصة' : 'Back to Camps' }}
        </a>
    </div>

    <!-- METRICS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <span class="text-muted small d-block">{{ $isArabic ? 'المبالغ المحصلة' : 'Collected Revenue' }}</span>
                <h3 class="fw-bold text-success mb-0 mt-1">{{ number_format($totalRevenue, 2) }} <small class="fs-6">{{ $camp->currency_code }}</small></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <span class="text-muted small d-block">{{ $isArabic ? 'مصروفات المعسكر المسجلة' : 'Camp Expenses' }}</span>
                <h3 class="fw-bold text-danger mb-0 mt-1">{{ number_format($totalExpenses, 2) }} <small class="fs-6">{{ $camp->currency_code }}</small></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <span class="text-muted small d-block">{{ $isArabic ? 'صافي ربح المعسكر' : 'Net Camp Profit' }}</span>
                <h3 class="fw-bold {{ $netProfit >= 0 ? 'text-primary' : 'text-danger' }} mb-0 mt-1">{{ number_format($netProfit, 2) }} <small class="fs-6">{{ $camp->currency_code }}</small></h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <span class="text-muted small d-block">{{ $isArabic ? 'عدد المشاركين' : 'Participants' }}</span>
                <h3 class="fw-bold text-dark mb-0 mt-1">{{ $camp->participants->count() }} / {{ $camp->capacity }}</h3>
            </div>
        </div>
    </div>

    <!-- PARTICIPANTS LIST -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom p-3">
            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-users text-primary me-2"></i> {{ $isArabic ? 'كشف المسافرين والمشاركين بالمعسكر' : 'Camp Participants Roster' }}</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ $isArabic ? 'اسم المشارك' : 'Name' }}</th>
                            <th>{{ $isArabic ? 'الهاتف' : 'Phone' }}</th>
                            <th>{{ $isArabic ? 'الجواز / التأشيرة' : 'Passport / Visa' }}</th>
                            <th>{{ $isArabic ? 'الغرفة' : 'Room' }}</th>
                            <th>{{ $isArabic ? 'الرسوم' : 'Total Fee' }}</th>
                            <th>{{ $isArabic ? 'المدفوع' : 'Paid' }}</th>
                            <th>{{ $isArabic ? 'الحالة' : 'Status' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($camp->participants as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong class="text-dark">{{ $p->name }}</strong></td>
                                <td><span dir="ltr">{{ $p->phone }}</span></td>
                                <td>
                                    @if($p->passport_number)
                                        <small class="d-block text-dark">🛂 {{ $p->passport_number }}</small>
                                    @endif
                                    <span class="badge {{ $p->visa_status === 'issued' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $p->visa_status }}
                                    </span>
                                </td>
                                <td>{{ $p->room_number ?: '-' }}</td>
                                <td><strong>{{ number_format($p->total_fee, 0) }}</strong></td>
                                <td><span class="text-success fw-bold">{{ number_format($p->paid_amount, 0) }}</span></td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $p->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">{{ $isArabic ? 'لم يتم تسجيل أي مشاركين بالمعسكر بعد' : 'No participants registered yet' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
