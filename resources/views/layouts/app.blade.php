<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #1a2638;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Toko Online

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" style="background-color: #1a2638;" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                            @if(!auth()->guard('seller')->user() && !auth()->guard('buyer')->user())
                                <a href="{{ route('loginIndexBuyer') }}" class="nav-link">Login as buyer</a>
                                <a href="{{ route('loginIndexSeller') }}" class="nav-link">Login as seller or as staff</a>
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(auth()->guard('seller')->user())
                                    <i class="fas fa-user-tie"></i> {{ auth()->guard('seller')->user()->name }}
                                    @else
                                    <i class="fas fa-user"></i> {{ auth()->guard('buyer')->user()->name }}
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(auth()->guard('seller')->user())
                                        <a href="/seller/product" class="dropdown-item"><i class="fas fa-box"></i> Product</a>
                                        @if(auth()->guard('seller')->user()->type_seller == 'admin')
                                            <a href="/seller/staff" class="dropdown-item"><i class="fas fa-users"></i> Staff</a>
                                        @endif
                                        <a href="/seller/order" class="dropdown-item"><i class="fas fa-people-carry"></i> Order</a>
                                        <a href="/seller/category" class="dropdown-item"><i class="fas fa-archive"></i> Category</a>
                                        <a href="/seller/bank" class="dropdown-item"><i class="fas fa-university"></i> Bank</a>
                                        <a class="dropdown-item" href="{{ route('sellerLogout') }}"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                    @endif

                                    @if(auth()->guard('buyer')->user())
                                        <a href="/buyer/cart" class="dropdown-item">
                                            <span class="badge badge-success badge-pill" style="color : white; padding-: 2px 6px;">
                                            @if(Session::get('cart') == null)
                                                0
                                            @else
                                                {{ count(Session::get('cart')) }}
                                            @endif
                                            
                                        </span>
                                            Cart
                                        </a>
                                        <a href="/buyer/profile" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
                                        <a href="/buyer/order" class="dropdown-item"><i class="fas fa-people-carry"></i> Order</a>
                                        <a class="dropdown-item" href="{{ route('buyerLogout') }}"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                    @endif
                                </div>
                            </li>
                            @endif
                        
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script type="text/javascript" src="{{ asset('fontawesome/js/all.js') }}"></script>
@stack('javascript')
<script type="text/javascript">
    function number_rupiah(angka){
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan  = reverse.match(/\d{1,3}/g);
            ribuan  = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>
</html>
