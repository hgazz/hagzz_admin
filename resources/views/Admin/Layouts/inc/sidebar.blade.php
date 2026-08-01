@php
    $locationOpen = Request::routeIs('admin.country.*', 'admin.cities.*', 'admin.areas.*', 'admin.academies.locations');
    $academyOpen = Request::routeIs('admin.academies.*', 'admin.training.*', 'admin.gallery.*');
    $reportsOpen = Request::routeIs('admin.report.*');
    $isArabic = session('locale', app()->getLocale()) === 'ar';
@endphp

<style>
    .sidebar-wrapper { height: 100vh !important; }
    #sidebar { height: 100%; overflow: hidden !important; display: flex; flex-direction: column; position: relative; }
    #sidebar .theme-brand { flex: 0 0 auto; z-index: 5; background: inherit; }
    #sidebar > .shadow-bottom { flex: 0 0 auto; }
    #sidebar > .menu-categories {
        flex: 1 1 auto; min-height: 0; overflow-y: auto !important; overflow-x: hidden !important;
        overscroll-behavior: contain; scroll-behavior: smooth; scrollbar-gutter: stable;
        scrollbar-width: thin; scrollbar-color: rgba(27, 85, 226, .45) transparent;
        padding-bottom: 140px !important;
    }
    #sidebar > .menu-categories::-webkit-scrollbar { width: 6px; }
    #sidebar > .menu-categories::-webkit-scrollbar-track { background: transparent; }
    #sidebar > .menu-categories::-webkit-scrollbar-thumb { background: rgba(27, 85, 226, .42); border-radius: 10px; }
    #sidebar .admin-menu-label { display: flex; align-items: center; gap: 12px; min-width: 0; }
    #sidebar .admin-menu-icon { width: 21px; height: 21px; flex: 0 0 21px; color: currentColor; }
    #sidebar .submenu .admin-menu-icon { width: 17px; height: 17px; flex-basis: 17px; opacity: .82; }
    #sidebar .admin-menu-chevron { width: 18px; height: 18px; transition: transform .2s ease; }
    #sidebar a[aria-expanded="true"] .admin-menu-chevron { transform: rotate(90deg); }
    #sidebar .navigation-section { padding: 18px 22px 7px; list-style: none; }
    #sidebar .navigation-section span {
        color: #888ea8; font-size: 10px; font-weight: 800; letter-spacing: .075em;
        text-transform: uppercase; white-space: nowrap;
    }
    #sidebar .menu > a { border-radius: 10px; margin-inline: 10px; }
    #sidebar .menu.active > a { box-shadow: inset 3px 0 0 #1b55e2; }
    [dir="rtl"] #sidebar .menu.active > a { box-shadow: inset -3px 0 0 #1b55e2; }
    #sidebar .sidebar-scroll-controls {
        position: absolute; inset-inline-end: 14px; bottom: 14px; z-index: 20; display: flex; gap: 7px;
        padding: 6px; border: 1px solid rgba(27, 85, 226, .16); border-radius: 14px;
        background: rgba(255, 255, 255, .94); box-shadow: 0 8px 24px rgba(31, 45, 61, .16);
        backdrop-filter: blur(8px);
    }
    #sidebar .sidebar-scroll-controls[hidden] { display: none !important; }
    #sidebar .sidebar-scroll-button {
        width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
        border: 0; border-radius: 9px; background: #eef2ff; color: #1b55e2; cursor: pointer;
        transition: transform .18s ease, opacity .18s ease, background .18s ease;
    }
    #sidebar .sidebar-scroll-button:hover { background: #1b55e2; color: #fff; transform: translateY(-1px); }
    #sidebar .sidebar-scroll-button:disabled { opacity: .28; cursor: default; transform: none; }
    #sidebar .sidebar-scroll-button svg { width: 17px; height: 17px; }
    body.dark #sidebar .sidebar-scroll-controls, .dark #sidebar .sidebar-scroll-controls {
        background: rgba(20, 30, 50, .94); border-color: rgba(136, 142, 168, .25);
    }
    @media (max-width: 991px) { #sidebar .sidebar-scroll-controls { bottom: 10px; } }
</style>

<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo"><a href="{{ route('admin.index') }}"><img src="{{ asset('assetsAdmin/logo.png') }}" class="navbar-logo" alt="{{ trans('admin.bokit') }}"></a></div>
                <div class="nav-item theme-text"><a href="{{ route('admin.index') }}" class="nav-link">{{ trans('admin.bokit') }}</a></div>
            </div>
            <div class="nav-item sidebar-toggle"><div class="btn-toggle sidebarCollapse"><x-feather-icon name="arrow-left" size="22" /></div></div>
        </div>
        <div class="shadow-bottom"></div>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::routeIs('admin.index') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="grid" class="admin-menu-icon" /><span>{{ trans('admin.dashboard') }}</span></div></a>
            </li>

            <li class="navigation-section"><span>{{ $isArabic ? 'التشغيل اليومي' : 'Daily operations' }}</span></li>
            <li class="menu {{ Request::routeIs('admin.offline.create') ? 'active' : '' }}">
                <a href="{{ route('admin.offline.create') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="plus-circle" class="admin-menu-icon" /><span>{{ $isArabic ? 'إضافة حجز أوفلاين جديد' : 'Add New Offline Booking' }}</span></div></a>
            </li>
            <li class="menu {{ Request::routeIs('admin.booking.*') ? 'active' : '' }}">
                <a href="{{ route('admin.booking.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="calendar" class="admin-menu-icon" /><span>{{ $isArabic ? 'الحجوزات والأنشطة' : 'Bookings & Activities' }}</span></div></a>
            </li>

            <li class="navigation-section"><span>{{ $isArabic ? 'الشركاء والخدمات' : 'Partners & services' }}</span></li>
            <li class="menu {{ $academyOpen ? 'active' : '' }}">
                <a href="#academy" data-bs-toggle="collapse" aria-expanded="{{ $academyOpen ? 'true' : 'false' }}" class="dropdown-toggle {{ $academyOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label"><x-feather-icon name="briefcase" class="admin-menu-icon" /><span>{{ trans('admin.partner_management') }}</span></div><x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $academyOpen ? 'show' : '' }}" id="academy" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.academies.*') && !Request::routeIs('admin.academies.locations') ? 'active' : '' }}"><a href="{{ route('admin.academies.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="building" class="admin-menu-icon" /><span>{{ trans('admin.partner') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.training.*') ? 'active' : '' }}"><a href="{{ route('admin.training.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="activity" class="admin-menu-icon" /><span>{{ trans('admin.training.training') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.gallery.*') ? 'active' : '' }}"><a href="{{ route('admin.gallery.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="image" class="admin-menu-icon" /><span>{{ trans('admin.gallery.gallery') }}</span></div></a></li>
                </ul>
            </li>
            <li class="menu {{ Request::routeIs('admin.camps.*') ? 'active' : '' }}"><a href="{{ route('admin.camps.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="send" class="admin-menu-icon" /><span>{{ $isArabic ? 'المعسكرات التدريبية' : 'Training Camps' }}</span></div></a></li>
            <li class="menu {{ Request::routeIs('admin.sport.*') ? 'active' : '' }}"><a href="{{ route('admin.sport.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="award" class="admin-menu-icon" /><span>{{ trans('admin.sport.sport') }}</span></div></a></li>

            <li class="navigation-section"><span>{{ $isArabic ? 'الاشتراكات والتقارير' : 'Billing & reports' }}</span></li>
            <li class="menu {{ Request::routeIs('admin.saas-plans.*') ? 'active' : '' }}"><a href="{{ route('admin.saas-plans.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="layers" class="admin-menu-icon" /><span>{{ trans('admin.saas.plans') }}</span></div></a></li>
            <li class="menu {{ $reportsOpen ? 'active' : '' }}">
                <a href="#report" data-bs-toggle="collapse" aria-expanded="{{ $reportsOpen ? 'true' : 'false' }}" class="dropdown-toggle {{ $reportsOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label"><x-feather-icon name="bar-chart" class="admin-menu-icon" /><span>{{ trans('admin.report') }}</span></div><x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $reportsOpen ? 'show' : '' }}" id="report" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.report.subscriptions.*') ? 'active' : '' }}"><a href="{{ route('admin.report.subscriptions.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="trending-up" class="admin-menu-icon" /><span>{{ trans('admin.subscription_revenue.menu') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.report.settlement') ? 'active' : '' }}"><a href="{{ route('admin.report.settlement') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="credit-card" class="admin-menu-icon" /><span>{{ trans('admin.settlement') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.report.transactions*') ? 'active' : '' }}"><a href="{{ route('admin.report.transactions') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="repeat" class="admin-menu-icon" /><span>{{ $isArabic ? 'فواتير ومدفوعات الحجوزات' : 'Booking invoices & payments' }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.report.joins') ? 'active' : '' }}"><a href="{{ route('admin.report.joins') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="bookmark" class="admin-menu-icon" /><span>{{ $isArabic ? 'تفاصيل حجوزات التدريبات' : 'Training booking details' }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.report.offline-joins') ? 'active' : '' }}"><a href="{{ route('admin.report.offline-joins') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="clipboard" class="admin-menu-icon" /><span>{{ $isArabic ? 'الحجوزات المسجلة يدويًا' : 'Manually entered bookings' }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.report.coach') ? 'active' : '' }}"><a href="{{ route('admin.report.coach') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="user-check" class="admin-menu-icon" /><span>{{ trans('admin.Coaches') }}</span></div></a></li>
                </ul>
            </li>

            <li class="navigation-section"><span>{{ $isArabic ? 'إدارة المنصة' : 'Platform management' }}</span></li>
            <li class="menu {{ Request::routeIs('admin.user.*') ? 'active' : '' }}"><a href="{{ route('admin.user.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="users" class="admin-menu-icon" /><span>{{ trans('admin.user.user') }}</span></div></a></li>
            <li class="menu {{ Request::routeIs('admin.notification.*') ? 'active' : '' }}"><a href="{{ route('admin.notification.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="bell" class="admin-menu-icon" /><span>{{ trans('admin.notification.notification') }}</span></div></a></li>
            <li class="menu {{ Request::routeIs('admin.banners.*') ? 'active' : '' }}"><a href="{{ route('admin.banners.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="image" class="admin-menu-icon" /><span>{{ trans('admin.banners.banners') }}</span></div></a></li>
            <li class="menu {{ Request::routeIs('admin.faq.*') ? 'active' : '' }}"><a href="{{ route('admin.faq.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="help-circle" class="admin-menu-icon" /><span>{{ trans('admin.faq.faq') }}</span></div></a></li>
            <li class="menu {{ $locationOpen ? 'active' : '' }}">
                <a href="#address" data-bs-toggle="collapse" aria-expanded="{{ $locationOpen ? 'true' : 'false' }}" class="dropdown-toggle {{ $locationOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label"><x-feather-icon name="map" class="admin-menu-icon" /><span>{{ trans('admin.location_management') }}</span></div><x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $locationOpen ? 'show' : '' }}" id="address" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.country.*') ? 'active' : '' }}"><a href="{{ route('admin.country.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="flag" class="admin-menu-icon" /><span>{{ trans('admin.country.country') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.cities.*') ? 'active' : '' }}"><a href="{{ route('admin.cities.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="building" class="admin-menu-icon" /><span>{{ trans('admin.city.city') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.areas.*') ? 'active' : '' }}"><a href="{{ route('admin.areas.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="map-pin" class="admin-menu-icon" /><span>{{ trans('admin.area.area') }}</span></div></a></li>
                    <li class="menu {{ Request::routeIs('admin.academies.locations') ? 'active' : '' }}"><a href="{{ route('admin.academies.locations') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="navigation" class="admin-menu-icon" /><span>{{ trans('admin.partner_location') }}</span></div></a></li>
                </ul>
            </li>
            <li class="menu {{ Request::routeIs('admin.setting.*') ? 'active' : '' }}"><a href="{{ route('admin.setting.index') }}" class="dropdown-toggle"><div class="admin-menu-label"><x-feather-icon name="settings" class="admin-menu-icon" /><span>{{ trans('admin.setting.setting') }}</span></div></a></li>
        </ul>

        <div class="sidebar-scroll-controls" aria-label="{{ $isArabic ? 'التمرير داخل القائمة' : 'Sidebar scrolling' }}">
            <button type="button" class="sidebar-scroll-button" data-scroll-direction="-1" title="{{ $isArabic ? 'تمرير لأعلى' : 'Scroll up' }}" aria-label="{{ $isArabic ? 'تمرير لأعلى' : 'Scroll up' }}"><x-feather-icon name="chevron-up" /></button>
            <button type="button" class="sidebar-scroll-button" data-scroll-direction="1" title="{{ $isArabic ? 'تمرير لأسفل' : 'Scroll down' }}" aria-label="{{ $isArabic ? 'تمرير لأسفل' : 'Scroll down' }}"><x-feather-icon name="chevron-down" /></button>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menu = document.querySelector('#sidebar > .menu-categories');
        const controls = document.querySelector('#sidebar > .sidebar-scroll-controls');
        if (!menu || !controls || menu.dataset.scrollReady === 'true') return;
        menu.dataset.scrollReady = 'true';
        const storageKey = 'hagzz-admin-sidebar-scroll';
        const buttons = controls.querySelectorAll('[data-scroll-direction]');
        const savedPosition = Number(sessionStorage.getItem(storageKey));
        if (Number.isFinite(savedPosition) && savedPosition > 0) {
            menu.scrollTop = savedPosition;
        } else {
            const activeItem = menu.querySelector('.menu.active');
            if (activeItem) activeItem.scrollIntoView({ block: 'center' });
        }
        const updateControls = function () {
            const maxScroll = Math.max(0, menu.scrollHeight - menu.clientHeight);
            buttons[0].disabled = menu.scrollTop <= 2;
            buttons[1].disabled = menu.scrollTop >= maxScroll - 2;
            controls.hidden = maxScroll <= 2;
        };
        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                menu.scrollBy({ top: Number(button.dataset.scrollDirection) * Math.max(220, menu.clientHeight * .55), behavior: 'smooth' });
            });
        });
        menu.addEventListener('scroll', function () {
            sessionStorage.setItem(storageKey, String(Math.round(menu.scrollTop)));
            updateControls();
        }, { passive: true });
        window.addEventListener('resize', updateControls, { passive: true });
        requestAnimationFrame(updateControls);
    });
</script>
