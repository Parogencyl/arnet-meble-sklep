<?php

    $subcategory = $products = "";
    

    $category = Request::segment(3);
    
    if(Request::segment(4)){
        $subcategory = Request::segment(4);
        if( DB::table('products')->where('kategoria', $subcategory)->get()){
            $products = DB::table('products')->where('kategoria', $subcategory)->orderby('id', 'DESC')->paginate(31);
        }
    } else {
        $products = DB::table('products')->where('rodzaj', $category)->orderby('id', 'DESC')->paginate(31);
    }

?>

@extends('layouts.adminNav')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
<style>
    .add {
        border-color: rgb(0, 150, 0);
        border-width: 2px;
        transition: 0.5s;
        min-height: 250px;
    }

    .add i {
        color: rgb(0, 150, 0);
        transition: 0.5s;
    }

    .add:hover i {
        color: rgb(14, 112, 14);
    }

    .add:hover {
        border-color: rgb(14, 112, 14);
    }

    .backProduct {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(255, 0, 0, 0.315);
        z-index: 100;
    }

    .backButton {
        top: calc(50% - 30px);
        z-index: 101;
    }
</style>
@endsection

@section('content')
@yield('styles')
@if ($category == 'sprzet')

@if ($subcategory)

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold text-uppercase"> {{ $subcategory }} </h1>

@else

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold text-uppercase"> sprzęt agd </h1>

@endif

@else

@if ($subcategory)

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold text-uppercase"> {{ $subcategory }} </h1>

@else

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold text-uppercase"> {{ $category }} </h1>

@endif

@endif


<section class="container mb-3">

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

    @if(!$products->isEmpty())

    <div class="d-inline-block ml-auto form-group">
        <p class="mb-0 font-weight-bold">Sortuj według</p>

        <select name="sort" class="form-control">
            <option value="new"> Nowości </option>
            <option value="down"> Cena - od najmniejszeń </option>
            <option value="up"> Cena - od największej </option>
            <option value="most"> Najczęściej wybierane </option>
        </select>
    </div>

    <div class="row justify-content-sm-start justify-content-center">

        @if ($subcategory)
        <a href="{{ '/admin/dodaj_produkt'.'/'.$category.'/'.$subcategory.'/formularz' }}"
            class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item position-relative">
            @else
            <a href="{{ '/admin/dodaj_produkt'.'/'.$category.'/formularz' }}"
                class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
                @endif
                <div class="card w-100 add justify-content-center align-items-center">
                    <i class="fas fa-plus" style="font-size: 60px;"></i>
                </div>
            </a>

            @foreach ($products as $product)
            @if ($subcategory)
            <a href="{{ '/admin/produkty'.'/'.$category.'/'.$subcategory.'/'.$product->nazwa }}"
                class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item position-relative">
                @else
                <a href="{{ '/admin/produkty'.'/'.$category.'/'.lcfirst($product->kategoria).'/'.$product->nazwa }}"
                    class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
                    @endif

                    @if (!$product->w_sprzedazy)
                    <form action="/admin/product/restore" method="POST" class="position-absolute backProduct">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-lg btn-success backButton position-absolute">
                                Przywróć
                                do sprzedaży </button>
                        </div>
                    </form>
                    @endif

                    <div class="card">
                        <img src="{{ $product->zdjecie1 }}" class="card-img-top p-2"
                            alt="{{ ucfirst($product->nazwa) }}">
                        <div class="card-body bg-light pb-0">
                            <h5 class="card-title text-dark font-weight-bold mb-1"> {{ ucfirst($product->nazwa) }}
                            </h5>
                            @if ($product->stara_cena)
                            <p class="card-text text-right font-weight-bold mb-1 text-success"> <del
                                    style="font-size: 1rem;" class="text-dark mr-2"> {{ $product->stara_cena }} zł
                                </del>
                                {{ $product->cena }}
                                zł </p>
                            @else
                            <p class="card-text text-right font-weight-bold mb-1 text-dark"> {{ $product->cena }} zł
                            </p>
                            @endif
                        </div>
                        @if ($category == 'meble')
                        <div class="bg-light px-3 pb-2 pt-0">
                            <hr class="mb-2 mt-1">
                            <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;"> {{ $product->glebokosc }}
                                x
                                {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                        </div>
                        @endif
                        @if (!$product->ilosc_dostepnych)
                        <div class="text-danger text-center font-weight-bold" style="font-size: 20px;"> NIEDOSTĘPNY
                        </div>
                        @endif

                        @if ($product->stara_cena)
                        <div class="promotion text-success"> PROMOCJA </div>
                        @endif

                        <form action="/admin/product/delete" method="POST" class="mb-0">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                            <button class="border-0 favorites text-success"> <i class="fas fa-trash-alt"
                                    style="color:red"></i> </button>
                        </form>

                    </div>
                </a>
                @endforeach


    </div>

    <div class="d-flex justify-content-center mx-auto mt-4 mb-3" id="pagination">
        {{ $products->render() }}
    </div>

    @else

    @if ($subcategory)
    <a href="{{ '/admin/dodaj_produkt'.'/'.$category.'/'.$subcategory.'/formularz' }}"
        class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item position-relative">
        @else
        <a href="{{ '/admin/dodaj_produkt'.'/'.$category.'/formularz' }}"
            class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
            @endif
            <div class="card w-100 add justify-content-center align-items-center">
                <i class="fas fa-plus" style="font-size: 60px;"></i>
            </div>
        </a>

        @endif

</section>


@endsection