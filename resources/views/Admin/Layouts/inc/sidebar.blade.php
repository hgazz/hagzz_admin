@php
    $locationOpen = Request::routeIs('admin.country.*', 'admin.cities.*', 'admin.areas.*', 'admin.academies.locations');
    $academyOpen = Request::routeIs('admin.academies.*', 'admin.training.*', 'admin.gallery.*', 'admin.booking.*');
    $preferencesOpen = Request::routeIs('admin.sport.*');
    $reportsOpen = Request::routeIs('admin.report.*');
@endphp

<style>
    #sidebar .admin-menu-label {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    #sidebar .admin-menu-icon {
        width: 21px;
        height: 21px;
        flex: 0 0 21px;
        color: currentColor;
    }
    #sidebar .submenu .admin-menu-icon {
        width: 17px;
        height: 17px;
        flex-basis: 17px;
        opacity: .82;
    }
    #sidebar .admin-menu-chevron {
        width: 18px;
        height: 18px;
        transition: transform .2s ease;
    }
    #sidebar a[aria-expanded="true"] .admin-menu-chevron {
        transform: rotate(90deg);
    }
</style>

<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('admin.index') }}">
                        <img src="{{ asset('assetsAdmin/logo.png') }}" class="navbar-logo" alt="{{ trans('admin.bokit') }}">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('admin.index') }}" class="nav-link">{{ trans('admin.bokit') }}</a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <x-feather-icon name="arrow-left" size="22" />
                </div>
            </div>
        </div>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::routeIs('admin.index') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label">
                        <x-feather-icon name="grid" class="admin-menu-icon" />
                        <span>{{ trans('admin.dashboard') }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::routeIs('admin.saas-plans.*') ? 'active' : '' }}">
                <a href="{{ route('admin.saas-plans.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label">
                        <x-feather-icon name="layers" class="admin-menu-icon" />
                        <span>{{ trans('admin.saas.plans') }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $locationOpen ? 'active' : '' }}">
                <a href="#address" data-bs-toggle="collapse" aria-expanded="{{ $locationOpen ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ $locationOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label">
                        <x-feather-icon name="map" class="admin-menu-icon" />
                        <span>{{ trans('admin.location_management') }}</span>
                    </div>
                    <x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $locationOpen ? 'show' : '' }}" id="address" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.country.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.country.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="flag" class="admin-menu-icon" /><span>{{ trans('admin.country.country') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.cities.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.cities.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="building" class="admin-menu-icon" /><span>{{ trans('admin.city.city') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.areas.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.areas.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="map-pin" class="admin-menu-icon" /><span>{{ trans('admin.area.area') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.academies.locations') ? 'active' : '' }}">
                        <a href="{{ route('admin.academies.locations') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="navigation" class="admin-menu-icon" /><span>{{ trans('admin.partner_location') }}</span></div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ $academyOpen ? 'active' : '' }}">
                <a href="#academy" data-bs-toggle="collapse" aria-expanded="{{ $academyOpen ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ $academyOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label">
                        <x-feather-icon name="briefcase" class="admin-menu-icon" />
                        <span>{{ trans('admin.partner_management') }}</span>
                    </div>
                    <x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $academyOpen ? 'show' : '' }}" id="academy" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.academies.*') && !Request::routeIs('admin.academies.locations') ? 'active' : '' }}">
                        <a href="{{ route('admin.academies.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="building" class="admin-menu-icon" /><span>{{ trans('admin.partner') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.training.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.training.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="activity" class="admin-menu-icon" /><span>{{ trans('admin.training.training') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.gallery.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="image" class="admin-menu-icon" /><span>{{ trans('admin.gallery.gallery') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.booking.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.booking.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="bookmark" class="admin-menu-icon" /><span>{{ trans('admin.bookings.bookings') }}</span></div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ $preferencesOpen ? 'active' : '' }}">
                <a href="#preferences" data-bs-toggle="collapse" aria-expanded="{{ $preferencesOpen ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ $preferencesOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label"><x-feather-icon name="sliders" class="admin-menu-icon" /><span>{{ trans('admin.preferences') }}</span></div>
                    <x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $preferencesOpen ? 'show' : '' }}" id="preferences" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.sport.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sport.index') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="award" class="admin-menu-icon" /><span>{{ trans('admin.sport.sport') }}</span></div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ Request::routeIs('admin.offline.create') ? 'active' : '' }}">
                <a href="{{ route('admin.offline.create') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="plus-circle" class="admin-menu-icon" /><span>{{ trans('admin.bookings.add_new_booking') }}</span></div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.faq.*') ? 'active' : '' }}">
                <a href="{{ route('admin.faq.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="help-circle" class="admin-menu-icon" /><span>{{ trans('admin.faq.faq') }}</span></div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.banners.*') ? 'active' : '' }}">
                <a href="{{ route('admin.banners.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="image" class="admin-menu-icon" /><span>{{ trans('admin.banners.banners') }}</span></div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.user.*') ? 'active' : '' }}">
                <a href="{{ route('admin.user.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="users" class="admin-menu-icon" /><span>{{ trans('admin.user.user') }}</span></div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.setting.*') ? 'active' : '' }}">
                <a href="{{ route('admin.setting.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="settings" class="admin-menu-icon" /><span>{{ trans('admin.setting.setting') }}</span></div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.notification.*') ? 'active' : '' }}">
                <a href="{{ route('admin.notification.index') }}" class="dropdown-toggle">
                    <div class="admin-menu-label"><x-feather-icon name="bell" class="admin-menu-icon" /><span>{{ trans('admin.notification.notification') }}</span></div>
                </a>
            </li>

            <li class="menu {{ $reportsOpen ? 'active' : '' }}">
                <a href="#report" data-bs-toggle="collapse" aria-expanded="{{ $reportsOpen ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ $reportsOpen ? '' : 'collapsed' }}">
                    <div class="admin-menu-label"><x-feather-icon name="bar-chart" class="admin-menu-icon" /><span>{{ trans('admin.report') }}</span></div>
                    <x-feather-icon name="chevron-right" class="admin-menu-chevron" />
                </a>
                <ul class="collapse submenu list-unstyled {{ $reportsOpen ? 'show' : '' }}" id="report" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.report.settlement') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.settlement') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="credit-card" class="admin-menu-icon" /><span>{{ trans('admin.settlement') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.report.transactions') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.transactions') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="repeat" class="admin-menu-icon" /><span>{{ trans('admin.transaction') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.report.joins') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.joins') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="bookmark" class="admin-menu-icon" /><span>{{ trans('admin.bookings.bookings') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.report.offline-joins') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.offline-joins') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="clipboard" class="admin-menu-icon" /><span>{{ trans('admin.bookings.offline_bookings') }}</span></div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.report.coach') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.coach') }}" class="dropdown-toggle">
                            <div class="admin-menu-label"><x-feather-icon name="user-check" class="admin-menu-icon" /><span>{{ trans('admin.Coaches') }}</span></div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
