<?php

    $sessionProducts = array();
    $products = array();
    $total = $totalProducts = $delivery = 0;

    $user = DB::table('users')->where('id', Auth::user()->id)->first();
    $products = DB::table('cart')->where('user_id', Auth::user()->id)->join('products', 'cart.kategoria_id', '=', 'products.id')->where('w_sprzedazy', 1)->where('ilosc_dostepnych', '>', 0)->get();
    for ($i=0; $i < count($products); $i++) { 
        $total += $products[$i]->cena * $products[$i]->amount;
        $totalProducts += $products[$i]->cena * $products[$i]->amount;
        if (!(session()->get('delivery') == 'Odbiór osobisty')) {
            $delivery += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
            $total += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
        }
    }
    
    $total = number_format($total, 2, '.', '');
    $totalProducts = number_format($totalProducts, 2, '.', '');
    if (!$delivery == 0) {
        $delivery = number_format($delivery, 2, '.', '');
    }

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
                        <div class="triangle d-flex align-items-center active">
                            <div> 2 </div>
                        </div>
                        <span class="ml-2 d-flex align-items-center textActive"> Dane do zamówienia </span>
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


        <div class="col-xl-9 col-md-8 col-12 pr-md-5 pr-2">

            <form action="/summaryOrder" method="POST" id="form">
                @csrf

                <h3 class="font-weight-bold mt-4 mb-3"> Dane do wysyłki </h3>

                <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" required autocomplete="email" value="{{ $user->email }}"
                            placeholder="E-mail *">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if ($user->name)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" required autocomplete="billing given-name" value="{{ $user->name }}"
                            placeholder="Imię *">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" required autocomplete="billing given-name" value="{{ old('name') }}"
                            placeholder="Imię *">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->surname)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                            name="surname" required autocomplete="billing family-name" value="{{ $user->surname }}"
                            placeholder="Nazwisko *">
                        @error('surname')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                            name="surname" required autocomplete="billing family-name" value="{{ old('surname') }}"
                            placeholder="Nazwisko *">
                        @error('surname')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->street)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                            name="street" required autocomplete="billing address-line1" value="{{ $user->street }}"
                            placeholder="Ulica *">
                        @error('street')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror"
                            name="street" required autocomplete="billing address-line1" value="{{ old('street') }}"
                            placeholder="Ulica *">
                        @error('street')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->local_number)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="numberOfFlat" type="text"
                            class="form-control @error('numberOfFlat') is-invalid @enderror" name="numberOfFlat"
                            required autocomplete="billing address-line2" value="{{ $user->local_number }}"
                            placeholder="Number mieszkania *">
                        @error('numberOfFlat')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="numberOfFlat" type="text"
                            class="form-control @error('numberOfFlat') is-invalid @enderror" name="numberOfFlat"
                            required autocomplete="billing address-line2" value="{{ old('numberOfFlat') }}"
                            placeholder="Number mieszkania *">
                        @error('numberOfFlat')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->city)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                            name="city" required autocomplete="billing address-level2" value="{{ $user->city }}"
                            placeholder="Miejscowość *">
                        @error('city')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                            name="city" required autocomplete="billing address-level2" value="{{ old('city') }}"
                            placeholder="Miejscowość *">
                        @error('city')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->zip)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip"
                            required autocomplete="billing postal-code" value="{{ $user->zip }}"
                            placeholder="Kod pocztowy *">
                        @error('zip')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip"
                            required autocomplete="billing postal-code" value="{{ old('zip') }}"
                            placeholder="Kod pocztowy *">
                        @error('zip')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if ($user->phone)
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" required autocomplete="phone" value="{{ $user->phone }}"
                            placeholder="Telefon *">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group mb-1 ml-2">
                    <div class="col-12 col-md-10 col-xl-9">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" required autocomplete="phone" value="{{ old('phone') }}"
                            placeholder="Telefon *">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                <!--

                    Faktura

                -->


                <h3 class="font-weight-bold mt-3 mb-3"> Dane do faktury </h3>

                <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

                <div class="custom-control custom-radio mb-2 ml-4">
                    <input class="custom-control-input" type="radio" name="faktura" id="Radios1" value="paragon"
                        onchange="showFaktura(this)" checked>
                    <label class="custom-control-label" for="Radios1">
                        Paragon
                    </label>
                </div>

                <div class="custom-control custom-radio ml-4">
                    <input class="custom-control-input" type="radio" name="faktura" id="Radios2" value="faktura"
                        onchange="showFaktura(this)">
                    <label class="custom-control-label" for="Radios2">
                        Faktura VAT
                    </label>
                </div>

                <div id="faktura">

                    <p class="font-weight-bold my-3 ml-3 copy" onclick="copyData()"> Skopiuj dane do faktury </p>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="company" type="text" class="form-control @error('company') is-invalid @enderror"
                                name="company" autocomplete="company" value="{{ old('company') }}"
                                placeholder="Firma *">
                            @error('company')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror"
                                name="nip" autocomplete="nip" value="{{ old('nip') }}" placeholder="Nip *">
                            @error('nip')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="street2" type="text" class="form-control @error('street2') is-invalid @enderror"
                                name="street2" autocomplete="street" value="{{ old('street2') }}" placeholder="Ulica *">
                            @error('street2')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="numberOfFlat2" type="text"
                                class="form-control @error('numberOfFlat2') is-invalid @enderror" name="numberOfFlat2"
                                autocomplete="numberOfFlat" value="{{ old('numberOfFlat2') }}"
                                placeholder="Number mieszkania *">
                            @error('numberOfFlat2')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="city2" type="text" class="form-control @error('city2') is-invalid @enderror"
                                name="city2" autocomplete="city" value="{{ old('city2') }}" placeholder="Miejscowość *">
                            @error('city2')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-1 ml-2">
                        <div class="col-12 col-md-10 col-xl-9">
                            <input id="zip2" type="text" class="form-control @error('zip2') is-invalid @enderror"
                                name="zip2" autocomplete="zip" value="{{ old('zip2') }}" placeholder="Kod pocztowy *">
                            @error('zip2')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>


                <h3 class="font-weight-bold mt-5 mb-3"> Uwagi do zamówienia </h3>

                <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

                <div class="form-check mb-3 ml-4">
                    <input type="checkbox" class="form-check-input" id="comments" name="commentsInput"
                        onchange="showComments(this)">
                    <label class="form-check-label" for="comments"> Dodaj uwagę do zamówienia </label>
                </div>

                <div class="form-group" id="textArea">
                    <div class="col-12 col-md-10 col-xl-9">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"
                            placeholder="Wiadomość dla sprzedającego" name="comments"></textarea>
                    </div>
                </div>


                <!--

                    Regulamin

                -->


                <h3 class="font-weight-bold mt-5 mb-3"> Regulamin </h3>

                <hr style="border-top: 2px solid rgba(0, 0, 0, 0.3);">

                <p class="mb-0"> Klient ma prawo do odstąpienia od umowy w czasie 14 dni od zakupu. </p>
                <p class="mb-0"> Koszt zwrotu produktów ponosi kupujący. </p>
                <p> Więcej informacji w
                    <a href="{{ url('regulamin') }}" class="text-body" style="text-decoration: underline">
                        regulaminie</a>. </p>

                <div class="form-check mb-3 ml-4">
                    <input type="checkbox" class="form-check-input @error('regulamin') is-invalid @enderror"
                        id="regulamin" name="regulamin" required>

                    <label class="form-check-label" for="regulamin"> <span class="text-danger">*</span> Oświadczam, że
                        zapoznałem/łam się z <a href="{{ url('regulamin') }}" class="text-body"
                            style="text-decoration: underline"> regulaminem</a> i akceptuję jego warunki. </label>
                    @error('regulamin')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ url('koszyk') }}" class="btn btn-lg btn-dark mb-3"> WRÓĆ DO KOSZYKA </a>
                <button type="submit" class="btn btn-lg btn-success ml-md-3 ml-0 mb-4 font-weight-bold"
                    data-toggle="tooltip" id="finish">
                    PODSUMOWANIE </button>

            </form>
        </div>


        <!-- 

            Podsumowanie


        -->

        <div class="col-xl-3 col-md-4 col-sm-9 col-11 summary" style="position: sticky">
            <p class="font-weight-bold mb-2 text-center" style="font-size: 17px;"> PODSUMOWANIE </p>
            <p class="mb-0 font-weight-bold"> Produkty: </p>
            @foreach ($products as $product)
            <p class="mb-0 txt"> {{ $product->nazwa }} - {{ $product->amount }} szt. -
                <span class="text-green"> {{ number_format($product->cena*$product->amount, 2, '.', '') }} zł </span>
            </p>
            @endforeach

            <p class="mb-0 font-weight-bold mt-2"> Łączna wartość produktów: </p>
            <p class="mb-0 txt"> <span class="text-green"> {{ $totalProducts }} zł </span> </p>

            <p class="mb-0 font-weight-bold mt-2"> Sposób wysyłki: </p>
            <p class="mb-0 txt"> {{ session()->get('delivery') }} - <span class="text-green"> {{ $delivery }} zł </span>
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

<script>
    document.getElementById('faktura').style.display = 'none';
    document.getElementById('textArea').style.display = 'none';

    function showPassword(checkbox){
        if(checkbox.checked == true){
            document.getElementById('password').style.display = 'block';
        }else{
            document.getElementById('password').style.display = 'none';
        }
    }

    function showFaktura(checkbox){
        if(checkbox.id == 'Radios2'){
            document.getElementById('faktura').style.display = 'block';
            document.getElementById('form').action = '/summaryOrderFaktura';
        }else{
            document.getElementById('faktura').style.display = 'none';
            document.getElementById('form').action = '/summaryOrder';
        }
    }

    function showComments(checkbox){
        if(checkbox.checked == true){
            document.getElementById('textArea').style.display = 'block';
        }else{
            document.getElementById('textArea').style.display = 'none';
        }
    }

    function copyData(){
        document.getElementById('city2').value = document.getElementById('city').value
        document.getElementById('street2').value = document.getElementById('street').value
        document.getElementById('numberOfFlat2').value = document.getElementById('numberOfFlat').value
        document.getElementById('zip2').value = document.getElementById('zip').value
    }
    
document.getElementById('password').style.display = 'none';
</script>

@endsection