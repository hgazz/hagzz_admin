@extends('Admin.Layouts.master')

@section('title', trans('admin.dashboard'))

@push('css')
    <link href="{{ asset('assetsAdmin/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assetsAdmin/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assetsAdmin/src/assets/css/dashboard-modern.css') }}" rel="stylesheet" type="text/css">
@endpush

@php
    $isArabic = app()->getLocale() === 'ar';
    $copy = [
        'welcome' => $isArabic ? 'مرحباً بعودتك' : 'Welcome back',
        'overview' => $isArabic ? 'هذه نظرة سريعة على أداء منصة حجوز اليوم.' : 'Here is a quick view of Hagzz performance today.',
        'today' => $isArabic ? 'اليوم' : 'Today',
        'users' => $isArabic ? 'إجمالي المستخدمين' : 'Total users',
        'academies' => $isArabic ? 'الأكاديميات' : 'Academies',
        'activeAcademies' => $isArabic ? 'أكاديمية نشطة' : 'active academies',
        'trainings' => $isArabic ? 'التدريبات' : 'Trainings',
        'activeTrainings' => $isArabic ? 'تدريب نشط' : 'active trainings',
        'bookings' => $isArabic ? 'إجمالي الحجوزات' : 'Total bookings',
        'revenue' => $isArabic ? 'إجمالي الإيرادات' : 'Total revenue',
        'pending' => $isArabic ? 'بانتظار المراجعة' : 'Awaiting review',
        'last30' => $isArabic ? 'مقارنةً بالـ 30 يوم السابقة' : 'vs previous 30 days',
        'performance' => $isArabic ? 'الحجوزات والإيرادات' : 'Bookings and revenue',
        'performanceHint' => $isArabic ? 'أداء المنصة خلال آخر 12 شهراً' : 'Platform performance over the last 12 months',
        'userGrowth' => $isArabic ? 'نمو المستخدمين' : 'User growth',
        'userGrowthHint' => $isArabic ? 'الحسابات الجديدة شهرياً' : 'New accounts by month',
        'status' => $isArabic ? 'حالة الحجوزات' : 'Booking status',
        'paid' => $isArabic ? 'مدفوعة' : 'Paid',
        'canceled' => $isArabic ? 'ملغاة' : 'Canceled',
        'topSports' => $isArabic ? 'الرياضات الأكثر حجزاً' : 'Top booked sports',
        'topSportsHint' => $isArabic ? 'حسب عدد الحجوزات المسجلة' : 'Ranked by recorded bookings',
        'academyPerformance' => $isArabic ? 'أداء الأكاديميات' : 'Academy performance',
        'academyHint' => $isArabic ? 'الأكاديميات الأعلى نشاطاً' : 'Most active academies',
        'academy' => $isArabic ? 'الأكاديمية' : 'Academy',
        'recent' => $isArabic ? 'أحدث الحجوزات' : 'Recent bookings',
        'recentHint' => $isArabic ? 'آخر العمليات المسجلة على المنصة' : 'Latest platform activity',
        'customer' => $isArabic ? 'العميل' : 'Customer',
        'training' => $isArabic ? 'التدريب' : 'Training',
        'amount' => $isArabic ? 'المبلغ' : 'Amount',
        'date' => $isArabic ? 'التاريخ' : 'Date',
        'filter' => $isArabic ? 'تصفية المؤشرات' : 'Filter metrics',
        'from' => $isArabic ? 'من تاريخ' : 'From',
        'to' => $isArabic ? 'إلى تاريخ' : 'To',
        'apply' => $isArabic ? 'تطبيق' : 'Apply',
        'balance' => $isArabic ? 'قيمة الحجوزات' : 'Booking value',
        'refunds' => $isArabic ? 'الحجوزات المستردة' : 'Refunded bookings',
        'refundAmount' => $isArabic ? 'قيمة المستردات' : 'Refund amount',
        'filteredBookings' => $isArabic ? 'عدد الحجوزات' : 'Booking count',
        'noData' => $isArabic ? 'لا توجد بيانات بعد' : 'No data yet',
        'viewAll' => $isArabic ? 'عرض الكل' : 'View all',
        'currency' => $isArabic ? 'ج.م' : 'EGP',
    ];
@endphp

@section('content')
    <div class="middle-content container-xxl p-0 hagzz-dashboard" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
        <div class="dashboard-topbar">
            <button type="button" class="dashboard-menu-toggle btn-toggle sidebarCollapse" aria-label="Toggle menu">
                <i data-feather="menu"></i>
            </button>
            <div>
                <h1>{{ trans('admin.dashboard') }}</h1>
                <p>{{ $copy['today'] }}، {{ now()->locale(app()->getLocale())->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <section class="welcome-strip">
            <div class="welcome-copy">
                <span class="welcome-kicker">{{ $copy['welcome'] }}</span>
                <h2>{{ $dashboard['adminName'] ?: ($isArabic ? 'مدير النظام' : 'Administrator') }}</h2>
                <p>{{ $copy['overview'] }}</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('admin.academies.index') }}" class="dashboard-action dashboard-action-secondary">
                    <i data-feather="briefcase"></i>
                    <span>{{ $copy['academies'] }}</span>
                </a>
                <a href="{{ route('admin.booking.index') }}" class="dashboard-action dashboard-action-primary">
                    <i data-feather="calendar"></i>
                    <span>{{ $copy['bookings'] }}</span>
                </a>
            </div>
        </section>

        <section class="metric-grid" aria-label="Key performance indicators">
            <article class="metric-card metric-users">
                <div class="metric-icon"><i data-feather="users"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['users'] }}</span>
                    <strong>{{ number_format($dashboard['totalUsers']) }}</strong>
                    <small class="{{ $dashboard['userTrend'] >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i data-feather="{{ $dashboard['userTrend'] >= 0 ? 'trending-up' : 'trending-down' }}"></i>
                        {{ abs($dashboard['userTrend']) }}% {{ $copy['last30'] }}
                    </small>
                </div>
            </article>

            <article class="metric-card metric-academies">
                <div class="metric-icon"><i data-feather="briefcase"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['academies'] }}</span>
                    <strong>{{ number_format($dashboard['totalAcademies']) }}</strong>
                    <small>{{ number_format($dashboard['activeAcademies']) }} {{ $copy['activeAcademies'] }}</small>
                </div>
            </article>

            <article class="metric-card metric-trainings">
                <div class="metric-icon"><i data-feather="activity"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['trainings'] }}</span>
                    <strong>{{ number_format($dashboard['totalTrainings']) }}</strong>
                    <small>{{ number_format($dashboard['activeTrainings']) }} {{ $copy['activeTrainings'] }}</small>
                </div>
            </article>

            <article class="metric-card metric-bookings">
                <div class="metric-icon"><i data-feather="calendar"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['bookings'] }}</span>
                    <strong>{{ number_format($dashboard['totalBookings']) }}</strong>
                    <small class="{{ $dashboard['bookingTrend'] >= 0 ? 'trend-up' : 'trend-down' }}">
                        <i data-feather="{{ $dashboard['bookingTrend'] >= 0 ? 'trending-up' : 'trending-down' }}"></i>
                        {{ abs($dashboard['bookingTrend']) }}% {{ $copy['last30'] }}
                    </small>
                </div>
            </article>

            <article class="metric-card metric-revenue">
                <div class="metric-icon"><i data-feather="credit-card"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['revenue'] }}</span>
                    <strong>{{ number_format($dashboard['totalRevenue'], 0) }}</strong>
                    <small>{{ $copy['currency'] }}</small>
                </div>
            </article>

            <article class="metric-card metric-pending">
                <div class="metric-icon"><i data-feather="clock"></i></div>
                <div class="metric-body">
                    <span>{{ $copy['pending'] }}</span>
                    <strong>{{ number_format($dashboard['pendingBookings']) }}</strong>
                    <small>{{ $copy['bookings'] }}</small>
                </div>
            </article>
        </section>

        <section class="dashboard-grid dashboard-grid-main">
            <article class="dashboard-panel dashboard-panel-wide">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['performance'] }}</h3>
                        <p>{{ $copy['performanceHint'] }}</p>
                    </div>
                    <span class="panel-badge">{{ $copy['last30'] }}</span>
                </header>
                <div id="performanceChart" class="chart-slot chart-slot-large"></div>
            </article>

            <article class="dashboard-panel">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['status'] }}</h3>
                        <p>{{ number_format($dashboard['totalBookings']) }} {{ $copy['bookings'] }}</p>
                    </div>
                </header>
                <div id="bookingStatusChart" class="chart-slot chart-slot-large"></div>
            </article>
        </section>

        <section class="dashboard-grid dashboard-grid-secondary">
            <article class="dashboard-panel">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['userGrowth'] }}</h3>
                        <p>{{ $copy['userGrowthHint'] }}</p>
                    </div>
                </header>
                <div id="userGrowthChart" class="chart-slot"></div>
            </article>

            <article class="dashboard-panel">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['topSports'] }}</h3>
                        <p>{{ $copy['topSportsHint'] }}</p>
                    </div>
                </header>
                <div id="sportsChart" class="chart-slot"></div>
            </article>
        </section>

        <section class="filter-panel">
            <div class="filter-heading">
                <div class="filter-icon"><i data-feather="sliders"></i></div>
                <div>
                    <h3>{{ $copy['filter'] }}</h3>
                    <p>{{ $isArabic ? 'اختر فترة زمنية لمراجعة نتائج الحجوزات خلالها.' : 'Choose a date range to review booking results.' }}</p>
                </div>
            </div>
            <form id="filterForm" class="filter-form">
                <label>
                    <span>{{ $copy['from'] }}</span>
                    <input type="date" class="form-control" name="start_date" id="start_date">
                </label>
                <label>
                    <span>{{ $copy['to'] }}</span>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </label>
                <button type="button" id="filter" class="dashboard-action dashboard-action-primary">
                    <i data-feather="filter"></i>
                    <span>{{ $copy['apply'] }}</span>
                </button>
            </form>
            <div class="filtered-metrics">
                <div><span>{{ $copy['balance'] }}</span><strong id="total_booking_balance">0</strong></div>
                <div><span>{{ $copy['refunds'] }}</span><strong id="total_booking_refund_count">0</strong></div>
                <div><span>{{ $copy['refundAmount'] }}</span><strong id="total_booking_refund_amount">0</strong></div>
                <div><span>{{ $copy['filteredBookings'] }}</span><strong id="total_booking_count">0</strong></div>
            </div>
        </section>

        <section class="dashboard-grid dashboard-grid-tables">
            <article class="dashboard-panel data-panel">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['academyPerformance'] }}</h3>
                        <p>{{ $copy['academyHint'] }}</p>
                    </div>
                    <a href="{{ route('admin.academies.index') }}" class="panel-link">{{ $copy['viewAll'] }}</a>
                </header>
                <div class="dashboard-table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>{{ $copy['academy'] }}</th>
                                <th>{{ $copy['trainings'] }}</th>
                                <th>{{ $copy['bookings'] }}</th>
                                <th>{{ $copy['revenue'] }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboard['academyPerformance'] as $academy)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.academies.show', $academy['id']) }}" class="academy-cell">
                                            <span class="academy-avatar">{{ mb_substr($academy['name'], 0, 1) }}</span>
                                            <span>
                                                <b>{{ $academy['name'] }}</b>
                                                <small class="{{ $academy['status'] === 'active' ? 'status-active' : 'status-muted' }}">
                                                    {{ $academy['status'] === 'active' ? ($isArabic ? 'نشطة' : 'Active') : ($isArabic ? 'غير نشطة' : 'Inactive') }}
                                                </small>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{ number_format($academy['trainings']) }}</td>
                                    <td>{{ number_format($academy['bookings']) }}</td>
                                    <td>{{ number_format($academy['revenue'], 0) }} <small>{{ $copy['currency'] }}</small></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="empty-state">{{ $copy['noData'] }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="dashboard-panel data-panel">
                <header class="panel-header">
                    <div>
                        <h3>{{ $copy['recent'] }}</h3>
                        <p>{{ $copy['recentHint'] }}</p>
                    </div>
                    <a href="{{ route('admin.booking.index') }}" class="panel-link">{{ $copy['viewAll'] }}</a>
                </header>
                <div class="recent-list">
                    @forelse($dashboard['recentBookings'] as $booking)
                        @php
                            $invoiceStatus = $booking->invoice?->getRawOriginal('status');
                            $isCanceled = (bool) ($booking->invoice?->is_canceled ?? false);
                        @endphp
                        <div class="recent-item">
                            <div class="recent-avatar">{{ mb_substr($booking->user?->name ?: '?', 0, 1) }}</div>
                            <div class="recent-content">
                                <div class="recent-title">
                                    <strong>{{ $booking->user?->name ?: $copy['noData'] }}</strong>
                                    <span>{{ number_format($booking->price, 0) }} {{ $copy['currency'] }}</span>
                                </div>
                                <p>{{ $booking->training?->name ?: $copy['training'] }}</p>
                                <div class="recent-meta">
                                    <span>{{ $booking->created_at?->locale(app()->getLocale())->diffForHumans() }}</span>
                                    <span class="booking-status {{ $isCanceled ? 'is-canceled' : ($invoiceStatus === 'paid' ? 'is-paid' : 'is-pending') }}">
                                        {{ $isCanceled ? $copy['canceled'] : ($invoiceStatus === 'paid' ? $copy['paid'] : $copy['pending']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">{{ $copy['noData'] }}</div>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assetsAdmin/src/plugins/src/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assetsAdmin/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dashboardData = {
                labels: @json($dashboard['monthLabels']),
                bookings: @json($dashboard['monthlyBookings']),
                revenue: @json($dashboard['monthlyRevenue']),
                users: @json($dashboard['monthlyUsers']),
                sportLabels: @json($dashboard['topSports']->pluck('name')),
                sportBookings: @json($dashboard['topSports']->pluck('bookings')),
                statuses: @json(array_values($dashboard['bookingStatuses']))
            };

            const labels = {
                bookings: @json($copy['bookings']),
                revenue: @json($copy['revenue']),
                users: @json($copy['users']),
                paid: @json($copy['paid']),
                pending: @json($copy['pending']),
                canceled: @json($copy['canceled']),
                currency: @json($copy['currency'])
            };

            const isDark = document.body.classList.contains('dark');
            const textColor = isDark ? '#cbd5e1' : '#64748b';
            const gridColor = isDark ? '#293446' : '#e8edf4';
            const commonChart = {
                fontFamily: 'Cairo, Nunito, sans-serif',
                foreColor: textColor,
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 550 }
            };
            const noData = { text: @json($copy['noData']), align: 'center', verticalAlign: 'middle', style: { color: textColor } };

            new ApexCharts(document.querySelector('#performanceChart'), {
                chart: { ...commonChart, type: 'line', height: 360, stacked: false },
                series: [
                    { name: labels.bookings, type: 'column', data: dashboardData.bookings },
                    { name: labels.revenue, type: 'area', data: dashboardData.revenue }
                ],
                colors: ['#2563eb', '#14b8a6'],
                stroke: { width: [0, 3], curve: 'smooth' },
                fill: { type: ['solid', 'gradient'], gradient: { opacityFrom: 0.35, opacityTo: 0.04 } },
                plotOptions: { bar: { borderRadius: 4, columnWidth: '42%' } },
                dataLabels: { enabled: false },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                xaxis: { categories: dashboardData.labels, axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: [
                    { title: { text: labels.bookings }, min: 0, forceNiceScale: true },
                    { opposite: true, title: { text: labels.revenue }, min: 0, labels: { formatter: value => Math.round(value).toLocaleString() } }
                ],
                legend: { position: 'top', horizontalAlign: '{{ $isArabic ? 'right' : 'left' }}' },
                tooltip: { shared: true, intersect: false },
                noData
            }).render();

            new ApexCharts(document.querySelector('#userGrowthChart'), {
                chart: { ...commonChart, type: 'area', height: 300 },
                series: [{ name: labels.users, data: dashboardData.users }],
                colors: ['#7c3aed'],
                stroke: { curve: 'smooth', width: 3 },
                fill: { type: 'gradient', gradient: { opacityFrom: 0.35, opacityTo: 0.03 } },
                dataLabels: { enabled: false },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                xaxis: { categories: dashboardData.labels, axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: { min: 0, forceNiceScale: true },
                noData
            }).render();

            new ApexCharts(document.querySelector('#bookingStatusChart'), {
                chart: { ...commonChart, type: 'donut', height: 360 },
                series: dashboardData.statuses,
                labels: [labels.paid, labels.pending, labels.canceled],
                colors: ['#14b8a6', '#f59e0b', '#ef4444'],
                stroke: { width: 0 },
                dataLabels: { enabled: false },
                legend: { position: 'bottom', markers: { radius: 8 } },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: labels.bookings,
                                    formatter: function (chart) {
                                        return chart.globals.seriesTotals.reduce((total, value) => total + value, 0).toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                },
                noData
            }).render();

            new ApexCharts(document.querySelector('#sportsChart'), {
                chart: { ...commonChart, type: 'bar', height: 300 },
                series: [{ name: labels.bookings, data: dashboardData.sportBookings }],
                colors: ['#f97316'],
                plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '48%', distributed: false } },
                dataLabels: { enabled: false },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                xaxis: { categories: dashboardData.sportLabels, min: 0, forceNiceScale: true },
                noData
            }).render();

            flatpickr('#start_date', { dateFormat: 'Y-m-d' });
            flatpickr('#end_date', { dateFormat: 'Y-m-d' });

            const filterButton = document.getElementById('filter');
            filterButton.addEventListener('click', async function () {
                filterButton.disabled = true;
                const params = new URLSearchParams({
                    start_date: document.getElementById('start_date').value,
                    end_date: document.getElementById('end_date').value
                });

                try {
                    const response = await fetch(`{{ route('admin.filter-bookings') }}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    const data = await response.json();

                    document.getElementById('total_booking_balance').textContent =
                        `${Number(data.total_booking_balance || 0).toLocaleString()} ${labels.currency}`;
                    document.getElementById('total_booking_refund_count').textContent =
                        Number(data.total_booking_refund_count || 0).toLocaleString();
                    document.getElementById('total_booking_refund_amount').textContent =
                        `${Number(data.total_booking_refund_amount || 0).toLocaleString()} ${labels.currency}`;
                    document.getElementById('total_booking_count').textContent =
                        Number(data.total_booking_count || 0).toLocaleString();
                } catch (error) {
                    console.error('[Hagzz Dashboard] Booking filter failed', error);
                } finally {
                    filterButton.disabled = false;
                }
            });
            filterButton.click();

            if (window.feather) feather.replace();
        });
    </script>
@endpush
