<?php
    $products = DB::table('products')->orderby('id', 'desc')->take(6)->get();

    $baners = array();
    if($banersFiles = File::allFiles(public_path('graphics/baners'))){
        for ($i=0; $i < count($banersFiles); $i++) { 
            $baners[$i] =  $banersFiles[$i]->getFilename();
        }
        natsort($baners);
    }
?>

@extends('layouts.nav')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('content')

<div class="container">
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

@if($baners)

<div class="dark">
    <div class="bilbord py-5 container">

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="8000">
            <div class="carousel-inner">

                @if (isset($baners[0]))
                <div class="carousel-item active">
                    <img src="{{ asset('/graphics/baners/'.$baners[0]) }}" class="d-block w-100" style="height: 100%"
                        alt="Baner 1">
                </div>

                @if (isset($baners[1]))
                <div class="carousel-item">
                    <img src="{{ asset('/graphics/baners/'.$baners[1]) }}" class="d-block w-100" style="height: 100%"
                        alt="Baner 2">
                </div>

                @if (isset($baners[2]))
                <div class="carousel-item">
                    <img src="{{ asset('/graphics/baners/'.$baners[2]) }}" class="d-block w-100" style="height: 100%"
                        alt="Baner 3">
                </div>
                @endif
                @endif
                @endif

            </div>
            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-next-icon " aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>
</div>
@endif




@if (!$products->isEmpty())
<div class="container mb-5 mt-4">
    <h2 class="text-center mb-sm-4 mb-3 mt-sm-4 mt-0 font-weight-bold"> NOWOŚCI </h2>

    @if (count($products) <= 3) <div class="row justify-content-center">
        @foreach ($products as $product)
        @if (count($products) == 1)
        <div class="col-10 col-sm-6 col-md-5 d-flex align-items-stretch">
            @elseif(count($products) == 2)
            <div class="col-10 col-sm-6 col-md-4 d-flex align-items-stretch">
                @else
                <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                    @endif
                    <div class="card mb-0">
                        <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                            alt="{{$product->nazwa}} - zdjęcie">
                        <div class="card-body pb-1">
                            <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                        </div>
                        <div class="bg-light px-3 pb-2 pt-0">
                            <div class="row justify-content-center mb-0 py-3">
                                <a class="btn btn-success mx-auto"
                                    href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                            </div>
                            @if ($product->szerokosc)
                            <hr class="mb-2 mt-1">
                            <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                {{ $product->glebokosc }}
                                x
                                {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @else

            <!--Carousel Wrapper-->
            <div id="multi-item-example" class="carousel slide carousel-multi-item mb-5" data-ride="carousel"
                data-interval="10000">

                <!--Controls
    <div class="controls-top row justify-content-center m-0">
        <a class=" btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
        <a class="btn-floating ml-auto" href="#multi-item-example" data-slide="next"><i
                class="fa fa-chevron-right"></i></a>
    </div>
    /.Controls-->

                <!--Indicators-->
                <ol class="carousel-indicators" style="bottom: -30px;">
                    <li data-target="#multi-item-example" data-slide-to="0" class="active"
                        style="background-color: black;">
                    </li>
                    <li data-target="#multi-item-example" data-slide-to="1" style="background-color: black;"></li>
                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner pb-4" role="listbox">

                    @if (count($products) == 4)
                    <div class="carousel-item active">
                        <div class="row justify-content-center">

                            @foreach ($products as $product)
                            @if ($loop->iteration < 3) <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                                <div class="card mb-0">
                                    <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                                        alt="{{$product->nazwa}} - zdjęcie">
                                    <div class="card-body pb-1">
                                        <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                                    </div>
                                    <div class="bg-light px-3 pb-2 pt-0">
                                        <div class="row justify-content-center mb-0 py-3">
                                            <a class="btn btn-success mx-auto"
                                                href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                                        </div>
                                        @if ($product->szerokosc)
                                        <hr class="mb-2 mt-1">
                                        <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                            {{ $product->glebokosc }}
                                            x
                                            {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                                        @endif
                                    </div>
                                </div>
                        </div>

                        @elseif ($loop->iteration == 3)
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        @endif
                        @if ($loop->iteration >= 3)
                        <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                            <div class="card mb-0">
                                <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                                    alt="{{$product->nazwa}} - zdjęcie">
                                <div class="card-body pb-1">
                                    <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                                </div>
                                <div class="bg-light px-3 pb-2 pt-0">
                                    <div class="row justify-content-center mb-0 py-3">
                                        <a class="btn btn-success mx-auto"
                                            href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                                    </div>
                                    @if ($product->szerokosc)
                                    <hr class="mb-2 mt-1">
                                    <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                        {{ $product->glebokosc }}
                                        x
                                        {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif


                @if (count($products) == 5)
                <div class="carousel-item active">
                    <div class="row justify-content-center">

                        @foreach ($products as $product)
                        @if ($loop->iteration < 4) <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                            <div class="card mb-0">
                                <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                                    alt="{{$product->nazwa}} - zdjęcie">
                                <div class="card-body pb-1">
                                    <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                                </div>
                                <div class="bg-light px-3 pb-2 pt-0">
                                    <div class="row justify-content-center mb-0 py-3">
                                        <a class="btn btn-success mx-auto"
                                            href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                                    </div>
                                    @if ($product->szerokosc)
                                    <hr class="mb-2 mt-1">
                                    <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                        {{ $product->glebokosc }}
                                        x
                                        {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                                    @endif
                                </div>
                            </div>
                    </div>

                    @elseif ($loop->iteration == 4)
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-center">
                    @endif
                    @if ($loop->iteration >=4)
                    <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                        <div class="card mb-0">
                            <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                                alt="{{$product->nazwa}} - zdjęcie">
                            <div class="card-body pb-1">
                                <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                            </div>
                            <div class="bg-light px-3 pb-2 pt-0">
                                <div class="row justify-content-center mb-0 py-3">
                                    <a class="btn btn-success mx-auto"
                                        href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                                </div>
                                @if ($product->szerokosc)
                                <hr class="mb-2 mt-1">
                                <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                    {{ $product->glebokosc }}
                                    x
                                    {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif


            @if (count($products) >= 6)
            <div class="carousel-item active">
                <div class="row justify-content-center">

                    @foreach ($products as $product)
                    @if ($loop->iteration < 4) <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                        <div class="card mb-0">
                            <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                                alt="{{$product->nazwa}} - zdjęcie">
                            <div class="card-body pb-1">
                                <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                            </div>
                            <div class="bg-light px-3 pb-2 pt-0">
                                <div class="row justify-content-center mb-0 py-3">
                                    <a class="btn btn-success mx-auto"
                                        href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                                </div>
                                @if ($product->szerokosc)
                                <hr class="mb-2 mt-1">
                                <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                    {{ $product->glebokosc }}
                                    x
                                    {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                                @endif
                            </div>
                        </div>
                </div>

                @elseif ($loop->iteration == 4)
            </div>
        </div>
        <div class="carousel-item">
            <div class="row justify-content-center">
                @endif
                @if ($loop->iteration >= 4)
                <div class="col-10 col-sm-4 col-md-3 d-flex align-items-stretch">
                    <div class="card mb-0">
                        <img class="card-img-top" src="{{ asset($product->zdjecie1) }}"
                            alt="{{$product->nazwa}} - zdjęcie">
                        <div class="card-body pb-1">
                            <h4 class="card-title"> {{ ucfirst($product->nazwa) }} </h4>
                        </div>
                        <div class="bg-light px-3 pb-2 pt-0">
                            <div class="row justify-content-center mb-0 py-3">
                                <a class="btn btn-success mx-auto"
                                    href="{{ '/produkty'.'/'.$product->rodzaj.'/'.$product->kategoria.'/'.$product->nazwa }}">WIĘCEJ</a>
                            </div>
                            @if ($product->szerokosc)
                            <hr class="mb-2 mt-1">
                            <p class="mb-0 text-dark text-center" style="font-size: 0.7rem;">
                                {{ $product->glebokosc }}
                                x
                                {{ $product->szerokosc }} x {{ $product->wysokosc }} cm </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif


</div>
</div>
</div>


</div>
@endif

</div>
@endif


<div class="implementation py-4">

    <h2 class="text-center mb-5 mt-3 font-weight-bold"> NASZE REALIZACJE </h2>

    <div id="grid">
        <div id="left">
            <img data-enlargeable src="{{ asset('/graphics/gallery/left.jpg') }}" class="w-100">
        </div>
        <div id="top">
            <img data-enlargeable src="{{ asset('/graphics/gallery/top.jpg') }}" class="w-100">
        </div>
        <div id="bot">
            <img data-enlargeable src="{{ asset('/graphics/gallery/bot.jpg') }}" class="w-100">
        </div>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-dark btn-lg"> <a href="{{ url('realizacje') }}" class="text-decoration-none text-white">
                Więcej </a>
        </button>
    </div>

</div>

<div class="container mb-5">
    <h2 class="text-center pb-1 my-5"> Lokalizacja firmy </h2>
    <div class="row">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10035.2463496048!2d15.432476897497105!3d51.03810052610562!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x68010cb6389dd322!2sArnet%20-%20Studio%20Mebli!5e0!3m2!1spl!2spl!4v1607017692469!5m2!1spl!2spl"
            class="col-sm-12 col-md-6" height="400px" frameborder="0" style="border:0;" allowfullscreen=""
            aria-hidden="false" tabindex="0"></iframe>
        <div class="col-sm-12 col-md-6 font-weight-bold my-auto pl-sm-4 pl-0 pt-4 pt-sm-0">
            <p class="text-sm-left text-center"> <i class="fas fa-building"></i> Arnet - Studio mebli </p>
            <p class="text-sm-left text-center"> <i class="fas fa-map-marker-alt"> </i> Ubocze 291 </p>
            <p class="text-sm-left text-center"> <i class="fas fa-map-marker-alt"> </i> 59-620 Ubocze </p>
            <p class="text-sm-left text-center"> <i class="fas fa-phone-square"> </i> (75) 78-11-343 </p>
            <p class="text-sm-left text-center"> <i class="fas fa-phone-square"> </i> 609 752 994 </p>
        </div>
    </div>
</div>


<script>
    $(" img[data-enlargeable]").after(); $("img[data-enlargeable]") .addClass("img-enlargeable") .click(function() {
                var src=$(this).attr("src"); var modal; function removeModal() { modal.remove();
                $("body").off("keyup.modal-close"); } modal=$("<div>")
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