<?php
    $opinions = DB::table('opinions')->orderby('id', 'desc')->paginate(10);
    
    $opinionsGet = DB::table('opinions')->orderby('id', 'desc')->get();

    $number = count($opinionsGet);

    for ($i=0; $i < $number; $i++) { 
        $comments[$i] = json_decode( json_encode($opinionsGet[$i]), true);
    }

    $positive = $negative = $neutral = 0;
    for ($i=0; $i < $number; $i++) { 
        if($comments[$i]['accepted']){
            if($comments[$i]['evaluation'] > 3){
                $positive++; 
            } else if($comments[$i]['evaluation'] == 3){
                $neutral++;
            } else {
                $negative++;
            }
        }
    }

    $number = $positive + $negative + $neutral;
?>

@extends('layouts.nav')

<style>
    #statystic {
        background-color: rgb(200, 200, 200);
        border-radius: 5px;
    }

    div span {
        font-size: 16px;
    }

    #commentNav {
        border-radius: 5px;
        background-color: rgb(99, 99, 99);
        color: white;
    }

    .fa-star {
        color: rgb(209, 209, 0);
        font-size: 18px;
    }

    .underline {
        width: 100%;
        height: 1px;
        background-color: rgb(73, 73, 73);
    }

    #pagination>nav>div>div>p {
        display: none;
    }

    #pagination>nav>div>span {
        display: none;
    }

    #pagination>nav>div>a {
        display: none;
    }

    #pagination svg {
        width: 30px;
        display: inline-block;
        margin-top: 5px;
    }

    #pagination span>span>span {
        color: black;
        background-color: rgb(200, 200, 200) !important;
        font-weight: bold;
        display: inline-block;
        margin-top: 5px;
    }

    #pagination div>span>a {
        color: white;
        background-color: rgb(73, 73, 73) !important;
        transition: 0.4s;
    }

    #pagination div>span>a:hover {
        color: white;
        background-color: rgb(109, 109, 109) !important;
    }

    #pagination a {
        text-decoration: none;
    }

    #pagination div>span>a {
        display: inline-block;
        margin-top: 5px;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold"> OPINIE </h1>

<section class="container">

    <div class="text-center py-3 px-1 row" id="statystic">
        <div class="col-6 col-sm"> <span class="font-weight-bold"> Opinie: {{ $number }} </span> </div>
        <div class="col-6 col-sm"> <span class="ml-3 font-weight-bold text-success"> Pozytywne: {{ $positive }}
            </span> </div>
        <div class="col-6 col-sm"> <span class="ml-3 font-weight-bold text-white"> Neutralne: {{ $neutral }}
            </span> </div>
        <div class="col-6 col-sm"><span class="ml-3 font-weight-bold text-danger"> Negatywne: {{ $negative }}
            </span>
        </div>
    </div>

    <div class="row mt-3">
        <div id="commentNav" class="col-12 py-2 row m-0">
            <div class="d-none d-sm-block col-sm-4 col-md-2 font-weight-bold">
                Komentował/a
            </div>
            <div class="d-none d-sm-block col-sm-3 col-md-3 font-weight-bold">
                Produkt
            </div>
            <div class="d-none d-sm-block col-sm-5 col-md-2 font-weight-bold">
                Ocena
            </div>
            <div class="d-none d-md-block col-md-5 font-weight-bold">
                Opinia
            </div>
            <div class="d-block d-sm-none font-weight-bold">
                Oceny
            </div>
        </div>

        @foreach ($opinions as $opinion)
        @if ($opinion->accepted)
        <div class="comment col-12 py-4 row m-0">
            <div class="col-sm-4 col-md-2">
                <b> {{ $opinion->name }} </b>
                <br>
                {{ $opinion->added_at }}
            </div>
            <div class="col-sm-3 col-md-3 justify-content-center">
                <img src="{{ asset($opinion->image) }}" alt="{{ $opinion->product }}" class="w-50 d-block mx-auto mb-3">
                <p class="text-center font-weight-bold mb-0" style="font-size: 1.1em"> {{ $opinion->product }} </p>
            </div>
            <div class="col-sm-5 col-md-2">
                <p style="cursor: pointer">
                    @switch($opinion->evaluation)
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
            </div>
            <div class="col-sm-12 col-md-5 mt-sm-3 mt-0">
                {{ $opinion->comment }}
            </div>
        </div>

        @if ($loop->iteration != $loop->count)
        <div class="underline"> </div>
        @endif

        @endif

        @endforeach

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mx-auto mt-4 mb-3" id="pagination">
            {!! $opinions->render() !!}
        </div>

    </div>

</section>
@endsection