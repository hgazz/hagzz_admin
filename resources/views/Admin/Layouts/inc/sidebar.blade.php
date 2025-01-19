<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('admin.index') }}">
                        <img src="{{ asset('assetsAdmin/logo.png') }}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('admin.index') }}" class="nav-link"> {{ trans('admin.bokit') }} </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            {{-- <li class="menu {{ Request::routeIs('admin.index') ? 'active' : '' }}">
                <a href="#dashboard" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.index') ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ Request::routeIs('admin.index') ? '' : 'collapsed' }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 33 32"
                            fill="#0E1726" fill-opacity=".6">
                            <path class="dash-icon"
                                d="M4.5 16C4.5 16.3536 4.64048 16.6928 4.89052 16.9428C5.14057 17.1929 5.47971 17.3333 5.83333 17.3333H13.8333C14.187 17.3333 14.5261 17.1929 14.7761 16.9428C15.0262 16.6928 15.1667 16.3536 15.1667 16V5.33333C15.1667 4.97971 15.0262 4.64057 14.7761 4.39052C14.5261 4.14048 14.187 4 13.8333 4H5.83333C5.47971 4 5.14057 4.14048 4.89052 4.39052C4.64048 4.64057 4.5 4.97971 4.5 5.33333V16ZM4.5 26.6667C4.5 27.0203 4.64048 27.3594 4.89052 27.6095C5.14057 27.8595 5.47971 28 5.83333 28H13.8333C14.187 28 14.5261 27.8595 14.7761 27.6095C15.0262 27.3594 15.1667 27.0203 15.1667 26.6667V21.3333C15.1667 20.9797 15.0262 20.6406 14.7761 20.3905C14.5261 20.1405 14.187 20 13.8333 20H5.83333C5.47971 20 5.14057 20.1405 4.89052 20.3905C4.64048 20.6406 4.5 20.9797 4.5 21.3333V26.6667ZM17.8333 26.6667C17.8333 27.0203 17.9738 27.3594 18.2239 27.6095C18.4739 27.8595 18.813 28 19.1667 28H27.1667C27.5203 28 27.8594 27.8595 28.1095 27.6095C28.3595 27.3594 28.5 27.0203 28.5 26.6667V16C28.5 15.6464 28.3595 15.3072 28.1095 15.0572C27.8594 14.8071 27.5203 14.6667 27.1667 14.6667H19.1667C18.813 14.6667 18.4739 14.8071 18.2239 15.0572C17.9738 15.3072 17.8333 15.6464 17.8333 16V26.6667ZM19.1667 4C18.813 4 18.4739 4.14048 18.2239 4.39052C17.9738 4.64057 17.8333 4.97971 17.8333 5.33333V10.6667C17.8333 11.0203 17.9738 11.3594 18.2239 11.6095C18.4739 11.8595 18.813 12 19.1667 12H27.1667C27.5203 12 27.8594 11.8595 28.1095 11.6095C28.3595 11.3594 28.5 11.0203 28.5 10.6667V5.33333C28.5 4.97971 28.3595 4.64057 28.1095 4.39052C27.8594 4.14048 27.5203 4 27.1667 4H19.1667Z"
                                fill="#0E1726" fill-opacity="0.6"></path>
                        </svg> <span>{{ trans('admin.dashboard') }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('admin.index') ? 'show' : '' }}"
                    id="dashboard" data-bs-parent="#accordionExample">
                    <li class="active">
                        <a href="{{ route('admin.index') }}"> {{ trans('admin.dashboard') }} </a>
                    </li>
                </ul>
            </li> --}}

            <li class="menu {{ Request::routeIs('admin.index') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}" aria-expanded="false" class="dropdown-toggle">

                    <div class="">

                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 33 32"
                            fill="#0E1726" fill-opacity=".6">
                            <path class="dash-icon"
                                d="M4.5 16C4.5 16.3536 4.64048 16.6928 4.89052 16.9428C5.14057 17.1929 5.47971 17.3333 5.83333 17.3333H13.8333C14.187 17.3333 14.5261 17.1929 14.7761 16.9428C15.0262 16.6928 15.1667 16.3536 15.1667 16V5.33333C15.1667 4.97971 15.0262 4.64057 14.7761 4.39052C14.5261 4.14048 14.187 4 13.8333 4H5.83333C5.47971 4 5.14057 4.14048 4.89052 4.39052C4.64048 4.64057 4.5 4.97971 4.5 5.33333V16ZM4.5 26.6667C4.5 27.0203 4.64048 27.3594 4.89052 27.6095C5.14057 27.8595 5.47971 28 5.83333 28H13.8333C14.187 28 14.5261 27.8595 14.7761 27.6095C15.0262 27.3594 15.1667 27.0203 15.1667 26.6667V21.3333C15.1667 20.9797 15.0262 20.6406 14.7761 20.3905C14.5261 20.1405 14.187 20 13.8333 20H5.83333C5.47971 20 5.14057 20.1405 4.89052 20.3905C4.64048 20.6406 4.5 20.9797 4.5 21.3333V26.6667ZM17.8333 26.6667C17.8333 27.0203 17.9738 27.3594 18.2239 27.6095C18.4739 27.8595 18.813 28 19.1667 28H27.1667C27.5203 28 27.8594 27.8595 28.1095 27.6095C28.3595 27.3594 28.5 27.0203 28.5 26.6667V16C28.5 15.6464 28.3595 15.3072 28.1095 15.0572C27.8594 14.8071 27.5203 14.6667 27.1667 14.6667H19.1667C18.813 14.6667 18.4739 14.8071 18.2239 15.0572C17.9738 15.3072 17.8333 15.6464 17.8333 16V26.6667ZM19.1667 4C18.813 4 18.4739 4.14048 18.2239 4.39052C17.9738 4.64057 17.8333 4.97971 17.8333 5.33333V10.6667C17.8333 11.0203 17.9738 11.3594 18.2239 11.6095C18.4739 11.8595 18.813 12 19.1667 12H27.1667C27.5203 12 27.8594 11.8595 28.1095 11.6095C28.3595 11.3594 28.5 11.0203 28.5 10.6667V5.33333C28.5 4.97971 28.3595 4.64057 28.1095 4.39052C27.8594 4.14048 27.5203 4 27.1667 4H19.1667Z"
                                fill="#0E1726" fill-opacity="0.6"></path>
                        </svg>
                        <span>{{ trans('admin.dashboard') }}</span>
                    </div>
                </a>
            </li>
            <li
                class="menu {{ Request::routeIs('admin.country.*') || Request::routeIs('admin.cities.*') || Request::routeIs('admin.areas.*') || Request::routeIs('admin.academies.locations') ? 'active' : '' }}">
                <a href="#address" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.country.*') || Request::routeIs('admin.cities.*') || Request::routeIs('admin.areas.*') || Request::routeIs('admin.academies.locations') ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ Request::routeIs('admin.country.*') || Request::routeIs('admin.city.*') || Request::routeIs('admin.area.*') ? '' : 'collapsed' }}">
                    <div class="">

                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="#0E1726">
                            <path
                                d="M7.49935 1.53516L12.561 4.48849L18.3327 2.08349V9.16682H16.666V4.58349L13.3327 5.97266V9.16682H11.666V5.89516L8.33268 3.95099V14.1052L9.88935 15.0135L9.04935 16.4527L7.43768 15.5118L1.66602 17.9168V4.93849L7.49935 1.53516ZM6.66602 14.0277V3.95099L3.33268 5.89516V15.4168L6.66602 14.0277ZM14.9993 11.6668C14.3916 11.6668 13.8087 11.9083 13.3789 12.338C12.9491 12.7678 12.7077 13.3507 12.7077 13.9585C12.7077 15.0018 13.3202 16.0035 14.0535 16.8102C14.3927 17.1835 14.7343 17.4885 14.9993 17.706C15.2643 17.4893 15.606 17.1835 15.9452 16.8102C16.6785 16.0035 17.291 15.0018 17.291 13.9585C17.291 13.3507 17.0496 12.7678 16.6198 12.338C16.19 11.9083 15.6071 11.6668 14.9993 11.6668ZM14.9993 19.751L14.5368 19.4435L14.5352 19.4427L14.5318 19.4402L14.5218 19.4335L14.4885 19.4102C14.3168 19.2891 14.1492 19.1624 13.986 19.0302C13.5705 18.6937 13.1808 18.3266 12.8202 17.9318C11.991 17.0202 11.041 15.626 11.041 13.9585C11.041 12.9087 11.4581 11.9019 12.2004 11.1595C12.9427 10.4172 13.9495 10.0002 14.9993 10.0002C16.0492 10.0002 17.056 10.4172 17.7983 11.1595C18.5406 11.9019 18.9577 12.9087 18.9577 13.9585C18.9577 15.626 18.0077 17.0202 17.1785 17.9318C16.6754 18.4814 16.1163 18.9768 15.5102 19.4102L15.4768 19.4335L15.4668 19.4402L15.4635 19.4427H15.4618L14.9993 19.751ZM13.9577 13.3335H16.041V15.0002H13.9577V13.3335Z"
                                fill="#0E1726"></path>
                        </svg> <span>{{ trans('admin.location_management') }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('admin.country.*') || Request::routeIs('admin.cities.*') || Request::routeIs('admin.areas.*') || Request::routeIs('admin.academies.locations') ? 'show' : '' }}"
                    id="address" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.country.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.country.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M57.7 193l9.4 16.4c8.3 14.5 21.9 25.2 38 29.8L163 255.7c17.2 4.9 29 20.6 29 38.5v39.9c0 11 6.2 21 16 25.9s16 14.9 16 25.9v39c0 15.6 14.9 26.9 29.9 22.6c16.1-4.6 28.6-17.5 32.7-33.8l2.8-11.2c4.2-16.9 15.2-31.4 30.3-40l8.1-4.6c15-8.5 24.2-24.5 24.2-41.7v-8.3c0-12.7-5.1-24.9-14.1-33.9l-3.9-3.9c-9-9-21.2-14.1-33.9-14.1H257c-11.1 0-22.1-2.9-31.8-8.4l-34.5-19.7c-4.3-2.5-7.6-6.5-9.2-11.2c-3.2-9.6 1.1-20 10.2-24.5l5.9-3c6.6-3.3 14.3-3.9 21.3-1.5l23.2 7.7c8.2 2.7 17.2-.4 21.9-7.5c4.7-7 4.2-16.3-1.2-22.8l-13.6-16.3c-10-12-9.9-29.5 .3-41.3l15.7-18.3c8.8-10.3 10.2-25 3.5-36.7l-2.4-4.2c-3.5-.2-6.9-.3-10.4-.3C163.1 48 84.4 108.9 57.7 193zM464 256c0-36.8-9.6-71.4-26.4-101.5L412 164.8c-15.7 6.3-23.8 23.8-18.5 39.8l16.9 50.7c3.5 10.4 12 18.3 22.6 20.9l29.1 7.3c1.2-9 1.8-18.2 1.8-27.5zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                                </svg><span>{{ trans('admin.country.country') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.cities.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.cities.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z" />
                                </svg>
                                <span>{{ trans('admin.city.city') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.areas.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.areas.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zM448 0c-17.7 0-32 14.3-32 32V512h64V192H624c8.8 0 16-7.2 16-16V48c0-8.8-7.2-16-16-16H480c0-17.7-14.3-32-32-32z" />
                                </svg>
                                <span>{{ trans('admin.area.area') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.academies.locations') ? 'active' : '' }}">
                        <a href="{{ route('admin.academies.locations') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zM448 0c-17.7 0-32 14.3-32 32V512h64V192H624c8.8 0 16-7.2 16-16V48c0-8.8-7.2-16-16-16H480c0-17.7-14.3-32-32-32z" />
                                </svg>
                                <span>{{ trans('admin.partner_location') }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu {{ Request::routeIs('admin.academies.index') || Request::routeIs('admin.academies.create') || Request::routeIs('admin.training.*') || Request::routeIs('admin.gallery.*') || Request::routeIs('admin.booking.*') ? 'active' : '' }}">
                <a href="#academy" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.academies.index') || Request::routeIs('admin.academies.create') || Request::routeIs('admin.training.*') || Request::routeIs('admin.gallery.*') || Request::routeIs('admin.booking.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">

                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 33 32" fill="#0E1726">
                            <path class="dash-icon" d="M12.67 24C12.8771 23.4149 13.2604 22.9084 13.7672 22.5501C14.274 22.1919 14.8794 21.9995 15.5 21.9995C16.1206 21.9995 16.726 22.1919 17.2328 22.5501C17.7396 22.9084 18.1229 23.4149 18.33 24H28.5V26H18.33C18.1229 26.585 17.7396 27.0916 17.2328 27.4498C16.726 27.808 16.1206 28.0004 15.5 28.0004C14.8794 28.0004 14.274 27.808 13.7672 27.4498C13.2604 27.0916 12.8771 26.585 12.67 26H4.5V24H12.67ZM18.67 15C18.8771 14.4149 19.2604 13.9084 19.7672 13.5501C20.274 13.1919 20.8794 12.9995 21.5 12.9995C22.1206 12.9995 22.726 13.1919 23.2328 13.5501C23.7396 13.9084 24.1229 14.4149 24.33 15H28.5V17H24.33C24.1229 17.585 23.7396 18.0916 23.2328 18.4498C22.726 18.808 22.1206 19.0004 21.5 19.0004C20.8794 19.0004 20.274 18.808 19.7672 18.4498C19.2604 18.0916 18.8771 17.585 18.67 17H4.5V15H18.67ZM8.67 5.99996C8.87706 5.41488 9.26037 4.90836 9.76718 4.55012C10.274 4.19187 10.8794 3.99951 11.5 3.99951C12.1206 3.99951 12.726 4.19187 13.2328 4.55012C13.7396 4.90836 14.1229 5.41488 14.33 5.99996H28.5V7.99996H14.33C14.1229 8.58504 13.7396 9.09156 13.2328 9.4498C12.726 9.80805 12.1206 10.0004 11.5 10.0004C10.8794 10.0004 10.274 9.80805 9.76718 9.4498C9.26037 9.09156 8.87706 8.58504 8.67 7.99996H4.5V5.99996H8.67Z" fill="#0E1726" fill-opacity="0.75"></path>
                        </svg>
                        <span>{{ trans('admin.partner_management') }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('admin.academies.index') || Request::routeIs('admin.academies.create') || Request::routeIs('admin.training.*') || Request::routeIs('admin.gallery.*') || Request::routeIs('admin.booking.*') ? 'show' : '' }}"
                    id="academy" data-bs-parent="#accordionExample">
                    <li
                        class="menu {{ Request::routeIs('admin.academies.index') || Request::routeIs('admin.academies.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.academies.index') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                                <span>{{ trans('admin.partner') }}</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('admin.training.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.training.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M96 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32V224v64V448c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V384H64c-17.7 0-32-14.3-32-32V288c-17.7 0-32-14.3-32-32s14.3-32 32-32V160c0-17.7 14.3-32 32-32H96V64zm448 0v64h32c17.7 0 32 14.3 32 32v64c17.7 0 32 14.3 32 32s-14.3 32-32 32v64c0 17.7-14.3 32-32 32H544v64c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32V288 224 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32zM416 224v64H224V224H416z" />
                                </svg> <span>{{ trans('admin.training.training') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.gallery.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M160 32c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160zM396 138.7l96 144c4.9 7.4 5.4 16.8 1.2 24.6S480.9 320 472 320H328 280 200c-9.2 0-17.6-5.3-21.6-13.6s-2.9-18.2 2.9-25.4l64-80c4.6-5.7 11.4-9 18.7-9s14.2 3.3 18.7 9l17.3 21.6 56-84C360.5 132 368 128 376 128s15.5 4 20 10.7zM192 128a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120z" />
                                </svg>
                                <span>{{ trans('admin.gallery.gallery') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.booking.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.booking.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                                </svg>
                                <span>{{ trans('admin.bookings.bookings') }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ Request::routeIs('admin.sport.*') ? 'active' : '' }}">
                <a href="#prefences" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.sport.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">

                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="#0E1726">
                            <path class="dash-icon" d="M11.1667 18.1998V9.33317C11.1667 8.95539 11.2947 8.63895 11.5507 8.38384C11.8067 8.12873 12.1231 8.00073 12.5 7.99984H13.8333C14.2111 7.99984 14.528 8.12784 14.784 8.38384C15.04 8.63984 15.1676 8.95628 15.1667 9.33317V18.1998L15 18.0332C14.4889 17.5443 13.8778 17.2998 13.1667 17.2998C12.4556 17.2998 11.8444 17.5443 11.3333 18.0332L11.1667 18.1998ZM17.8333 20.1998V3.99984C17.8333 3.62206 17.9613 3.30562 18.2173 3.0505C18.4733 2.79539 18.7898 2.66739 19.1667 2.6665H20.5C20.8778 2.6665 21.1947 2.7945 21.4507 3.0505C21.7067 3.3065 21.8342 3.62295 21.8333 3.99984V16.1998L17.8333 20.1998ZM4.5 24.7998V14.6665C4.5 14.2887 4.628 13.9723 4.884 13.7172C5.14 13.4621 5.45644 13.3341 5.83333 13.3332H7.16667C7.54444 13.3332 7.86133 13.4612 8.11733 13.7172C8.37333 13.9732 8.50089 14.2896 8.5 14.6665V20.7998L4.5 24.7998ZM7.7 28.0665C7.12222 28.0665 6.71644 27.7945 6.48267 27.2505C6.24889 26.7065 6.34356 26.2229 6.76667 25.7998L12.2333 20.3332C12.4778 20.0887 12.7724 19.9554 13.1173 19.9332C13.4622 19.9109 13.7676 20.0221 14.0333 20.2665L17.8333 23.5332L25.3 16.0665H24.5C24.1222 16.0665 23.8058 15.9385 23.5507 15.6825C23.2956 15.4265 23.1676 15.1101 23.1667 14.7332C23.1667 14.3554 23.2947 14.0389 23.5507 13.7838C23.8067 13.5287 24.1231 13.4007 24.5 13.3998H28.5C28.8778 13.3998 29.1947 13.5278 29.4507 13.7838C29.7067 14.0398 29.8342 14.3563 29.8333 14.7332V18.7332C29.8333 19.1109 29.7053 19.4278 29.4493 19.6838C29.1933 19.9398 28.8769 20.0674 28.5 20.0665C28.1222 20.0665 27.8058 19.9385 27.5507 19.6825C27.2956 19.4265 27.1676 19.1101 27.1667 18.7332V17.9332L18.8333 26.2665C18.5889 26.5109 18.2942 26.6443 17.9493 26.6665C17.6044 26.6887 17.2991 26.5776 17.0333 26.3332L13.2333 23.0665L8.63333 27.6665C8.52222 27.7776 8.38356 27.8723 8.21733 27.9505C8.05111 28.0287 7.87867 28.0674 7.7 28.0665Z" fill="black" fill-opacity="0.6"></path>
                        </svg>
                        <span>{{ trans('admin.preferences') }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('admin.sport.*') ? 'show' : '' }}"
                    id="prefences" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.sport.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sport.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M86.6 64l85.2 85.2C194.5 121.7 208 86.4 208 48c0-14.7-2-28.9-5.7-42.4C158.6 15 119 35.5 86.6 64zM64 86.6C35.5 119 15 158.6 5.6 202.3C19.1 206 33.3 208 48 208c38.4 0 73.7-13.5 101.3-36.1L64 86.6zM256 0c-7.3 0-14.6 .3-21.8 .9C238 16 240 31.8 240 48c0 47.3-17.1 90.5-45.4 124L256 233.4 425.4 64C380.2 24.2 320.9 0 256 0zM48 240c-16.2 0-32-2-47.1-5.8C.3 241.4 0 248.7 0 256c0 64.9 24.2 124.2 64 169.4L233.4 256 172 194.6C138.5 222.9 95.3 240 48 240zm463.1 37.8c.6-7.2 .9-14.5 .9-21.8c0-64.9-24.2-124.2-64-169.4L278.6 256 340 317.4c33.4-28.3 76.7-45.4 124-45.4c16.2 0 32 2 47.1 5.8zm-4.7 31.9C492.9 306 478.7 304 464 304c-38.4 0-73.7 13.5-101.3 36.1L448 425.4c28.5-32.3 49.1-71.9 58.4-115.7zM340.1 362.7C317.5 390.3 304 425.6 304 464c0 14.7 2 28.9 5.7 42.4C353.4 497 393 476.5 425.4 448l-85.2-85.2zM317.4 340L256 278.6 86.6 448c45.1 39.8 104.4 64 169.4 64c7.3 0 14.6-.3 21.8-.9C274 496 272 480.2 272 464c0-47.3 17.1-90.5 45.4-124z" />
                                </svg>
                                <span>{{ trans('admin.sport.sport') }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu {{ Request::routeIs('admin.offline.create') ? 'active' : '' }}">
                <a href="{{ route('admin.offline.create') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z" />
                        </svg>
                        <span>{{ trans('admin.bookings.add_new_booking') }}</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.faq.*') ? 'active' : '' }}">
                <a href="{{ route('admin.faq.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">

                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="#0E1726">
                            <path class="dash-icon" d="M15.9974 2.6665C23.3614 2.6665 29.3307 8.63584 29.3307 15.9998C29.3307 23.3638 23.3614 29.3332 15.9974 29.3332C13.8404 29.336 11.7151 28.8134 9.80541 27.8105L4.08541 29.2998C3.89428 29.3496 3.69347 29.3486 3.50286 29.2968C3.31226 29.2451 3.13848 29.1445 2.99876 29.0049C2.85904 28.8653 2.75822 28.6916 2.7063 28.501C2.65437 28.3105 2.65315 28.1097 2.70274 27.9185L4.19074 22.1998C3.18519 20.2881 2.66116 18.1599 2.66407 15.9998C2.66407 8.63584 8.63341 2.6665 15.9974 2.6665ZM17.6667 17.3332H11.6641L11.5281 17.3425C11.2887 17.3754 11.0694 17.4939 10.9106 17.676C10.7519 17.8581 10.6644 18.0916 10.6644 18.3332C10.6644 18.5748 10.7519 18.8082 10.9106 18.9903C11.0694 19.1724 11.2887 19.2909 11.5281 19.3238L11.6641 19.3332H17.6667L17.8014 19.3238C18.0408 19.2909 18.2601 19.1724 18.4189 18.9903C18.5776 18.8082 18.6651 18.5748 18.6651 18.3332C18.6651 18.0916 18.5776 17.8581 18.4189 17.676C18.2601 17.4939 18.0408 17.3754 17.8014 17.3425L17.6667 17.3332ZM20.3307 12.6665H11.6641L11.5281 12.6758C11.2887 12.7088 11.0694 12.8272 10.9106 13.0094C10.7519 13.1915 10.6644 13.4249 10.6644 13.6665C10.6644 13.9081 10.7519 14.1415 10.9106 14.3237C11.0694 14.5058 11.2887 14.6242 11.5281 14.6572L11.6641 14.6665H20.3307L20.4667 14.6572C20.7061 14.6242 20.9254 14.5058 21.0842 14.3237C21.243 14.1415 21.3304 13.9081 21.3304 13.6665C21.3304 13.4249 21.243 13.1915 21.0842 13.0094C20.9254 12.8272 20.7061 12.7088 20.4667 12.6758L20.3307 12.6665Z" fill="#0E1726" fill-opacity="0.6"></path>
                        </svg>
                        <span>{{ trans('admin.faq.faq') }}</span>
                    </div>
                </a>
            </li>

            {{--            <li class="menu {{ Request::routeIs('admin.academies.coaches') ? 'active' : '' }}"> --}}
            {{--                <a href="{{ route('admin.academies.coaches') }}" aria-expanded="false" class="dropdown-toggle"> --}}
            {{--                    <div class=""> --}}
            {{--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>                        <span>{{ trans('admin.coaches.coaches') }}</span> --}}
            {{--                    </div> --}}
            {{--                </a> --}}
            {{--            </li> --}}
            <li class="menu {{ Request::routeIs('admin.banners.*') ? 'active' : '' }}">
                <a href="{{ route('admin.banners.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="#0E1726">
                            <path d="M16.6673 17.3332H15.0006V13.1665H16.6673M5.00065 17.3332H3.33398V13.1665H5.00065M19.1673 2.33317V9.83317C19.1673 10.2752 18.9917 10.6991 18.6792 11.0117C18.3666 11.3242 17.9427 11.4998 17.5006 11.4998H2.50065C2.05862 11.4998 1.6347 11.3242 1.32214 11.0117C1.00958 10.6991 0.833984 10.2752 0.833984 9.83317V2.33317C0.833984 1.89114 1.00958 1.46722 1.32214 1.15466C1.6347 0.842099 2.05862 0.666504 2.50065 0.666504H17.5006C17.9427 0.666504 18.3666 0.842099 18.6792 1.15466C18.9917 1.46722 19.1673 1.89114 19.1673 2.33317ZM17.5006 2.33317H2.50065V9.83317H17.5006M16.6673 3.99984H12.5007V5.6665H16.6673M15.0006 6.49984H12.5007V8.1665H15.0006M11.6673 8.1665H3.33398L5.60898 5.13317L7.27565 7.40817L7.88398 6.95817L6.83398 5.5165L8.25898 3.62484L11.6673 8.1665Z" fill="#0E1726"></path>
                        </svg>
                        <span>{{ trans('admin.banners.banners') }}</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::routeIs('admin.user.*') ? 'active' : '' }}">
                <a href="{{ route('admin.user.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <img src="{{ asset('assetsAdmin/people-fill.svg') }}" alt="">
                        <span>{{ trans('admin.user.user') }}</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.setting.*') ? 'active' : '' }}">
                <a href="{{ route('admin.setting.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <img src="{{ asset('assetsAdmin/card-checklist.svg') }}" alt="">
                        <span>{{ trans('admin.setting.setting') }}</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::routeIs('admin.notification.*') ? 'active' : '' }}">
                <a href="{{ route('admin.notification.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <img src="{{ asset('assetsAdmin/card-checklist.svg') }}" alt="">
                        <span>{{trans("admin.notification.notification")}}</span>
                    </div>
                </a>
            </li>


            <li class="menu {{ Request::routeIs('admin.report.*') ? 'active' : '' }}">
                <a href="#report" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.report.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle {{ Request::routeIs('admin.report.*') ? '' : 'collapsed' }}">
                    <div class="">
                        <svg fill-opacity=".6" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 33 32" fill="#0E1726">
                            <path d="M8.5 9.3335H19.1667V12.0002H8.5V9.3335ZM8.5 14.6668H24.5V17.3335H8.5V14.6668ZM8.5 20.0002H12.4867V22.6668H8.5V20.0002Z" fill="#0E1726" fill-opacity="0.75"></path>
                            <path class="dash-icon" d="M19.1667 4L15.1667 0V2.66667H5.83341C5.12617 2.66667 4.44789 2.94762 3.9478 3.44772C3.4477 3.94781 3.16675 4.62609 3.16675 5.33333V26.6667C3.16675 27.3739 3.4477 28.0522 3.9478 28.5523C4.44789 29.0524 5.12617 29.3333 5.83341 29.3333H11.1667V26.6667H5.83341V5.33333H15.1667V8L19.1667 4ZM13.8334 28L17.8334 32V29.3333H27.1667C27.874 29.3333 28.5523 29.0524 29.0524 28.5523C29.5525 28.0522 29.8334 27.3739 29.8334 26.6667V5.33333C29.8334 4.62609 29.5525 3.94781 29.0524 3.44772C28.5523 2.94762 27.874 2.66667 27.1667 2.66667H21.8334V5.33333H27.1667V26.6667H17.8334V24L13.8334 28Z" fill="#0E1726" fill-opacity="0.75"></path>
                        </svg>
                        <span>{{ trans('admin.report') }}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="#0E1726" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('admin.report.*') ? 'show' : '' }}"
                    id="report" data-bs-parent="#accordionExample">
                    <li class="menu {{ Request::routeIs('admin.report.settlement') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.settlement') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <img src="{{ asset('assetsAdmin/card-checklist.svg') }}" alt="">
                                <span>{{ trans('admin.settlement') }}</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('admin.report.transactions') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.transactions') }}" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64H337.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64zm64 64H96v64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64h64V320zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z" />
                                </svg>
                                <span>{{ trans('admin.transaction') }}</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu {{ Request::routeIs('admin.report.joins') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.joins') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <img src="{{ asset('assetsAdmin/person-arms-up.svg') }}" alt="">
                                <span>{{ trans('admin.bookings.bookings') }}</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('admin.report.coach') ? 'active' : '' }}">
                        <a href="{{ route('admin.report.coach') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z" />
                                </svg>
                                <span>{{ trans('admin.Coaches') }}</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
