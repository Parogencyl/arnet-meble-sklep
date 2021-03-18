<?php

    $userFavorite = "";

    if (Auth::user()) {
        $userFavorite = DB::table('users_favorite')->where('user_id', Auth::user()->id)->paginate(32);
    }

    if (session()->get('products')) {
        $products = session()->get('products');
    }
    if (session()->get('category')) {
        $category = session()->get('category');
    }
    if (session()->get('subcategory')) {
        $subcategory = session()->get('subcategory');
    } 
    if (session()->get('select')) {
        $select = session()->get('select');
    } 

?>

@extends('layouts.nav')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
@yield('styles')
@if ($category == 'sprzet')

@if ($subcategory)

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> {{ $subcategory }} </h1>

@else

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> sprzęt agd </h1>

@endif

@else

@if ($subcategory)

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> {{ $subcategory }} </h1>

@else

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> {{ $category }} </h1>

@endif

@endif


<section class="container mb-3">

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if(!$products->isEmpty())

    <div class="d-inline-block ml-auto form-group">
        <p class="mb-0 font-weight-bold">Sortuj według</p>

        @if ($subcategory)
        <form action="{{ '/product'.'/'.$category.'/'.$subcategory.'/sort' }}" method="POST">
            @else
            <form action="{{ '/product'.'/'.$category.'/sort' }}" method="POST">
                @endif
                @csrf
                <select name="sort" class="form-control" onchange="this.form.submit()">
                    @if ($select == 'new')
                    <option value="new" selected="selected"> Nowości </option>
                    <option value="down"> Cena - od najmniejszeń </option>
                    <option value="up"> Cena - od największej </option>
                    <option value="most"> Najczęściej wybierane </option>
                    @elseif($select == 'down')
                    <option value="new"> Nowości </option>
                    <option value="down" selected="selected"> Cena - od najmniejszeń </option>
                    <option value="up"> Cena - od największej </option>
                    <option value="most"> Najczęściej wybierane </option>
                    @elseif($select == 'up')
                    <option value="new"> Nowości </option>
                    <option value="down"> Cena - od najmniejszeń </option>
                    <option value="up" selected="selected"> Cena - od największej </option>
                    <option value="most"> Najczęściej wybierane </option>
                    @else
                    <option value="new"> Nowości </option>
                    <option value="down"> Cena - od najmniejszeń </option>
                    <option value="up"> Cena - od największej </option>
                    <option value="most" selected="selected"> Najczęściej wybierane </option>
                    @endif
                </select>
            </form>
    </div>

    <div class="row justify-content-sm-start justify-content-center">

        @foreach ($products as $product)
        @if ($subcategory)
        <a href="{{ '/produkty'.'/'.$category.'/'.$subcategory.'/'.$product->nazwa }}"
            class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item position-relative">
            @else
            <a href="{{ '/produkty'.'/'.$category.'/'.lcfirst($product->kategoria).'/'.$product->nazwa }}"
                class="col-11 col-sm-6 col-md-4 col-xl-3 mb-4 text-decoration-none d-flex align-items-stretch item">
                @endif

                <div class="card">
                    <img src="{{ asset($product->zdjecie1) }}" class="card-img-top p-2" alt="{{ $product->nazwa }}">
                    <div class="card-body bg-light pb-0">
                        <h5 class="card-title text-dark font-weight-bold mb-1"> {{ ucfirst($product->nazwa) }}
                        </h5>
                        @if ($product->stara_cena)
                        <p class="card-text text-right font-weight-bold mb-1 text-success"> <del
                                style="font-size: 1rem;" class="text-dark mr-2"> {{ $product->stara_cena }} zł </del>
                            {{ $product->cena }}
                            zł </p>
                        @else
                        <p class="card-text text-right font-weight-bold mb-1 text-dark"> {{ $product->cena }} zł </p>
                        @endif
                    </div>
                    @if ($product->glebokosc)
                    <div class="bg-light px-3 pb-2 pt-0">
                        <hr class="mb-2 mt-1">
                        <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;"> {{ $product->glebokosc }} x
                            {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                    </div>
                    @endif
                    @if (!$product->ilosc_dostepnych)
                    <div class="text-danger text-center font-weight-bold" style="font-size: 20px;"> NIEDOSTĘPNY </div>
                    @endif

                    @if ($product->stara_cena)
                    <div class="promotion text-success"> PROMOCJA </div>
                    @endif

                    @if(Auth::user())

                    @if($userFavorite->isEmpty())

                    <form action="/product/addToFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                    </form>

                    @else

                    @foreach ($userFavorite as $favorites)
                    @if ($favorites->kategoria_id == $product->id)
                    <form action="/product/deleteFromFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="fas fa-heart"></i> </button>
                    </form>
                    @break

                    @else
                    <form action="/product/addToFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                    </form>
                    @endif

                    @endforeach

                    @endif

                    @else

                    @if(!session('favorites'))

                    <form action="/product/addToFavorites" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                        <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                    </form>

                    @else

                    @for($i = 0; $i < count(session()->get('favorites')); $i++)
                        @if (session()->get('favorites')[$i] == $product->id)
                        <form action="/product/deleteFromFavorites" method="POST" class="mb-0">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                            <button class="border-0 favorites text-success"> <i class="fas fa-heart"></i> </button>
                        </form>
                        @break

                        @else
                        <form action="/product/addToFavorites" method="POST" class="mb-0">
                            @csrf
                            <input type="text" name="id" value="{{ $product->id }}" class="d-none">
                            <button class="border-0 favorites text-success"> <i class="far fa-heart"></i> </button>
                        </form>
                        @endif
                        @endfor

                        @endif

                        @endif

                </div>
            </a>
            @endforeach


    </div>

    <div class="d-flex justify-content-center mx-auto mt-4 mb-3" id="pagination">
        {{ $products->render() }}
    </div>

    @else

    <div class="element mb-3 p-3 w-100">
        <p class="font-weight-bold mb-0 text-center py-4" style="font-size: 22px"> Aktualnie w tej kategorii
            nie znajduje się żaden produkt. </p>
    </div>

    @endif

</section>

<script>
    let array = '<?php echo json_encode($products); ?>';
    let addArray = [...array];

    function display(){
                let addArray = [...array];

                if(minPrice != 0){
                    addArray = addArray.filter(function( obj ) {
                            return obj.Price >= minPrice;
                    });
                }
    }
</script>


@endsection