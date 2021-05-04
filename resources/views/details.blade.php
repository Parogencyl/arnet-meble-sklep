<?php

    $product = DB::table('products')->where('nazwa', Request::segment(4))->first();

    $amountCart = 0;
    
    if (Auth::user()) {
        $userFavorite = DB::table('users_favorite')->where('user_id', Auth::user()->id)->where('kategoria_id', $product->id)->first();
        if (DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $product->id)->first()) {
            $amountCart = DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $product->id)->first();
            $amountCart = $amountCart->amount;
        }
    }else {
        if (session()->get('cart')) {
            foreach (session()->get('cart') as $element) {
                if ($product->id == $element->id) {
                    $amountCart = $element->amount;
                    break;
                }
            }
        }
    }
    
    $isFavorite = false;
    if(session()->get('favorites')){
        for ($i=0; $i < count(session('favorites')); $i++) { 
            if(session()->get('favorites')[$i] == $product->id){
                $isFavorite = true;
                break;
            } 
        }
    }
    
    ?>

@extends('layouts.nav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endsection

@section('content')
@yield('style')

<section class="container mb-3 mt-5">

    <div class="row justify-content-sm-start justify-content-center">

        <div id="images" class="col-sm-12 col-md-5 col-xl-6">
            <img data-enlargeable src="{{ $product->zdjecie1 }}" alt="mebel" id="mainPhoto" class="w-100"
                style="cursor: zoom-in">
            <div class="row justify-content-center mt-2">
                <img width="100" src="{{ $product->zdjecie1 }}" alt="mebel" class="col-2 w-100"
                    onclick="changePhoto(this)">
                @if ($product->zdjecie2)
                <img width="100" src="{{ $product->zdjecie2 }}" alt="mebel" class="col-2 w-100"
                    onclick="changePhoto(this)">
                @endif
                @if ($product->zdjecie3)
                <img width="100" src="{{ $product->zdjecie3 }}" alt="mebel" class="col-2 w-100"
                    onclick="changePhoto(this)">
                @endif
                @if ($product->zdjecie4)
                <img width="100" src="{{ $product->zdjecie4 }}" alt="mebel" class="col-2 w-100"
                    onclick="changePhoto(this)">
                @endif
                @if ($product->zdjecie5)
                <img width="100" src="{{ $product->zdjecie5 }}" alt="mebel" class="col-2 w-100"
                    onclick="changePhoto(this)">
                @endif
            </div>
        </div>

        <div class="col-sm-12 col-md-7 col-xl-6 mt-4 mt-md-0">
            <h2 class="font-weight-bold mb-5"> {{ ucfirst($product->nazwa) }}</h2>
            @if ($product->stara_cena)
            <p class="card-text text-right font-weight-bold mb-1 text-success"> <del style="font-size: 1rem;"
                    class="text-dark mr-2"> {{ $product->stara_cena }} zł </del> {{ $product->cena }}
                zł </p>
            @else
            <p class="card-text text-right font-weight-bold mb-1 text-dark"> {{ $product->cena }} zł </p>
            @endif

            <p class="card-text text-right font-weight-bold mb-1 text-dark" style="font-size: 14px"> <span
                    class="text-muted">
                    Koszt dostawy do {{ $product->ilosc_w_paczce }} szt. </span> {{ $product->koszt_wysylki }} zł
            </p>

            <div class="row mt-5 justify-content-center">

                <div class="col-5 col-md-3 mb-4 mb-md-0 p-0 d-flex align-items-center">
                    <div class="row m-0 p-0" style="border: solid black 1px; border-radius: 5px;">
                        <div class="col-3 p-0 text-center amount user-select-none" id="minus" onclick="minus()">
                            -
                        </div>

                        <div class="col-6 p-0 d-flex align-items-stretch">
                            <input type="number" value="1" step="1" min="1" name="amount" id="amount"
                                class="text-center">
                        </div>

                        <div class="col-3 p-0 text-center amount user-select-none"
                            onclick="plus({{$product->ilosc_dostepnych}}, {{$amountCart}})">
                            +
                        </div>
                    </div>
                </div>

                <div class="col-10 col-md-7 p-0 my-auto">
                    <form method="POST" action="/product/addToCard" class="mb-0">
                        @csrf
                        <input type="text" name="amount" value="1" id="amountForm" class="d-none">
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        @if ($product->ilosc_dostepnych && !($product->ilosc_dostepnych == $amountCart) &&
                        $product->w_sprzedazy) <button type="submit" class="btn btn-success btn-lg" id="addToCard"> <i
                                class="fas fa-shopping-basket mr-2 ">
                            </i>
                            Dodaj
                            do koszyka </button>
                        @else
                        <button type="submit" class="btn btn-success btn-lg" id="addToCard" disabled> <i
                                class="fas fa-shopping-basket mr-2">
                            </i>
                            Dodaj
                            do koszyka </button>
                        @endif
                    </form>
                </div>

                <div class="col-2 col-md-1 p-0 d-flex align-items-center">
                    @if(Auth::user())

                    @if($userFavorite)

                    <form action="/product/deleteFromFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="fas fa-heart"></i> </button>
                    </form>

                    @else

                    <form action="/product/addToFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                    </form>

                    @endif

                    @else

                    @if($isFavorite)

                    <form action="/product/deleteFromFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="fas fa-heart"></i> </button>
                    </form>

                    @else

                    <form action="/product/addToFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                    </form>

                    @endif

                    @endif
                </div>

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

            </div>

            <div class="pt-3">
                <a href="{{ url('/kontakt') }}" class="text-decoration-none text-dark"><i class="fas fa-envelope"></i>
                    Skontaktuj się z nami.</a>
            </div>

            @if (!$product->ilosc_dostepnych)
            <div class="text-danger text-center font-weight-bold mt-5" style="font-size: 24px;"> PRODUKT NIEDOSTĘPNY
            </div>
            @endif

        </div>

    </div>

    <hr class="my-5">

    <div class="row">
        <div class="col-12 col-md-7 mb-5 mb-md-0 description text-justify">
            <div class="pr-4">
                {!! ucfirst(nl2br(e($product->opis))) !!}
            </div>
        </div>

        <div class="col-12 col-md-5">
            <div class="row">
                <div class="col-12 text-center font-weight-bold mb-3 py-2"
                    style="background-color: rgb(219, 219, 219); font-size: 20px;">
                    Cechy produktu
                </div>

                <div class="col-6 font-weight-bold tableText"> Kategoria </div>
                <div class="col-6 tableText"> {{ ucfirst(Request::segment(2)) }} </div>
                <hr class="col-11">

                <div class="col-6 tableText font-weight-bold"> Asortyment </div>
                <div class="col-6 tableText"> {{ ucfirst($product->kategoria) }} </div>
                <hr class="col-11">

                @if ($product->wysokosc)
                <div class="col-6 tableText font-weight-bold"> Wysokość </div>
                <div class="col-6 tableText"> {{ $product->wysokosc }} cm </div>
                <hr class="col-11">
                @endif

                @if ($product->szerokosc)
                <div class="col-6 tableText font-weight-bold"> Szerokość </div>
                <div class="col-6 tableText"> {{ $product->szerokosc }} cm</div>
                <hr class="col-11">
                @endif

                @if ($product->glebokosc)
                <div class="col-6 tableText font-weight-bold"> Głębokość </div>
                <div class="col-6 tableText"> {{ $product->glebokosc }} cm</div>
                <hr class="col-11">
                @endif

                @if ($product->kolor)
                <div class="col-6 tableText font-weight-bold"> Kolor </div>
                <div class="col-6 tableText"> {{ ucfirst($product->kolor) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->material)
                <div class="col-6 tableText font-weight-bold"> Materiał </div>
                <div class="col-6 tableText"> {{ ucfirst($product->material) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->waga)
                <div class="col-6 tableText font-weight-bold"> Waga </div>
                <div class="col-6 tableText"> {{ $product->waga }} kg </div>
                <hr class="col-11">
                @endif

                @if ($product->szuflada)
                <div class="col-6 tableText font-weight-bold"> Szulfada </div>
                <div class="col-6 tableText"> {{ ucfirst($product->szuflada) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->front)
                <div class="col-6 tableText font-weight-bold"> Front </div>
                <div class="col-6 tableText"> {{ ucfirst($product->front) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->korpus)
                <div class="col-6 tableText font-weight-bold"> Korpus </div>
                <div class="col-6 tableText"> {{ ucfirst($product->korpus) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->blat)
                <div class="col-6 tableText font-weight-bold"> Blat </div>
                <div class="col-6 tableText"> {{ ucfirst($product->blat) }} </div>
                <hr class="col-11">
                @endif

                @if ($product->rozstaw)
                <div class="col-6 tableText font-weight-bold"> Rozstaw </div>
                <div class="col-6 tableText"> {{ ucfirst($product->rozstaw) }} </div>
                <hr class="col-11">
                @endif

            </div>
        </div>
    </div>

</section>

<script>
    // Zamiana zdjęć
    function changePhoto(element){
        document.getElementById('mainPhoto').src = element.src;
    }

    // Dodawanie odejmowanie ilości

    function plus(available, amount){
        if(amount+Number(document.getElementById('amount').value) < available){
        if(available > Number(document.getElementById('amount').value)){
            document.getElementById('amount').value = Number(document.getElementById('amount').value) + 1; 
            document.getElementById('amountForm').value = Number(document.getElementById('amount').value); 
        }
        }
    }
    function minus(){
        if(1 != Number(document.getElementById('amount').value)){
            document.getElementById('amount').value = Number(document.getElementById('amount').value) - 1; 
            document.getElementById('amountForm').value = Number(document.getElementById('amount').value); 
        }
    }

    document.getElementById('amount').addEventListener('focusout',  () => {
        var value = Number(document.getElementById('amount').value);
        if(!Number.isInteger(value)){
            value = parseInt(value, 10);
            document.getElementById('amount').value = value;
            document.getElementById('amountForm').value = value;
        }
    });

    // Powiększanie zdjęcia

    $("img[data-enlargeable]").after();

$("img[data-enlargeable]")
    .addClass("img-enlargeable")
    .click(function() {
        var src = $(this).attr("src");
        var modal;
        function removeModal() {
            modal.remove();
            $("body").off("keyup.modal-close");
        }
        modal = $("<div>")
            .css({
                background: "RGBA(0,0,0,.5) url("+ src + ") no-repeat center",
                backgroundSize: "contain",
                width: "100%",
                height: "100%",
                position: "fixed",
                zIndex: "10000",
                top: "0",
                left: "0",
                cursor: "zoom-out"
            })
            .click(function() {
                removeModal();
            })
            .appendTo("body");
        //handling ESC
        $("body").on("keyup.modal-close", function(e) {
            if (e.key === "Escape") {
                removeModal();
            }
        });
    });
</script>

@endsection