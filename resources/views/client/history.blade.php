<?php
    $history = DB::table('user_history')->where('user_id', Auth::user()->id)->orderByDesc('bought_at')->get();
    
    $users = DB::table('users')->where('id', Auth::user()->id)->get();
    $users = json_decode( json_encode($users[0]), true);
    $name = $users['name'];
    if($name == null){
        $name = 'Klient'.$users['id'];
    }

    $price = 0;
    if (count($history)) {
        for ($i=0; $i < count($history); $i++) { 
            $elements[$i] = json_decode( json_encode($history[$i]), true);
        }
    
        for ($i=0; $i < count($elements); $i++) { 
            $price += $elements[$i]['price'];
            $price += $elements[$i]['price_delivery'];
        }
    }
?>

@extends('layouts.nav')

@section('style')
<style>
    .element {
        background-color: rgb(230, 230, 230);
        border-radius: 5px;
    }

    p {
        font-size: 16px;
    }

    span {
        font-size: 16px;
    }

    form .btn-danger {
        opacity: 0.8;
        transition: 0.5s;
    }

    form .btn-danger:hover {
        opacity: 1;
    }

    input {
        padding: 3px;
    }

    input:focus {
        border: 1px solid red;
    }

    #addressTitle a {
        color: #212529;
        text-decoration: none;
    }

    #addressTitle a i {
        transition: 1s;
    }

    .product {
        font-size: 18px;
    }

    .evaluation i {
        font-size: 28px;
    }

    .fa-star {
        color: rgb(209, 209, 0);
    }
</style>
@endsection

@section('content')
@yield('style')
<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> Historia zakupów </h1>

<div class="container pb-5">
    <div class="row justify-content-center">
        @include('layouts.clientNav')

        <div class="col-sm col-11 ml-sm-5 px-0">

            <div class="element mb-3 border p-3">
                <p class="mb-0"> Łączna wartość zakupów: <b class="pl-2"> {{$price}} zł </b> </p>
            </div>

            @if (count($history))

            @foreach ($history as $item)

            <div class="element mb-3 border pl-3 pt-3 pr-3">
                <p class="mb-3">Data zakupu: <span class="font-weight-bold"> {{ $item->bought_at }} </span> </p>

                <div class="row justify-content-center align-items-center px-3">
                    <div class="">
                        <img src="{{ asset($item->image) }}" alt="" style="width: 100px">
                    </div>
                    <div class="col-sm-11 col-md px-0 px-md-3 px-lg-5">
                        <p class="my-3 text-md-left text-center font-weight-bold" class="product"> {{ $item->product }}
                        </p>
                    </div>
                    <div class="ml-md-auto ml-0">
                        <p class="m-0 font-weight-bold text-dark" style="font-size: 22px"> <span
                                style="font-size: 22px"> {{ $item->price+$item->price_delivery }} </span> zł </p>
                    </div>
                </div>
                <hr class="mt-4 mb-3">
                <div class="row px-3 pb-3" class="options">
                    <span class="font-weight-bold px-3 mb-0" onclick="details({{ $loop->index }})"
                        style="cursor: pointer; color: rgb(97, 0, 0);"> SZCZEGÓŁY </span>
                    <span class="font-weight-bold px-3 mb-0" onclick="evaluation({{ $loop->index }})"
                        style="cursor: pointer; color: rgb(97, 0, 0);"> OCENA </span>
                    </span>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @if ($message = Session::get('errorDelete'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <div class="details pb-3 px-3 row">
                    <div class="col-md-6 col-11 mx-auto">
                        <p class="font-weight-bold mb-1 text-md-left text-center"> Dane do wysyłki </p>
                        <p class="mb-1 text-md-left text-center"> {{ $item->name }} {{ $item->surname }} </p>
                        <p class="mb-1 text-md-left text-center"> {{ $item->street }} {{ $item->local_number }} </p>
                        <p class="mb-1 text-md-left text-center"> {{ $item->zip }} {{ $item->city }} </p>
                        <p class="mb-1 text-md-left text-center"> <span class="font-weight-bold"> Tel: </span>
                            {{ $item->phone }} </p>
                    </div>

                    <div class="col-md-6 col-11 mx-auto mt-3 mt-md-0">
                        <p class="font-weight-bold mb-1 text-md-left text-center"> Numer zamówienia </p>
                        <p class="text-md-left text-center"> {{ $item->delivery_number }} </p>
                    </div>
                </div>

                <div class="evaluation px-3 mx-auto">

                    <!-- Wyświetlanie opinii -->

                    @if ($item->evaluation)
                    <p style="cursor: pointer">
                        @switch($item->evaluation)
                        @case(1)
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="far fa-star"></i>
                        </span>
                        <span class="three"> <i class="far fa-star"></i>
                        </span>
                        <span class="four"> <i class="far fa-star"></i>
                        </span>
                        <span class="five"> <i class="far fa-star"></i>
                        </span>
                        @break
                        @case(2)
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="fas fa-star"></i>
                        </span>
                        <span class="three"> <i class="far fa-star"></i>
                        </span>
                        <span class="four"> <i class="far fa-star"></i>
                        </span>
                        <span class="five"> <i class="far fa-star"></i>
                        </span>
                        @break
                        @case(3)
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="fas fa-star"></i>
                        </span>
                        <span class="three"> <i class="fas fa-star"></i>
                        </span>
                        <span class="four"> <i class="far fa-star"></i>
                        </span>
                        <span class="five"> <i class="far fa-star"></i>
                        </span>
                        @break
                        @case(4)
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="fas fa-star"></i>
                        </span>
                        <span class="three"> <i class="fas fa-star"></i>
                        </span>
                        <span class="four"> <i class="fas fa-star"></i>
                        </span>
                        <span class="five"> <i class="far fa-star"></i>
                        </span>
                        @break
                        @case(5)
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="fas fa-star"></i>
                        </span>
                        <span class="three"> <i class="fas fa-star"></i>
                        </span>
                        <span class="four"> <i class="fas fa-star"></i>
                        </span>
                        <span class="five"> <i class="fas fa-star"></i>
                        </span>
                        @break
                        @default
                        <span class="one"> <i class="fas fa-star"></i>
                        </span>
                        <span class="two"> <i class="far fa-star"></i>
                        </span>
                        <span class="three"> <i class="far fa-star"></i>
                        </span>
                        <span class="four"> <i class="far fa-star"></i>
                        </span>
                        <span class="five"> <i class="far fa-star"></i>
                        </span>
                        @endswitch
                    </p>
                    <p style="font-size: 18px" class="font-weight-bold"> {{ $item->comment }} </p>
                    <p class="d-none note"> </p>

                    <form action="{{ route('client/deleteOpinion') }}" method="POST">
                        @csrf
                        <input type="text" name="element" value="{{ $item->id }}" class="d-none">
                        <input type="number" name="evaluationId" value="{{ $item->opinion_id }}" class="d-none note">
                        <button type="submit" class="btn btn-lg btn-danger mt-3 mb-3"> Usuń komentarz </button>
                    </form>

                    @else

                    <!-- Dodanie opinii -->

                    <form action="{{ route('client/addOpinion') }}" method="POST">
                        @csrf
                        <p style="cursor: pointer">
                            <span class="one" onmouseover="starOne({{$loop->index}})"> <i class="fas fa-star"></i>
                            </span>
                            <span class="two" onmouseover="starTwo({{$loop->index}})"> <i class="far fa-star"></i>
                            </span>
                            <span class="three" onmouseover="starThree({{$loop->index}})"> <i class="far fa-star"></i>
                            </span>
                            <span class="four" onmouseover="starFour({{$loop->index}})"> <i class="far fa-star"></i>
                            </span>
                            <span class="five" onmouseover="starFive({{$loop->index}})"> <i class="far fa-star"></i>
                            </span>
                        </p>

                        <input type="number" name="evaluation" value="1" class="d-none note">
                        <input type="text" name="element" value="{{ $item->id }}" class="d-none">
                        <input type="text" name="product" value="{{ $item->product }}" class="d-none">
                        <input type="text" name="image" value="{{ $item->image }}" class="d-none">
                        <input type="text" name="name" value="{{ $name }}" class="d-none">

                        <textarea class="form-control" name="comment" placeholder="Twoja opinia"></textarea>
                        <button type="submit" class="btn btn-lg btn-success mt-3 mb-3"> DODAJ </button>
                    </form>
                    @if ($message = Session::get('errorAdd'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif
                </div>

            </div>

            @endforeach

            @else

            <div class="element mb-3 border border-danger p-3 mx-2">
                <p class="font-weight-bold mb-0 text-center" style="font-size: 22px"> Nie został zakupiony żaden
                    produkt. </p>
            </div>

            @endif

        </div>
    </div>
</div>

<script>
    for (let i = 0; i < $('.details').length; i++) {
        $('.details').eq(i).hide();
        $('.evaluation').eq(i).hide();
    }

    function details(element){
        if($('.evaluation').eq(element).is(':hidden')){
            if($('.details').eq(element).is(':hidden')){
                $('.details').eq(element).show(1000);
            }else{
                $('.details').eq(element).hide(1000);
            }
        } else {
            $('.evaluation').eq(element).hide(1000)
            setTimeout( function () {
                $('.details').eq(element).show(1000)
            }, 1000);
        }
    }

    function evaluation(element){
        if($('.details').eq(element).is(':hidden')){
            if($('.evaluation').eq(element).is(':hidden')){
                $('.evaluation').eq(element).show(1000);
            }else{
                $('.evaluation').eq(element).hide(1000);
            }
        } else {
            $('.details').eq(element).hide(1000)
            setTimeout( function () {
                $('.evaluation').eq(element).show(1000)
            }, 1000);
        }
    }

    function starOne(element){
        $('.one').eq(element).html('<i class="fas fa-star"></i>');
        $('.two').eq(element).html('<i class="far fa-star"></i>');
        $('.three').eq(element).html('<i class="far fa-star"></i>');
        $('.four').eq(element).html('<i class="far fa-star"></i>');
        $('.five').eq(element).html('<i class="far fa-star"></i>');
        $('.note').eq(element).val(1);
    }

    function starTwo(element){
        $('.one').eq(element).html('<i class="fas fa-star"></i>');
        $('.two').eq(element).html('<i class="fas fa-star"></i>');
        $('.three').eq(element).html('<i class="far fa-star"></i>');
        $('.four').eq(element).html('<i class="far fa-star"></i>');
        $('.five').eq(element).html('<i class="far fa-star"></i>');
        $('.note').eq(element).val(2);
    }

    function starThree(element){
        $('.one').eq(element).html('<i class="fas fa-star"></i>');
        $('.two').eq(element).html('<i class="fas fa-star"></i>');
        $('.three').eq(element).html('<i class="fas fa-star"></i>');
        $('.four').eq(element).html('<i class="far fa-star"></i>');
        $('.five').eq(element).html('<i class="far fa-star"></i>');
        $('.note').eq(element).val(3);
    }

    function starFour(element){
        $('.one').eq(element).html('<i class="fas fa-star"></i>');
        $('.two').eq(element).html('<i class="fas fa-star"></i>');
        $('.three').eq(element).html('<i class="fas fa-star"></i>');
        $('.four').eq(element).html('<i class="fas fa-star"></i>');
        $('.five').eq(element).html('<i class="far fa-star"></i>');
        $('.note').eq(element).val(4);
    }

    function starFive(element){
        $('.one').eq(element).html('<i class="fas fa-star"></i>');
        $('.two').eq(element).html('<i class="fas fa-star"></i>');
        $('.three').eq(element).html('<i class="fas fa-star"></i>');
        $('.four').eq(element).html('<i class="fas fa-star"></i>');
        $('.five').eq(element).html('<i class="fas fa-star"></i>');
        $('.note').eq(element).val(5);
    }

</script>

@endsection