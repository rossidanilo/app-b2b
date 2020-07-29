<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>H30 App</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/Chart.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b81389c34e.js" crossorigin="anonymous"></script>
    @laravelPWA

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Web Application Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="#000000">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="PWA">
    <link rel="icon" sizes="512x512" href="/img/logo-h30-med.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="PWA">
    <link rel="apple-touch-icon" href="/img/logo-h30-med.png">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top py-0">
            <div class="container row" id="grid-nav-bar">
                <div class="ml-3" id="first-column-nav-bar">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </div>
                <div class="text-right" id="second-column-nav-bar">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo-h30.jpg" style="width:35%" alt="logo-h30">
                </a>
                </div>
                 <div id="nav-bar-cart">
                <a class="btn-link" href="/cart">
                    <i class="fa fa-shopping-cart"></i>
                </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            @if(Auth::user()->admin)
                            <li class="nav-item">

                            <div>
                                
                                <a  class="btn btn-link" href="/admin">
                                     
                                    <i class="fa fa-cog"></i> ADMIN

                                </a>

                            </div>
                            </li>
                            @endif
                            <li class="nav-item">

                                <div>
                                
                                <a  class="btn btn-link" href="/admin/products">
                                    
                                    <i class="fa fa-screwdriver"></i> LISTADO DE PRODUCTOS

                                </a>
                                    
                                </div>

                            </li> 
                            <li class="nav-item">

                                <div>
                                
                                <a  class="btn btn-link" href="/admin/orders">
                                    
                                   <i class="fa fa-receipt"></i> LISTADO DE PEDIDOS

                                </a>
                                    
                                </div>

                            </li>
                            <li class="nav-item">

                                <div>
                                
                                <a  class="btn btn-link" href="/admin/obras">
                                    
                                    <i class="fa fa-building"></i> OBRAS TOTALES

                                </a>

                            </li>
                            <li class="nav-item">

                                <div>
                                
                                <a  class="btn btn-link" href="/obras">
                                    
                                    <i class="fa fa-home"></i> HOME

                                </a>

                            </li>

                             <li class="nav-item">

                                <div>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf

                                    <input type="submit" class="btn btn-link" value="CERRAR SESION">

                                </form>

                            </div>

                            </li>


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="margin-top: 6rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-left">
                        <a href="javascript:history.back()" class="btn btn-secondary back-btn">VOLVER</a>
                    </div>
                </div>
            </div>
        </div><br>
            @yield('content')
        </main>
    </div>
    <script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '/' 
        }).then(function (registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>

<script type="text/javascript">
    
    $(document).click(function (event) {
    var clickover = $(event.target);
    var $navbar = $("#navbarSupportedContent");               
    var _opened = $navbar.hasClass("show");
    if (_opened === true && !clickover.hasClass("navbar-collapse")) {      
        $navbar.collapse('hide');
    }
});

</script>
</body>
</html>
