<?php

    $sessionProducts = array();
    $products = array();
    $total = $totalProducts = $delivery = 0;

    if(Auth::id()){
        $products = DB::table('cart')->where('user_id', Auth::user()->id)->join('products', 'cart.kategoria_id', '=', 'products.id')->where('w_sprzedazy', 1)->where('ilosc_dostepnych', '>', 0)->get();
        for ($i=0; $i < count($products); $i++) { 
            $total += $products[$i]->cena * $products[$i]->amount;
            $totalProducts += $products[$i]->cena * $products[$i]->amount;
            $delivery += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
            $total += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
        }
    } else {
        if(session()->get('cart')){
            for ($i=0; $i < count(session()->get('cart')); $i++) { 
                array_push($sessionProducts, DB::table('products')->where('id', session()->get('cart')[$i]->id)->first());
                $sessionProducts[$i]->amount = session()->get('cart')[$i]->amount;
            }
            for ($i=0; $i < count($sessionProducts); $i++) { 
                if($sessionProducts[$i]->ilosc_dostepnych && $sessionProducts[$i]->w_sprzedazy){
                    $total += $sessionProducts[$i]->cena * $sessionProducts[$i]->amount;
                    $totalProducts += $sessionProducts[$i]->cena * $sessionProducts[$i]->amount;
                    $delivery += (ceil(($sessionProducts[$i]->amount)/($sessionProducts[$i]->ilosc_w_paczce)))*$sessionProducts[$i]->koszt_wysylki;
                    $total += (ceil(($sessionProducts[$i]->amount)/($sessionProducts[$i]->ilosc_w_paczce)))*$sessionProducts[$i]->koszt_wysylki;
                }
            }
        }
        $products = $sessionProducts;
    }

    $total = number_format($total, 2, '.', '');
    $delivery = number_format($delivery, 2, '.', '');
    $totalProducts = number_format($totalProducts, 2, '.', '');

    $agent = new \Jenssegers\Agent\Agent;

?>

@extends('layouts.nav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/order.css') }}">

<style>
    p {
        font-size: 16px;
    }
</style>
@endsection

@section('content')
@yield('style')
<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> TWój koszyk </h1>

<div class="container mb-5">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block col-12 my-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block col-12 my-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <div class="row justify-content-center">

        <div class="col-md-10 col-12">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-4 col-12 mb-3">
                    <div class="row">
                        <div class="triangle d-flex align-items-center">
                            <div> 1 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center"> Podsumowanie koszyka</span>
                        <div class="d-flex align-items-center updash1">
                            <div class="dash mx-2"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <div class="row">
                        <div class="triangle d-flex align-items-center">
                            <div> 2 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center"> Dane do zamówienia </span>
                        <div class="d-flex align-items-center updash2">
                            <div class="dash mx-2"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="row">
                        <div class="triangle d-flex align-items-center active">
                            <div> 3 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center textActive"> Podsumowanie oraz płatność </span>
                        <div class="d-flex align-items-center updash3">
                            <div class="dash mx-2"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-xl-9 col-md-8 col-12 pr-md-5 pr-2">

            <h3 class="font-weight-bold mt-4 mb-3"> Dane do wysyłki </h3>

            <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

            <p class="font-weight-bold mb-0"> Adres email: </p>
            <p> {{ session('client')->email }} </p>

            <p class="font-weight-bold mb-0"> Adres docelowy: </p>
            <p class="mb-0"> {{ session('client')->name.' '.session('client')->surname }} </p>
            <p class="mb-0"> {{ session('client')->street.' '.session('client')->numberOfFlat }} </p>
            <p> {{ session('client')->zip.' '.session('client')->city }} </p>

            <p class="font-weight-bold mb-0"> Telefon: </p>
            <p> {{ session('client')->phone }} </p>

            <h3 class="font-weight-bold mt-4 mb-3"> Sposób potwierdzenie sprzedaży </h3>

            <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

            @if (session('client')->faktura == 'faktura')
            <p class="font-weight-bold mb-0"> Faktura: </p>
            <p class="mb-0"> {{ session('faktura')->company }} </p>
            <p class="mb-0"> {{ session('faktura')->nip }} </p>
            <p class="mb-0"> {{ session('faktura')->street2.' '.session('faktura')->numberOfFlat2 }} </p>
            <p> {{ session('faktura')->zip2.' '.session('faktura')->city2 }} </p>

            @else
            <p> Paragon </p>
            @endif


            <h3 class="font-weight-bold mt-5 mb-3"> Uwagi do zamówienia </h3>

            <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

            @if ( session()->get('comment') )
            <p> {{ session()->get('comment') }} </p>
            @else
            <p> Brak </p>
            @endif


            <div class="col-12 text-center font-weight-bold py-3 mt-5 pr-md-5 pr-0"
                style="background-color: rgb(219, 219, 219); font-size: 22px; border-radius: 5px;"> Łączny
                koszt: <span id="total">
                    {{ $total }} </span> zł </div>

            <form action="/summary/buy" method="POST" class="mt-5 d-flex justify-content-center">
                @csrf
                <a href="{{ url('koszyk/zamówienie') }}" class="btn btn-lg btn-dark mb-4"> ZMIEŃ DANE </a>

                <button type="submit" class="btn btn-lg btn-success ml-3 mb-4" disabled> ZAMÓW I ZAPŁAĆ </button>

            </form>

        </div>


        <!-- 

            Podsumowanie


        -->

        <div class="col-xl-3 col-md-4 col-sm-9 col-11 summary" style="position: sticky">
            <p class="font-weight-bold mb-2 text-center" style="font-size: 17px;"> PODSUMOWANIE </p>
            <p class="mb-0 font-weight-bold"> Produkty: </p>
            @foreach ($products as $product)
            @if ($product->ilosc_dostepnych && $product->w_sprzedazy)
            <p class="mb-0 text-light"> {{ $product->nazwa }} - {{ $product->amount }} szt. -
                <span class="text-green"> {{ number_format($product->cena*$product->amount, 2, '.', '') }} zł </span>
            </p>
            @endif
            @endforeach

            <p class="mb-0 font-weight-bold mt-2"> Łączna wartość produktów: </p>
            <p class="mb-0 txt"> <span class="text-green"> {{ $totalProducts }} zł </span> </p>

            <p class="mb-0 font-weight-bold mt-2"> Sposób wysyłki: </p>
            <p class="mb-0 txt"> Przesyłka kurierska - <span class="text-green"> {{ $delivery }} zł </span>
            </p>

            <p class="mb-0 font-weight-bold mt-2"> Sposób płatności: </p>
            <p class="mb-0 txt"> {{ session()->get('payment') }} - <span class="text-green"> 0 zł </span>
            </p>

            <div class="summaryTotal mt-2">
                <p class="mb-0 font-weight-bold"> Łączna kwota do zapłaty: </p>
                <p class="mb-0 font-weight-bold text-green"> {{ $total }} zł </p>
            </div>
        </div>


    </div>
</div>


@endsection