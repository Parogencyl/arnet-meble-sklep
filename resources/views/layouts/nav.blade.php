<?php

    $menu = DB::table('menu_category')->orderby('typ', 'asc')->get();

    $agent = new \Jenssegers\Agent\Agent;

    $favoritesNumber = $cartNumber = 0;

    if (Auth::user()) {
        $favorites = DB::table('users_favorite')->where('user_id', Auth::user()->id)->get();
        $cart = DB::table('cart')->where('user_id', Auth::user()->id)->get();
        $favoritesNumber = count($favorites);
        $cartNumber = count($cart);
    } else {
        if(session()->has('favorites')){
            $favoritesNumber = count(session()->get('favorites'));
        }
        if (session()->has('cart')) {
            $cartNumber = count(session()->get('cart'));
        }
    }

?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Damian Bohonos" />
    <meta name="copyright" content="Copyright owner" />
    <meta name="robots" content="follow" />
    <meta name="keywords"
        content="Arnet, meble, szafka, szafka nocna, meble na wymiar, na wymiar, meble składane, półka" />
    <meta name="description" content="Firma Arnet funkcjonuje od 2000 roku. Przedmiotem naszej działalności jest projektowanie, wykonawstwo i montaż
    mebli kuchennych i innych. Firma szczególnie specjalizuje się w wyposażaniu w meble i sprzęt kuchni o nietypowych kształtach, otwartych na
    salon lub jadalnię oraz ekstremalnie małych, gdzie szczególnego znaczenia nabiera wykorzystanie powierzchni." />


    <meta name="google-site-verification" content="nOVqvbZcLjftXraEtkKMdGdiknr5ESkr4O3ykQOKO5o" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Arnet meble </title>

    <link rel="icon" href="{{ asset('graphics/logo.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm nav1" style="background-color: black">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('graphics/logo.png') }}" alt="logo" style="height: 100px;">
                </a>

                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto ul1 row">
                    @guest
                    <li class="nav-item col">
                        <a class="nav-link text-center" href="{{ route('client/login') }}"> <i class="fas fa-user"
                                style="font-size: 40px"></i> </a>
                    </li>

                    <li class="nav-item col">
                        <a class="nav-link text-center" href="{{ url('ulubione') }}"> <i class="fas fa-heart"
                                style="font-size: 40px"></i>
                            @if ($favoritesNumber)
                            <span class="badge bg-danger"> {{ $favoritesNumber }} </span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item col">
                        <a class="nav-link text-center" href="{{ url('koszyk') }}"> <i class="fas fa-shopping-basket"
                                style="font-size: 40px"></i>
                            @if ($cartNumber)
                            <span class="badge bg-danger"> {{ $cartNumber }} </span>
                            @endif
                        </a>
                    </li>
                    @else
                    <li class="nav-item dropdown col">

                        <a id="navbarDropdown" class="nav-link text-center dropdown-toggle" href="#"
                            data-toggle="dropdown"> <i class="fas fa-user" style="font-size: 40px;"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 1100"
                            aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-dark text-center" href="{{ url('/moje_konto/zarzadzanie') }}">
                                Panel użytkownika
                            </a>
                            <hr class="m-0 p-0 my-1">
                            <a class="dropdown-item text-dark text-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Wyloguj
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    <li class="nav-item col">
                        <a class="nav-link text-center" href="{{ url('ulubione') }}"> <i class="fas fa-heart"
                                style="font-size: 40px"></i>
                            @if ($favoritesNumber)
                            <span class="badge bg-danger"> {{ $favoritesNumber }} </span>
                            @endif
                        </a>

                    </li>

                    <li class="nav-item col">
                        <a class="nav-link text-center" href="{{ url('koszyk') }}"> <i class="fas fa-shopping-basket"
                                style="font-size: 40px"></i>
                            @if ($cartNumber)
                            <span class="badge bg-danger"> {{ $cartNumber }} </span>
                            @endif
                        </a>
                    </li>

                    @endguest

                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-md navbar-light bg-white py-0 sticky-top categoryMenu">
            <div class="container">
                <button class="navbar-toggler my-3" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav m-auto">

                        @if($agent->isMobile() || $agent->isTablet())
                        <li class="nav-item py-2 px-3" id="furnitureLi">
                            <a class="nav-link font-weight-bold text-dark">
                                Meble
                            </a>
                        </li>
                        @else
                        <li class="nav-item py-2 px-3" id="furnitureLi"> <a href="{{ url('/produkty/meble') }}"
                                class="nav-link font-weight-bold text-dark">
                                Meble
                            </a> </li>

                        @endif

                        @if($agent->isMobile() || $agent->isTablet())
                        <li class="nav-item py-2 px-3 text-md-center text-left" id="equipmentLi"> <a
                                class="nav-link font-weight-bold text-dark">
                                Sprzęt AGD
                            </a> </li>
                        @else
                        <li class="nav-item py-2 px-3 text-md-center text-leftr" id="equipmentLi"> <a
                                href="{{ url('/produkty/sprzet') }}" class="nav-link font-weight-bold text-dark">
                                Sprzęt AGD
                            </a> </li>
                        @endif

                        @if($agent->isMobile() || $agent->isTablet())
                        <li class="nav-item py-2 px-3" id="accessoriesLi"> <a
                                class="nav-link font-weight-bold text-dark">
                                Akcesoria
                            </a> </li>
                        @else
                        <li class="nav-item py-2 px-3" id="accessoriesLi"> <a href="{{ url('/produkty/akcesoria') }}"
                                class="nav-link font-weight-bold text-dark">
                                Akcesoria
                            </a> </li>
                        @endif

                        <li class="nav-item py-2 px-3"> <a href="{{ url('realizacje') }}"
                                class="nav-link font-weight-bold text-dark">
                                Realizacje
                            </a> </li>
                        <li class="nav-item py-2 px-3 text-md-center text-left"> <a href="{{ url('o_nas') }}"
                                class="nav-link font-weight-bold text-dark">
                                O nas
                            </a> </li>
                        <li class="nav-item py-2 px-3"> <a href="{{ url('kontakt') }}"
                                class="nav-link font-weight-bold text-dark">
                                Kontakt
                            </a> </li>
                    </ul>
                </div>
            </div>


            <!-- Meble -->

            <div class="navdown container" id="furniture">
                <ul class="row col-12 m-0 p-0">
                    <div class="col-12 col-sm-8 mb-auto">
                        <div class="row col-12 p-0 m-0 mb-3">
                            <h5 class="font-weight-bold d-inline-block p-0 m-0 col-11"> Meble </h5>
                            <div class="d-inline-block close col-1 p-0" id="furnitureClose">×</div>
                        </div>
                        <div class="col-12 row">

                            @foreach ($menu as $item)
                            @if ($item->kategoria == "meble")
                            <a href="{{ url('/produkty/meble'.'/'.lcfirst($item->typ)) }}"
                                class="text-decoration-none col-md-4 col-6 text-md-left text-center">
                                <li class="nav-link "> {{ $item->typ }}
                                </li>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Na wymiar -->

                    <div class="col-12 col-sm-4 roughly"
                        style="background-color: rgb(238, 238, 238); border-radius: 5px">
                        <h5 class="font-weight-bold mt-3"> Meble na wymiar </h5>
                        <a href="{{ url('/na-wymiar') }}" class="text-decoration-none">
                            <li class="nav-link col-12"> Szafa przesuwna
                            </li>
                        </a>
                        <a href="{{ url('/na-wymiar') }}" class="text-decoration-none">
                            <li class="nav-link col-12"> Szafa uchylna
                            </li>
                        </a>
                        <a href="{{ url('/na-wymiar') }}" class="text-decoration-none">
                            <li class="nav-link col-12"> Półka
                            </li>
                        </a>
                        <a href="{{ url('/na-wymiar') }}" class="text-decoration-none">
                            <li class="nav-link col-12"> Meble
                                kuchenne </li>
                        </a>
                        <a href="{{ url('/na-wymiar') }}" class="text-decoration-none">
                            <li class="nav-link col-12"> Meble
                                łazienkowe </li>
                        </a>
                    </div>
                </ul>
            </div>


            <!-- Wyposażenie -->

            <div class="navdown container" id="equipment">
                <ul class="row col-12 mb-0 mx-auto">

                    <div class="row col-12 p-0 m-0 mb-3">
                        <h5 class="font-weight-bold d-inline-block p-0 m-0 col-11"> Sprzęt AGD </h5>
                        <div class="d-inline-block close col-1 p-0" id="equipmentClose">×</div>
                    </div>
                    <div class="col-12 row">
                        @foreach ($menu as $item)
                        @if ($item->kategoria == "agd")
                        <a href="{{ url('/produkty/sprzet'.'/'.lcfirst($item->typ)) }}"
                            class="text-decoration-none col-md-4 col-6 text-md-left text-center">
                            <li class="nav-link "> {{ $item->typ }}
                            </li>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </ul>
            </div>


            <!-- Akcesoria -->

            <div class="navdown container" id="accessories">
                <ul class="row col-12 mb-0 mx-auto">

                    <div class="row col-12 p-0 m-0 mb-3">
                        <h5 class="font-weight-bold d-inline-block p-0 m-0 col-11"> Akcesoria </h5>
                        <div class="d-inline-block close col-1 p-0" id="accessoriesClose">×</div>
                    </div>
                    <div class="col-12 row">
                        @foreach ($menu as $item)
                        @if ($item->kategoria == "akcesoria")
                        <a href="{{ url('/produkty/akcesoria'.'/'.lcfirst($item->typ)) }}"
                            class="text-decoration-none col-md-4 col-6 text-md-left text-center">
                            <li class="nav-link "> {{ $item->typ }}
                            </li>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </ul>
            </div>

        </nav>

        <script src="{{ asset('js/nav.js') }}"></script>


        <main>
            @yield('content')
        </main>
    </div>

    <footer class="mt-auto bg-dark text-white">
        <div class="container mb-4 mt-4">
            <div class="row justify-content-center">
                <div class="col">
                    <p class="font-weight-bold footerTitle"> Dla Klientów </p>
                    <a href="{{ url('regulamin')}} "> Regulamin </a>
                    <br>
                    <a href="{{ url('reklacje_i_zwroty')}} "> Reklamacje i zwroty </a>
                </div>
                <div class="col">
                    <p class="font-weight-bold footerTitle"> O nas </p>
                    <a href="{{ url('o_nas') }}"> Firma </a>
                    <br>
                    <a href="{{ url('kontakt')}}"> Kontakt </a>
                    <br>
                    <a href="{{ url('opinie')}} "> Opinie </a>
                </div>
                <div class="col">
                    <p class="font-weight-bold footerTitle"> Kontakt </p>
                    <span> <i class="fas fa-phone mr-1"></i> (075) 78 11 343 </span>
                    <br>
                    <span> <i class="fas fa-phone mr-1"></i> 609 752 994 </span>
                    <br>
                    <span> <i class="fas fa-envelope mr-1"></i> arnetgryfow@poczta.onet.pl </span>
                </div>
            </div>
        </div>
        <div class="text-center my-3"> Copyright 2021. Wszelkie prawa zastrzeżone. </div>
    </footer>
</body>

</html>