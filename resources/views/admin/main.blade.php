<?php

    $menu = DB::table('menu_category')->get();

    for ($i=0; $i < count($menu); $i++) { 
        $category[$i] = json_decode( json_encode($menu[$i]), true); 
    }

?>

@extends('layouts.adminNav')

<style>
    span {
        font-size: 20px;
    }

    form button i {
        font-size: 20px;
    }
</style>

@section('content')

<div class="container">

    <h1 class="text-center font-weight-bold mb-5 mt-4"> Zarządzanie kategoriami </h1>

    <h3 class="text-center mt-5 font-weight-bold"> Dodaj kategorię </h3>

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

    <form action="admin/newCategory" method="POST">
        @csrf
        <span class="font-weight-bold mr-2"> Kategoria: </span>

        <select name="category" class="mb-3">
            <option value="meble"> Meble </option>
            <option value="agd"> Sprzęt AGD </option>
            <option value="akcesoria"> Akcesoria </option>
        </select>

        <input name="name" class="form-control " placeholder="Nazwa kategorii" required>

        <button type="submit" class="btn btn-lg btn-success mt-3"> Dodaj </button>
    </form>



    <h3 class="text-center mt-5 font-weight-bold"> Meble </h3>

    @foreach ($menu as $item)

    @if ($item->kategoria == "meble")

    <span> {{ $item->typ }} </span>
    <form action="admin/deleteCategory" method="POST" class="d-inline-block ml-3 mb-0">
        @csrf
        <input type="text" value="{{ $item->kategoria }}" name="kategoria" class="d-none">
        <input type="text" value="{{ $item->typ }}" name="typ" class="d-none">
        <button type="submit" class="border-0"> <i class="fas fa-trash-alt" style="color:red"> </i>
        </button>
    </form>

    <hr>

    @endif

    @endforeach


    <h3 class="text-center mt-5 font-weight-bold"> Sprzęt AGD </h3>

    @foreach ($menu as $item)

    @if ($item->kategoria == "agd")

    <span> {{ $item->typ }} </span>
    <form action="admin/deleteCategory" method="POST" class="d-inline-block ml-3 mb-0">
        @csrf
        <input type="text" value="{{ $item->kategoria }}" name="kategoria" class="d-none">
        <input type="text" value="{{ $item->typ }}" name="typ" class="d-none">
        <button type="submit" class="border-0"> <i class="fas fa-trash-alt" style="color:red"> </i>
        </button>
    </form>

    <hr>

    @endif

    @endforeach

    <h3 class="text-center mt-5 font-weight-bold"> Akcesoria </h3>

    @foreach ($menu as $item)

    @if ($item->kategoria == "akcesoria")

    <span> {{ $item->typ }} </span>
    <form action="admin/deleteCategory" method="POST" class="d-inline-block ml-3 mb-0">
        @csrf
        <input type="text" value="{{ $item->kategoria }}" name="kategoria" class="d-none">
        <input type="text" value="{{ $item->typ }}" name="typ" class="d-none">
        <button type="submit" class="border-0"> <i class="fas fa-trash-alt" style="color:red"> </i>
        </button>
    </form>

    <hr>

    @endif

    @endforeach

</div>


@endsection