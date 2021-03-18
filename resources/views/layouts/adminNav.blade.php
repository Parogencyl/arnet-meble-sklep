<?php

    $menu = DB::table('menu_category')->orderby('typ', 'asc')->get();

    $agent = new \Jenssegers\Agent\Agent;

?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                    <li class="nav-item mr-4 col">
                        <a class="nav-link text-center" href="{{ route('client/login') }}"> <i class="fas fa-user"
                                style="font-size: 40px"></i> </a>
                    </li>
                    @else
                    <li class="nav-item dropdown mr-4 col">

                        <a id="navbarDropdown" class="nav-link text-center dropdown-toggle" href="#"
                            data-toggle="dropdown"> <i class="fas fa-user" style="font-size: 40px;"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" style="z-index: 1100"
                            aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-dark text-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Wyloguj
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
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

                        <li class="nav-item py-2 px-3">
                            <!--<form action="/admin/zamowienia" method="POST" id="zamowienie" class="mb-0 ">
                                @csrf
                                <div onclick="document.getElementById('zamowienie').submit()"
                                    class="nav-link font-weight-bold text-dark" id="zamowieniaButton">
                                    Zamówienia
                                </div>
                            </form>-->
                            <a href="{{ url('/admin/zamowienia') }}" class="nav-link font-weight-bold text-dark">
                                Zamówienia
                            </a>
                        </li>

                        @if($agent->isMobile() || $agent->isTablet())
                        <li class="nav-item py-2 px-3" id="furnitureLi">
                            <a class="nav-link font-weight-bold text-dark">
                                Meble
                            </a>
                        </li>
                        @else
                        <li class="nav-item py-2 px-3" id="furnitureLi"> <a href="{{ url('/admin/produkty/meble') }}"
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
                        <li class="nav-item py-2 px-3 text-md-center text-left" id="equipmentLi"> <a
                                href="{{ url('/admin/produkty/sprzet') }}" class="nav-link font-weight-bold text-dark">
                                Sprzęt AGD
                            </a> </li>
                        @endif

                        @if($agent->isMobile() || $agent->isTablet())
                        <li class="nav-item py-2 px-3" id="accessoriesLi"> <a
                                class="nav-link font-weight-bold text-dark">
                                Akcesoria
                            </a> </li>
                        @else
                        <li class="nav-item py-2 px-3" id="accessoriesLi"> <a
                                href="{{ url('/admin/produkty/akcesoria') }}"
                                class="nav-link font-weight-bold text-dark">
                                Akcesoria
                            </a> </li>
                        @endif

                        <li class="nav-item py-2 px-3"> <a href="{{ url('admin/realizacje') }}"
                                class="nav-link font-weight-bold text-dark">
                                Realizacje
                            </a> </li>
                        <li class="nav-item py-2 px-3"> <a href="{{ url('admin/strona_glowna') }}"
                                class="nav-link font-weight-bold text-dark">
                                Main
                            </a> </li>
                        <li class="nav-item py-2 px-3"> <a href="{{ url('admin') }}"
                                class="nav-link font-weight-bold text-dark">
                                Kategorie
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
                            <a href="{{ url('/admin/produkty/meble'.'/'.lcfirst($item->typ)) }}"
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
                        <a href="#" class="text-decoration-none">
                            <li class="nav-link col-12"> Szafa przesuwna
                            </li>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <li class="nav-link col-12"> Szafa uchylna
                            </li>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <li class="nav-link col-12"> Półka
                            </li>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <li class="nav-link col-12"> Meble
                                kuchenne </li>
                        </a>
                        <a href="#" class="text-decoration-none">
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
                        <a href="{{ url('/admin/produkty/sprzet'.'/'.lcfirst($item->typ)) }}"
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
                        <a href="{{ url('/admin/produkty/akcesoria'.'/'.lcfirst($item->typ)) }}"
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

    <!-- Stopka -->

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
                    <a href="{{ url('admin/opinie')}} "> Opinie </a>
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
        <div class="text-center my-3"> Copyright 2020. Wszelkie prawa zastrzeżone. </div>
    </footer>
</body>

</html>