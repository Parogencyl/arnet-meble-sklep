<?php

    $product = DB::table('products')->where('nazwa', Request::segment(5))->first();

    $columns = DB::getSchemaBuilder()->getColumnListing('products');
    unset($columns[count($columns)-1]);
    unset($columns[count($columns)-1]);
    unset($columns[0]);
    $columns = array_values($columns);

?>

@extends('layouts.adminNav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endsection

@section('content')
@yield('style')

<section class="container mb-3 mt-5">

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

        <form action="/admin/product/manage" method="POST" class="col-12" enctype="multipart/form-data">
            @csrf
            <input class="d-none" name="id" value="{{ $product->id }}">
            <input class="d-none" name="category" value="{{ Request::segment(3) }}">
            <input class="d-none" name="subcategory" value="{{ Request::segment(4) }}">
            <input class="d-none" name="nazwa" value="{{ $product->nazwa }}">

            <div class="row justify-content-center">
                <div class="col-12 text-center font-weight-bold mb-3 py-2"
                    style="background-color: rgb(219, 219, 219); font-size: 20px;">
                    Cechy produktu
                </div>

                @for ($i = 0; $i < count($columns); $i++) <div class="d-none"> {{ $name = $columns[$i] }}
            </div>
            @if ($product->$name && str_contains($name, 'zdjecie'))
            <div class="col-md-2 col-5 font-weight-bold tableText text-md-right text-center pr-0">
                {{ ucfirst($name) }}:
            </div>
            <img src="{{ $product->$name }}" alt="mebel" class="w-100 col-1 d-sm-none d-md-block"
                style="cursor: zoom-in">
            @else
            @if (str_contains($name, 'zdjecie'))
            <div class="col-md-2 col-5 font-weight-bold tableText text-md-right text-center pr-md-5 pr-1">
                {{ ucfirst($name) }}:
            </div>
            @else
            <div class="col-md-2 col-5 col font-weight-bold tableText text-md-right text-center pr-md-5 pr-1">
                {{ ucfirst($name) }}:
            </div>
            @endif
            @endif

            @if (str_contains($name, 'zdjecie'))
            <input type="file" name="{{ $name }}" class="col-md-6 tableText" />
            @else

            @if ($name == 'opis')
            <textarea name="{{ $name }}" class="col-md-6 tableText @error($name) is-invalid @enderror"
                rows="6">{{ ucfirst($product->$name) }}</textarea>
            @error($name)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @else

            @if($name == 'rodzaj')
            <input type="text" name="{{ $name }}" class="col-md-6 tableText" value="{{ ucfirst($product->$name) }}"
                disabled />
            @else

            @if($name == 'kategoria')
            <input type="text" name="{{ $name }}" class="col-md-6 tableText" value="{{ ucfirst($product->$name) }}"
                disabled />
            @else

            @if($name == 'nazwa')
            <input type="text" name="" class="col-md-6 tableText" value="{{ ucfirst($product->$name) }}" disabled />
            @else

            <input type="text" name="{{ $name }}" class="col-md-6 tableText @error($name) is-invalid @enderror"
                value="{{ ucfirst($product->$name) }}" />
            @error($name)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @endif
            @endif
            @endif
            @endif
            @endif
            <hr class="col-11">
            @endfor

            <button type="submit" name="submite" value="save" class="btn btn-lg btn-success mr-5"> Zapisz </button>
            <button type="submit" name="submite" value="delete" class="btn btn-lg btn-danger"> Usuń </button>
        </form>
    </div>

</section>

@endsection