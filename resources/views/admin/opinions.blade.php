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
?>

@extends('layouts.adminNav')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/opinions.css') }}">
@endsection

@section('content')
@yield('styles')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold"> OPINIE </h1>

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

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block my-5">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block my-5">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

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
            <div class="col-12 my-2 py-1 text-center delete">
                <form action="{{ route('admin/deleteComment') }}" method="POST" class="mb-0">
                    @csrf
                    <input type="text" name="accepted" value="0" class="d-none">
                    <input type="text" name="idComment" value="{{ $opinion->id }}" class="d-none">
                    <button type="submit" class="border-0" style="background-color: rgb(200, 200, 200)"><i
                            class="fas fa-trash-alt" style="color:red"> </i>
                    </button>
                </form>
            </div>
            @else
            <div class="comment col-12 py-4 row m-0" style="background-color: rgba(255, 0, 0, 0.3)">
                <div class="col-12 my-2 py-1 text-center delete">
                    <form action="{{ route('admin/addComment') }}" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="accepted" value="1" class="d-none">
                        <input type="text" name="idComment" value="{{ $opinion->id }}" class="d-none">
                        <button type="submit" class="border-0" style="background-color: rgb(200, 200, 200)"><i
                                class="fas fa-plus" style="color:green"> </i> </button>
                    </form>
                </div>
                @endif

                <div class="col-sm-4 col-md-2">
                    <b> {{ $opinion->name }} </b>
                    <br>
                    {{ $opinion->added_at }}
                </div>
                <div class="col-sm-3 col-md-3 justify-content-center">
                    <img src="{{ asset($opinion->image) }}" alt="{{ $opinion->product }}"
                        class="w-50 d-block mx-auto mb-3">
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


            @endforeach

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mx-auto mt-4 mb-3" id="pagination">
                {{ $opinions->render() }}
            </div>

        </div>

</section>
@endsection