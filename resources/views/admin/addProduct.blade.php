<?php

    $categoryMeble = DB::table('menu_category')->where('kategoria', 'meble')->get();
    $categoryAkcesoria = DB::table('menu_category')->where('kategoria', 'akcesoria')->get();
    $categoryAgd = DB::table('menu_category')->where('kategoria', 'agd')->get();

    $columns = DB::getSchemaBuilder()->getColumnListing('products');
    unset($columns[0]);
    unset($columns[count($columns)]);
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

    <div class="row justify-content-sm-start justify-content-center">

        <form action="/admin/product/add" method="POST" class="col-12" enctype="multipart/form-data">
            @csrf

            <div class="row justify-content-center">
                <div class="col-12 text-center font-weight-bold mb-3 py-2"
                    style="background-color: rgb(219, 219, 219); font-size: 20px;">
                    Cechy produktu
                </div>

                @for ($i = 0; $i < count($columns); $i++) <div class="d-none"> {{ $name = $columns[$i] }}
            </div>

            <div class="col-md-2 col-5 col font-weight-bold tableText text-md-right text-center pr-md-4 pr-1">
                @if ($name == 'rodzaj' || $name == 'kategoria' || $name == 'nazwa' || $name == 'cena' || $name ==
                'koszt_wysylki' || $name == 'ilosc_w_paczce' || $name == 'ilosc_dostepnych' || $name == 'zdjecie1' ||
                $name == 'opis')
                {{ ucfirst($name) }}<span class="text-danger">*</span> :
                @else
                {{ ucfirst($name) }}:
                @endif
            </div>

            @if (str_contains($name, 'zdjecie'))
            <input type="file" name="{{ $name }}" class="col-md-6 tableText" />
            @else

            @if ($name == 'opis')
            <textarea name="{{ $name }}" class="col-md-6 tableText @error($name) is-invalid @enderror"
                rows="6">{{ old($name) }}</textarea>
            @error($name)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @else

            @if($name == 'rodzaj')
            <input type="text" name="" class="col-md-6 tableText" value="{{ ucfirst(Request::segment(3)) }}" disabled />
            <input type="text" name="rodzaj" class="d-none" value="{{ Request::segment(3) }}" />
            @else

            @if($name == 'kategoria')
            @if (Request::segment(4) != 'formularz')
            <input type="text" name="" class="col-md-6 tableText @error($name) is-invalid @enderror"
                value="{{ Request::segment(4) }}" disabled />
            <input type="text" name="kategoria" class="d-none" value="{{ Request::segment(4) }}" />
            @else
            @if (Request::segment(3) == 'meble')
            <select name="{{ $name }}" class="col-md-6 tableText">
                @foreach($categoryMeble as $category)
                <option value="{{ $category->typ }}"> {{ ucfirst($category->typ) }} </option>
                @endforeach
            </select>
            @elseif(Request::segment(3) == 'akcesoria')
            <select name="{{ $name }}" class="col-md-6 tableText">
                @foreach($categoryAkcesoria as $category)
                <option value="{{ $category->typ }}"> {{ ucfirst($category->typ) }} </option>
                @endforeach
            </select>
            @else
            <select name="{{ $name }}" class="col-md-6 tableText">
                @foreach($categoryAgd as $category)
                <option value="{{ $category->typ }}"> {{ ucfirst($category->typ) }} </option>
                @endforeach
            </select>
            @endif
            @endif
            @else

            <input type="text" name="{{ $name }}" class="col-md-6 tableText @error($name) is-invalid @enderror"
                value="{{ old($name) }}" />
            @error($name)
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @endif
            @endif
            @endif
            @endif
            <hr class="col-11">
            @endfor

            <button type="submit" class="btn btn-lg btn-success mr-5"> Zapisz </button>
    </div>
    </form>

</section>

@endsection