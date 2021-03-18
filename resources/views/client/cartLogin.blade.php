<?php

    $products = array();
    $total = 0;

    $products = DB::table('cart')->where('user_id', Auth::user()->id)->join('products', 'cart.kategoria_id', '=', 'products.id')->get();
    foreach ($products as $product) {
        if ($product->ilosc_dostepnych < $product->amount) {
            DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $product->id)->update(['amount' => $product->ilosc_dostepnych]);
            $product->amount = $product->ilosc_dostepnych;
            session(['alert' => 'Ilość dostępnych przedmiotów "'.$product->nazwa.'" wynosi '.$product->ilosc_dostepnych]);
        }
    }
    for ($i=0; $i < count($products); $i++) { 
        if($products[$i]->ilosc_dostepnych && $products[$i]->w_sprzedazy){
            $total += $products[$i]->cena * $products[$i]->amount;
            $total += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
        }
    }


    $total = number_format($total, 2, '.', '');

    $agent = new \Jenssegers\Agent\Agent;

?>

@extends('layouts.nav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
@yield('style')
<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> TWÓJ Koszyk </h1>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-10 col-12">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-4 col-12 mb-3">
                    <div class="row">
                        <div class="triangle d-flex align-items-center active">
                            <div> 1 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center textActive"> Podsumowanie koszyka</span>
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
                        <div class="triangle d-flex align-items-center">
                            <div> 3 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center"> Podsumowanie oraz płatność </span>
                        <div class="d-flex align-items-center updash3">
                            <div class="dash mx-2"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @if ($message = Session::get('alert'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if (count($products) > 0)

        <div class="col-12">
            <div class="row">
                <div class="col-12 font-weight-bold py-2"
                    style="background-color: rgb(219, 219, 219); font-size: 20px; border-radius: 5px;">
                    <div class="row p-0">
                        <div class="col-md-6 pl-3"> Produkty </div>
                        <div class="col-md-1 d-none d-md-block text-center"> Cena </div>
                        <div class="col-md-2 d-none d-md-block text-center"> Ilość </div>
                        <div class="col-md-1 d-none d-md-block text-center"> Wartość </div>
                        <div class="col-md-1 d-none d-md-block text-center"> Dostawa </div>
                        <div class="col-md-1 d-none d-md-block text-center"> Usuń </div>
                    </div>
                </div>

                @foreach ($products as $product)

                @if($product->ilosc_dostepnych && $product->w_sprzedazy)
                <div class="col-12 mt-md-3 mt-5 p-2">
                    @else
                    <div class="col-12 mt-md-3 mt-5 p-2" style="border: solid 3px rgba(131, 14, 14, 0.8)">
                        @endif
                        <div class="row p-0 m-0 font-weight-bold justify-content-center">
                            <div class="col-md-2 col-6 p-0 justify-content-center"> <img
                                    src="{{ asset($product->zdjecie1) }}" class="w-100 ml-2"> </div>
                            <div class="col-md-4 col-11 mt-2 mt-md-0 d-flex justify-content-center align-items-center">
                                @if (!$product->ilosc_dostepnych || !$product->w_sprzedazy)
                                <p class="text-center">
                                    {{ $product->nazwa}} <br>
                                    <span class="text-danger text-center font-weight-bold" style="font-size: 20px;">
                                        PRODUKT
                                        NIEDOSTĘPNY </span>
                                </p>
                                @else
                                {{ $product->nazwa}}
                                @endif
                            </div>
                            <div
                                class="col-md-1 col-11 mt-2 mt-md-0 px-1 d-flex justify-content-center align-items-center">
                                @if ($agent->isMobile() || $agent->isTablet())
                                <span class="font-weight-normal">Cena:&nbsp;</span>
                                @endif
                                {{ number_format($product->cena, 2, '.', '')}} zł </div>
                            <div class="col-md-2 col-8 mt-2 mt-md-0 d-flex justify-content-center align-items-center ">
                                @if ($agent->isMobile() || $agent->isTablet())
                                <span class="font-weight-normal">Ilość:&nbsp;</span>
                                @endif
                                <div class="row m-0 p-0" style="border: solid black 1px; border-radius: 5px;">
                                    <div class="col-3 p-0 text-center amount user-select-none"
                                        onclick="minus({{$loop->iteration}}, {{$product->ilosc_w_paczce}}, {{$product->koszt_wysylki}}, {{$product->cena}}, {{$product->ilosc_dostepnych}}, {{$product->w_sprzedazy}})">
                                        -
                                    </div>

                                    <div class="col-6 p-0 d-flex align-items-stretch">
                                        <input type="text" disabled value="{{ $product->amount }}" name="amount"
                                            class="text-center w-100 amountValue">
                                    </div>

                                    <div class="col-3 p-0 text-center amount user-select-none"
                                        onclick="plus({{$loop->iteration}}, {{$product->ilosc_w_paczce}}, {{$product->koszt_wysylki}}, {{$product->cena}}, {{$product->ilosc_dostepnych}}, {{$product->w_sprzedazy}})">
                                        +
                                    </div>
                                </div>
                            </div>

                            <div
                                class="col-md-1 col-11 mt-2 mt-md-0 px-1 d-flex justify-content-center align-items-center">
                                @if ($agent->isMobile() || $agent->isTablet())
                                <span class="font-weight-normal">Wartość:&nbsp;</span>
                                @endif
                                <span class="value">
                                    {{ number_format($product->amount*$product->cena, 2, '.', '') }}
                                </span>&nbsp;zł
                            </div>

                            <div class="col-md-1 col-11 mt-2 mt-md-0 d-flex justify-content-center align-items-center">
                                @if ($agent->isMobile() || $agent->isTablet())
                                <span class="font-weight-normal">Dostawa:&nbsp;</span>
                                @endif
                                <span class="delivery">
                                    {{ (ceil(($product->amount)/($product->ilosc_w_paczce)))*$product->koszt_wysylki }}
                                </span>&nbsp;zł
                            </div>

                            <div class="col-md-1 col-11 mt-2 mt-md-0 d-flex justify-content-center align-items-center">
                                <form action="/product/deleteFromCart" method="POST" class="bg-inherit">
                                    @csrf
                                    <input type="text" name="user_id" value="{{ $product->user_id }}" class="d-none">
                                    <input type="text" name="kategoria_id" value="{{ $product->kategoria_id }}"
                                        class="d-none">
                                    <button class="border-0" style="background-color: inherit"> <i
                                            class="fas fa-trash-alt trash"> </i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>

                <div class="col-12 text-md-right text-center font-weight-bold py-3 mt-4 pr-md-5 pr-0"
                    style="background-color: rgb(219, 219, 219); font-size: 22px; border-radius: 5px;"> Łączny
                    koszt: <span id="total">
                        {{ $total }} </span> zł </div>
                <p class="mb-0 other text-left"> Zalecane jest dokończenie zamówienia. Dopóki produkt nie zostanie
                    zakupiony
                    przez
                    Ciebie, inni mogą
                    zamówić ostatnie sztuki danego produktu. </p>
                <p class="other text-left"> Wszystkie zamówienia wysyłane są za pomocą firmy kurierskiej. </p>
                <form action="/summaryCart" method="POST" class="col-12">
                    @csrf
                    @for ($i = 0; $i < count($products); $i++) <input type="text" name="{{ 'amount'.$i }}"
                        value="{{ $products[$i]->amount }}" class="formAmount d-none">
                        <input type="text" name="{{ 'id'.$i }}" value="{{ $products[$i]->kategoria_id }}"
                            class="formAmount d-none">
                        @endfor

                        <div class="col-12 my-5">
                            <h3 class="font-weight-bold mb-4"> Sposób wysyłki </h3>
                            <div class="custom-control custom-radio mb-2">
                                <input class="custom-control-input" type="radio" name="delivery" id="exampleRadios1"
                                    value=" Przesyłka kurierska" checked>
                                <label class="custom-control-label" for="exampleRadios1">
                                    Przesyłka kurierska
                                </label>
                            </div>
                        </div>

                        <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

                        <div class="col-12 my-5">
                            <h3 class="font-weight-bold mb-4"> Metoda płatności </h3>
                            <div class="custom-control custom-radio mb-2">
                                <input class="custom-control-input" type="radio" name="payment" id="Radios1"
                                    value="Płatność online Przelewy24" checked>
                                <label class="custom-control-label" for="Radios1">
                                    Płatność online Przelewy24
                                </label>
                            </div>

                            <hr>

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="payment" id="Radios2"
                                    value="Płatność gotówką przy odbiorze">
                                <label class="custom-control-label" for="Radios2">
                                    Płatność gotówką przy odbiorze
                                </label>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center mt-5 mb-5">
                            <button type="submit" class="btn btn-lg btn-success font-weight-bold"
                                style="transform: scale(1.1)">
                                PRZEJDŹ DO ZAMÓWIENIA
                            </button>
                        </div>
                </form>

                @else

                <div class=" element mb-3 p-3 w-100 mx-2">
                    <p class="font-weight-bold mb-0 text-center py-4" style="font-size: 22px"> W Twoim koszyku nie
                        znajduje
                        się żadnej produkt. </p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        function plus(element, amount, price, productPrice, available, w_sprzedazy){
    if(available && w_sprzedazy){
        var val = Number(document.getElementsByClassName('amountValue')[element-1].value) + 1;
        if(available>=val){
            var total = document.getElementById('total').innerHTML;
            document.getElementsByClassName('amountValue')[element-1].value = val; 
            document.getElementsByClassName('formAmount')[element-1].value = val; 
            total -= document.getElementsByClassName('delivery')[element-1].innerHTML;
            total += productPrice;
            total += (Math.ceil(val/amount))*price;
            total = total.toFixed(2);
            document.getElementById('total').innerHTML = total;
            document.getElementsByClassName('delivery')[element-1].innerHTML = ((Math.ceil(val/amount))*price).toFixed(2); 
            document.getElementsByClassName('value')[element-1].innerHTML = (productPrice*val).toFixed(2);
        }
    }
}
function minus(element, amount, price, productPrice, available, w_sprzedazy){
    if(available && w_sprzedazy){
        var val = Number(document.getElementsByClassName('amountValue')[element-1].value) - 1; 
        if(val > 0){
            var total = document.getElementById('total').innerHTML;
            document.getElementsByClassName('amountValue')[element-1].value = val; 
            document.getElementsByClassName('formAmount')[element-1].value = val; 
            total -= document.getElementsByClassName('delivery')[element-1].innerHTML;
            total -= productPrice;
            total += (Math.ceil(val/amount))*price;
            total = total.toFixed(2);
            document.getElementById('total').innerHTML = total;
            document.getElementsByClassName('delivery')[element-1].innerHTML = ((Math.ceil(val/amount))*price).toFixed(2); 
            document.getElementsByClassName('value')[element-1].innerHTML = (productPrice*val).toFixed(2);
    }
    }
}

    </script>

    @endsection