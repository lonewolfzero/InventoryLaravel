<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('business.name', config('app.name')) }} | {{ $title ?? '' }}@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/template.css') }}">
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    @toastr_css

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/pcoded.min.js') }}"></script>
    <script src="{{ asset('js/vartical-demo.js') }}"></script>

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('uploads/' . config('business')->icon   ) }}" type="image/x-icon">

</head>
<body>
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <div id="app">
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            @auth 
                @if ( (isset($title) && $title != 'Locked') || !isset($title) )
                    <div class="pcoded-container navbar-wrapper">
                        <nav class="navbar header-navbar pcoded-header">
                            <div class="navbar-wrapper">

                                <div class="navbar-container">
                                    <div class="navbar-logo pull-left">
                                        <a class="mobile-menu" id="mobile-collapse" href="#">
                                            <i class="ti-menu"></i>
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="mx-auto">
                                            <img class="img-fluid" style="max-height: 45px; max-width: 200px;" src="{{ asset('uploads/' . config('business')->logo) }}" alt="Theme-Logo" />
                                        </a>
                                        <a class="mobile-options">
                                            <i class="ti-more"></i>
                                        </a>
                                    </div>
                                    <ul class="nav-left" class="mx-auto">
                                        <li class="pull-left pt-2"><span class="pt-1" style="color: white; font-weight: bold;">{{ config('business.name', config('app.name')) }}</span></li>
                                    </ul>
                                    <ul class="nav-right">
                                        <li>
                                            <a href="#" onclick="javascript:toggleFullScreen()">
                                                <i class="ti-fullscreen"></i>
                                            </a>
                                        </li>
                                        {{-- <li class="header-notification">
                                            <a href="#">
                                                <i class="ti-bell"></i>
                                                <span class="badge bg-c-pink"></span>
                                            </a>
                                            <ul class="show-notification">
                                                <li>
                                                    <h6>Notifications</h6>
                                                    <label class="label label-danger">New</label>
                                                </li>
                                                <li>
                                                    <div class="media">
                                                        <img class="d-flex align-self-center img-radius" src="assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                                        <div class="media-body">
                                                            <h5 class="notification-user">John Doe</h5>
                                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                            <span class="notification-time">30 minutes ago</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li> --}}
                                        
                                        <li class="user-profile header-notification">
                                            <a href="#">
                                                <img src="{{ asset('uploads/profile/' . ( !is_null(auth()->user()->profile_photo ) ? auth()->user()->profile_photo : 'default-avatar.png' )) }}" class="img-radius" alt="{{ Auth::user()->name }}">
                                                <span>{{ Auth::user()->name }} </span>
                                                <i class="ti-angle-down"></i>
                                            </a>
                                            <ul class="show-notification profile-notification">
                                                <li> 
                                                    <a href="{{ route('profile') }}"> 
                                                        <i class="ti-user"></i> {{ __('Profile') }} 
                                                    </a> 
                                                </li> 
                                                <li> 
                                                    <a href="{{ route('lock') }}"> 
                                                        <i class="ti-lock"></i> {{ __('Lock Screen') }} 
                                                    </a> 
                                                </li>

                                                <li>
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="ti-layout-sidebar-left"></i> {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"   onsubmit="return checkBeforeSubmit()" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <div class="pcoded-main-container">
                            <div class="pcoded-wrapper">
                                <nav class="pcoded-navbar">
                                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                                    <div class="pcoded-inner-navbar main-menu">
                                        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">{{ __('Layout') }}</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="{{ ( request()->segment(1) == 'dashboard' ) ? 'active' : '' }}">
                                                <a href="{{ route('dashboard') }}">
                                                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Dashboard') }}</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        </ul>

                                        @canany(['barang.index', 'kategori.index', 'satuan.index', 'gudang.index', 'rak.index', 'penyimpanan.index', 'rekanan.index', 'satuan_pemakai.index'])
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="pcoded-hasmenu 
                                                    {{ ( ( (request()->segment(1) == 'barang') || (request()->segment(1) == 'kategori') ) 
                                                        || (request()->segment(1) == 'satuan') || ( (request()->segment(1) == 'gudang') || (request()->segment(1) == 'rak') 
                                                        || (request()->segment(1) == 'penyimpanan') ) || ((request()->segment(1) == 'rekanan') 
                                                        || (request()->segment(1) == 'satuan_pemakai')) ) ? 'active pcoded-trigger' : '' }}
                                                ">
                                                    <a href="javascript:void(0)">
                                                        <span class="pcoded-micon"><i class="ti-server"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">{{ __('Master Data') }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                    <ul class="pcoded-submenu">
                                                        @canany(['barang.index', 'kategori.index', 'satuan.index'])
                                                            <li class="pcoded-hasmenu {{ ( ( (request()->segment(1) == 'barang') || (request()->segment(1) == 'kategori') ) 
                                                                || (request()->segment(1) == 'satuan') ) ? 'active pcoded-trigger' : '' }}">
                                                                <a href="javascript:void(0)">
                                                                    <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">{{ __('Bekal') }}</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                                <ul class="pcoded-submenu">
                                                                    @can('barang.index')
                                                                        <li class="{{ ( request()->segment(1) == 'barang' ) ? 'active' : '' }}">
                                                                            <a href="{{ route('barang.index') }}">
                                                                                <span class="pcoded-mtext">{{ __('Bekal') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('kategori.index')
                                                                    <li class="{{ ( request()->segment(1) == 'kategori' ) ? 'active' : '' }}">
                                                                        <a href="{{ route('kategori.index') }}">
                                                                            <span class="pcoded-mtext">{{ __('Kategori') }}</span>
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                    @can('satuan.index')
                                                                    <li class="{{ ( request()->segment(1) == 'satuan' ) ? 'active' : '' }}">
                                                                        <a href="{{ route('satuan.index') }}">
                                                                            <span class="pcoded-mtext">{{ __('Satuan') }}</span>
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                </ul>
                                                            </li>
                                                        @endcanany
                                                        <li class="pcoded-hasmenu d-none">
                                                        </li>
                                                        @canany(['gudang.index', 'rak.index', 'penyimpanan.index'])
                                                            <li class="pcoded-hasmenu {{ ( ( (request()->segment(1) == 'gudang') || (request()->segment(1) == 'rak') ) 
                                                                || (request()->segment(1) == 'penyimpanan') ) ? 'active pcoded-trigger' : '' }}">
                                                                <a href="javascript:void(0)">
                                                                    <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-23.main">{{ __('Gudang') }}</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                                <ul class="pcoded-submenu">
                                                                    @can('gudang.index')
                                                                        <li class="{{ ( request()->segment(1) == 'gudang' ) ? 'active' : '' }}">
                                                                            <a href="{{ route('gudang.index') }}">
                                                                                <span class="pcoded-mtext">{{ __('Gudang') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('rak.index')
                                                                        <li class="{{ ( request()->segment(1) == 'rak' ) ? 'active' : '' }}">
                                                                            <a href="{{ route('rak.index') }}">
                                                                                <span class="pcoded-mtext">{{ __('Rak') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                    @can('penyimpanan.index')
                                                                        <li class="{{ ( request()->segment(1) == 'penyimpanan' ) ? 'active' : '' }}">
                                                                            <a href="{{ route('penyimpanan.index') }}">
                                                                                <span class="pcoded-mtext">{{ __('Penyimpanan') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endcan
                                                                </ul>
                                                            </li>
                                                        @endcanany
                                                        @can('rekanan.index')
                                                            <li class="{{ ( request()->segment(1) == 'rekanan' ) ? 'active' : '' }}">
                                                                <a href="{{ route('rekanan.index') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Mitra') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('satuan_pemakai.index')
                                                            <li class="{{ ( request()->segment(1) == 'satuan_pemakai' ) ? 'active' : '' }}">
                                                                <a href="{{ route('satuan_pemakai.index') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Satuan Pemakai') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endcanany

                                        @can('barang_masuk.index')
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="{{ ( request()->segment(1) == 'barang_masuk' ) ? 'active' : '' }}">
                                                    <a href="{{ route('barang_masuk.index') }}">
                                                        <span class="pcoded-micon"><i class="ti-import"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Bekal Masuk') }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endcan
                                        @can('barang_keluar.index')
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="{{ ( request()->segment(1) == 'barang_keluar' ) ? 'active' : '' }}">
                                                    <a href="{{ route('barang_keluar.index') }}">
                                                        <span class="pcoded-micon"><i class="ti-export"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Bekal Keluar') }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endcan
                                        @can('stock_opname.index')
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="{{ ( request()->segment(1) == 'stock_opname' ) ? 'active' : '' }}">
                                                    <a href="{{ route('stock_opname.index') }}">
                                                        <span class="pcoded-micon"><i class="ti-package"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Stock Opname') }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endcan

                                        @canany(['report.stock', 'report.laporan_bulanan', 'report.nota_dinas', 'report.barang_masuk', 'report.barang_keluar'])
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="pcoded-hasmenu 
                                                    {{ ( (request()->segment(1) == 'report') && ( (request()->segment(2) == 'stock') || ((request()->segment(2) == 'laporan_bulanan') || (request()->segment(2) == 'nota_dinas')) || ((request()->segment(2) == 'barang_masuk') || (request()->segment(2) == 'barang_keluar')) ) ) ? 'active pcoded-trigger' : '' }}
                                                ">
                                                    <a href="javascript:void(0)">
                                                        <span class="pcoded-micon"><i class="ti-printer"></i></span>
                                                        <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">{{ __('Report') }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                    <ul class="pcoded-submenu">
                                                        @can('report.stock')
                                                            <li class="{{ ( request()->segment(1) == 'report' && request()->segment(2) == 'stock' ) ? 'active' : '' }}">
                                                                <a href="{{ route('report.stock') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Stock') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('report.laporan_bulanan')
                                                            <li class="{{ ( request()->segment(1) == 'report' && request()->segment(2) == 'laporan_bulanan' ) ? 'active' : '' }}">
                                                                <a href="{{ route('report.laporan_bulanan') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Laporan Bulanan') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('report.nota_dinas')
                                                            <li class="{{ ( request()->segment(1) == 'report' && request()->segment(2) == 'nota_dinas' ) ? 'active' : '' }}">
                                                                <a href="{{ route('report.nota_dinas') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Nota Dinas') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('report.barang_masuk')
                                                            <li class="{{ ( request()->segment(1) == 'report' && request()->segment(2) == 'barang_masuk' ) ? 'active' : '' }}">
                                                                <a href="{{ route('report.barang_masuk') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Bekal Masuk') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('report.barang_keluar')
                                                            <li class="{{ ( request()->segment(1) == 'report' && request()->segment(2) == 'barang_keluar' ) ? 'active' : '' }}">
                                                                <a href="{{ route('report.barang_keluar') }}">
                                                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ __('Bekal Keluar') }}</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endcanany

                                        @canany(['users.index', 'roles.index', 'business.profile', 'business.locations'])
                                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other" style="text-transform:none;">{{ __('Settings') }}</div>
                                            @canany(['users.index', 'roles.index',])
                                                <ul class="pcoded-item pcoded-left-item">
                                                    <li class="pcoded-hasmenu 
                                                        {{ ( ( (request()->segment(1) == 'users') || (request()->segment(1) == 'roles') ) 
                                                            || (request()->segment(1) == 'permissions') ) ? 'active pcoded-trigger' : '' }}
                                                    ">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="ti-settings"></i></span>
                                                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">{{ __('Manage Users') }}</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                        <ul class="pcoded-submenu">
                                                            @can('users.index')
                                                            <li class="{{ ( request()->segment(1) == 'users' ) ? 'active' : '' }}">
                                                                <a href="{{ route('user.index') }}">
                                                                    <span class="pcoded-mtext">{{ __('Users') }}</span>
                                                                </a>
                                                            </li>
                                                            @endcan
                                                            @can('roles.index')
                                                            <li class="{{ ( request()->segment(1) == 'roles' ) ? 'active' : '' }}">
                                                                <a href="{{ route('role.index') }}">
                                                                    <span class="pcoded-mtext">{{ __('Role & Permissions') }}</span>
                                                                </a>
                                                            </li>
                                                            @endcan
                                                        </ul>
                                                    </li>
                                                </ul>
                                            @endcanany
                                            @canany(['business.profile', 'business.locations',])
                                                <ul class="pcoded-item pcoded-left-item">
                                                    <li class="pcoded-hasmenu 
                                                        {{ ( ( (request()->segment(1) == 'business') || (request()->segment(2) == 'settings') ) 
                                                            || (request()->segment(2) == 'locations') ) ? 'active pcoded-trigger' : '' }}
                                                    ">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="ti-settings"></i></span>
                                                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">{{ __('Business Settings') }}</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                        <ul class="pcoded-submenu">
                                                            @can('business.profile')
                                                            <li class="{{ ( request()->segment(1) == 'business' && request()->segment(2) == 'profile' ) ? 'active' : '' }}">
                                                                <a href="{{ route('business.profile') }}">
                                                                    <span class="pcoded-mtext">{{ __('Bussines Profile') }}</span>
                                                                </a>
                                                            </li>
                                                            @endcan
                                                            {{-- @can('business.locations')
                                                            <li class="{{ ( request()->segment(1) == 'business' && request()->segment(2) == 'locations' ) ? 'active' : '' }}">
                                                                <a href="{{ route('business.locations') }}">
                                                                    <span class="pcoded-mtext">{{ __('Bussines Locations') }}</span>
                                                                </a>
                                                            </li>
                                                            @endcan --}}
                                                        </ul>
                                                    </li>
                                                </ul>
                                            @endcanany
                                        @endcanany

                                        <!-- li.pcoded-hasmenu active pcoded-trigger -->
                                        <!-- li.active -->

                                        {{-- <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other">Other</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="pcoded-hasmenu ">
                                                <a href="javascript:void(0)">
                                                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>M</b></span>
                                                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Menu Levels</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <li class="">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Menu Level 2.1</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                    <li class="pcoded-hasmenu ">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Menu Level 2.2</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                        <ul class="pcoded-submenu">
                                                            <li class="">
                                                                <a href="javascript:void(0)">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Menu Level 3.1</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-23">Menu Level 2.3</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
            
                                                </ul>
                                            </li>
                                        </ul> --}}

                                    </div>
                                </nav>
                                <div class="pcoded-content">
                                    <div class="pcoded-inner-content">
                                        <main>
                                            @yield('content')
                                        </main>
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="pcoded-content fixed-bottom" style="background-color: #4099ff; position: absolute;">
                                    <div class="pcoded-inner-content p-0">
                                        <div class="main-body">
                                            <div class="page-wrapper p-3">
                                                <div class="page-body text-center text-white">
                                                    © {{ date("Y") }} Copyright:
                                                    <a class="text-reset fw-bold" href="#">GUPUSBEKANG-1 PUSBEKANGAD</a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="text-center p-3 text-white" style="background-color: #4099ff; position: fixed; bottom:0; width:100%;"> --}}
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            @if ( isset($title) && $title == 'Locked' )
                <main>
                    @yield('content')
                </main>
            @endif
            @guest
                <main>
                    @yield('content')
                </main>
            @endguest
        </div>
    </div>


    @stack('scripts')
    @toastr_js
    @toastr_render
    
</body>
</html>
