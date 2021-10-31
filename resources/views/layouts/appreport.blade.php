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
                                        
                                        
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <div class="pcoded-main-container">
                            <div class="pcoded-wrapper">
                                <nav class="pcoded-navbar">
                                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                                    <div class="pcoded-inner-navbar main-menu">
                                        
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
