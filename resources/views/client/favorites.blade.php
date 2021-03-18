<?php

    $favorites = array();

    if(Auth::id()){
        if(DB::table('users_favorite')->where('user_id', Auth::user()->id)->join('products', 'users_favorite.kategoria_id', '=', 'products.id')->get()){
            $favorites = DB::table('users_favorite')->where('user_id', Auth::user()->id)->join('products', 'users_favorite.kategoria_id', '=', 'products.id')->get();
        }
    } else{
        if(session()->get('favorites')){
            for ($i=0; $i < count(session()->get('favorites')); $i++) { 
                array_push($favorites, DB::table('products')->where('id', session()->get('favorites')[$i])->first());
            }
        }
    }

?>

@extends('layouts.nav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/favorites.css') }}">
@endsection

@section('content')
@yield('style')
<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> Ulubione </h1>

<div class="container">

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <div class="row justify-content-sm-start justify-content-center">

        @if (Auth::id())

        @if (!$favorites->isEmpty())

        @foreach ($favorites as $product)

        <a href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}"
            class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
            @if ($product->ilosc_dostepnych && $product->w_sprzedazy)
            <div class="card anim">
                @else
                <div class="card">
                    @endif
                    <img src="{{ $product->zdjecie1 }}" class="card-img-top p-2" alt="{{ $product->nazwa }}">
                    <div class="card-body bg-light pb-0">
                        <h5 class="card-title text-dark font-weight-bold mb-1"> {{ $product->nazwa }}
                        </h5>
                        @if ($product->stara_cena)
                        <p class="card-text text-right font-weight-bold mb-1 text-success"> <del
                                style="font-size: 1rem;" class="text-dark mr-2"> {{ $product->stara_cena }} zł </del>
                            {{ $product->cena }}
                            zł </p>
                        @else
                        <p class="card-text text-right font-weight-bold mb-1 text-dark"> {{ $product->cena }} zł </p>
                        @endif
                    </div>
                    @if ($product->glebokosc)
                    <div class="bg-light px-3 pb-2 pt-0">
                        <hr class="mb-2 mt-1">
                        <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;"> {{ $product->glebokosc }} x
                            {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                    </div>
                    @endif

                    @if (!$product->ilosc_dostepnych || !$product->w_sprzedazy)
                    <div class="bg-light text-danger text-center font-weight-bold" style="font-size: 20px;">
                        NIEDOSTĘPNY </div>
                    @endif

                    @if ($product->ilosc_dostepnych && $product->w_sprzedazy)
                    <div class="addToCard w-100">
                        <form method="POST" action="/product/addToCard" class="mb-0">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                            <button type="submit" class="btn btn-success btn-lg w-100" id="addToCard"> <i
                                    class="fas fa-shopping-basket mr-2 "> </i> Dodaj do koszyka </button>
                        </form>
                    </div>
                    @endif

                    @if ($product->stara_cena)
                    <div class="promotion text-success"> PROMOCJA </div>
                    @endif

                    <form action="product/deleteFromFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites"> <i class="fas fa-heart"></i> </button>
                    </form>

                </div>
        </a>

        @endforeach

        @else

        <div class="element mb-3 p-3 w-100 mx-2">
            <p class="font-weight-bold mb-0 text-center py-4" style="font-size: 22px"> Do listy ulubionych przedmiotów
                nie został dodany żaden produkt. </p>
        </div>

        @endif


        @else

        @if ($favorites)

        @foreach ($favorites as $product)

        <a href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}"
            class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
            @if ($product->ilosc_dostepnych && $product->w_sprzedazy)
            <div class="card anim">
                @else
                <div class="card">
                    @endif
                    <img src="{{ $product->zdjecie1 }}" class="card-img-top p-2" alt="{{ $product->nazwa }}">
                    <div class="card-body bg-light pb-0">
                        <h5 class="card-title text-dark font-weight-bold mb-1"> {{ $product->nazwa }}
                        </h5>
                        @if ($product->stara_cena)
                        <p class="card-text text-right font-weight-bold mb-1 text-success"> <del
                                style="font-size: 1rem;" class="text-dark mr-2"> {{ $product->stara_cena }} zł </del>
                            {{ $product->cena }}
                            zł </p>
                        @else
                        <p class="card-text text-right font-weight-bold mb-1 text-dark"> {{ $product->cena }} zł </p>
                        @endif
                    </div>
                    @if ($product->glebokosc)
                    <div class="bg-light px-3 pb-2 pt-0">
                        <hr class="mb-2 mt-1">
                        <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;"> {{ $product->glebokosc }} x
                            {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                    </div>
                    @endif

                    @if (!$product->ilosc_dostepnych || !$product->w_sprzedazy)
                    <div class="bg-light text-danger text-center font-weight-bold" style="font-size: 20px;">
                        NIEDOSTĘPNY </div>
                    @endif

                    @if ($product->ilosc_dostepnych && $product->w_sprzedazy)
                    <div class="addToCard w-100">
                        <form method="POST" action="/product/addToCard" class="mb-0">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                            <button type="submit" class="btn btn-success btn-lg w-100" id="addToCard"> <i
                                    class="fas fa-shopping-basket mr-2 "> </i> Dodaj do koszyka </button>
                        </form>
                    </div>
                    @endif

                    @if ($product->stara_cena)
                    <div class="promotion text-success"> PROMOCJA </div>
                    @endif

                    <form action="product/deleteFromFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites"> <i class="fas fa-heart"></i> </button>
                    </form>

                </div>
        </a>

        @endforeach

        @else

        <div class="element mb-3 p-3 w-100 mx-2">
            <p class="font-weight-bold mb-0 text-center py-4" style="font-size: 22px"> Do listy ulubionych przedmiotów
                nie został dodany żaden produkt. </p>
        </div>

        @endif
        @endif
    </div>
</div>


@endsection