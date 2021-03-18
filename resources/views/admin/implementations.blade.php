<?php

if($imagesKitchen = File::allFiles(public_path('graphics/gallery/kitchen'))){
    for ($i=0; $i < count($imagesKitchen); $i++) { 
        $imgKitchen[$i] =  $imagesKitchen[$i]->getFilename();
    }
    natsort($imgKitchen);
    $imgKitchen = array_reverse($imgKitchen);
    $kitchenSize = count($imgKitchen);
}

if($imagesBathroom = File::allFiles(public_path('graphics/gallery/bathroom'))){
    for ($i=0; $i < count($imagesBathroom); $i++) { 
        $imgBathroom[$i] =  $imagesBathroom[$i]->getFilename();
    }
    natsort($imgBathroom);
    $imgBathroom = array_reverse($imgBathroom);
    $bathroomSize = count($imgBathroom);
}

if($imagesOthers = File::allFiles(public_path('graphics/gallery/other'))){
    for ($i=0; $i < count($imagesOthers); $i++) { 
        $imgOthers[$i] =  $imagesOthers[$i]->getFilename();
    }
    natsort($imgOthers);
    $imgOthers = array_reverse($imgOthers);
    $othersSize = count($imgOthers);
}

?>

@extends('layouts.adminNav')

<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<link rel=" stylesheet " href=" https://unpkg.com/flickity-fullscreen@1/fullscreen.css ">
<!-- JavaScript -->
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src=" https://unpkg.com/flickity-fullscreen@1/fullscreen.js "> </script>

@section('content')

<style>
    img {
        height: 180px;
        cursor: zoom-in;
        box-shadow: 0 0 4px 1px black;
        transition: 0.4s;
    }

    img:hover {
        box-shadow: 0 0 5px 2px black;
    }

    .dustbin {
        position: absolute;
        top: 0px;
        right: 10px;
        width: auto;
        height: auto;
        z-index: 2000;
        font-size: 50px;
        color: red;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 10;
    }

    .dustbin button {
        border: none;
        background-color: rgb(0, 0, 0, 0);
        color: red;
    }
</style>

<h1 class="text-center mb-5 font-weight-bold text-uppercase mt-4"> Realizacje </h1>

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <!-- Kuchnia -->

    <h2 class="text-center mb-1 font-weight-bold"> Kuchnia </h2>

    <form action="{{ url('/admin/realizacje/add') }}" method="POST" class="text-white mb-4"
        enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlFile1" style="font-size: 22px; text-transform: uppercase; color: red">Dodaj
                zdjęcie</label>
            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1"
                style="font-size: 17px; color:black;">
            <input type="text" name="directory" value="kitchen" style="display: none">
        </div>
        <button type="submit" class="btn btn-lg btn-success"> Dodaj </button>
    </form>

    @if ($imagesKitchen)
    <div class="row mb-5" id="kitchen">
        @for ($i = 0; $i < $kitchenSize; $i++) @if ($i <=5) <div class="col-6 col-sm-4 col-xl-2 mb-4">
            <img data-enlargeable src="{{ asset("/graphics/gallery/kitchen/".$imgKitchen[$i]) }}"
                alt="{{ "kuchnia".$i }}" class="w-100">
            <div class="dustbin">
                <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                    @csrf
                    <input type="text" name="file" value="{{ "/graphics/gallery/kitchen/".$imgKitchen[$i] }}"
                        class="d-none">
                    <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                </form>
            </div>
    </div>
    @endif

    @if ($i > 5)
    @if ( $i == 6)
    <div class="col-12 row p-0 mx-auto" id="kitchenMore">
        @endif

        <div class="col-6 col-sm-4 col-xl-2 mb-4">
            <img data-enlargeable src="{{ asset("/graphics/gallery/kitchen/".$imgKitchen[$i]) }}"
                alt="{{ "kuchnia".$i }}" class="w-100">
            <div class="dustbin">
                <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                    @csrf
                    <input type="text" name="file" value="{{ "/graphics/gallery/kitchen/".$imgKitchen[$i] }}"
                        class="d-none">
                    <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                </form>
            </div>
        </div>

        @if ( $kitchenSize == $i+1)
    </div>
    @endif
    @endif

    @endfor

    @if ($kitchenSize > 6)
    <div class="col-12 row justify-content-center">
        <button type="button" class="btn btn-lg btn-dark text-uppercase showButton" onclick="kitchenMore()"> Więcej
        </button>
    </div>
    @endif
</div>
@endif


<!-- Łazienka -->


<h2 class="text-center mb-4 font-weight-bold"> Łazienka </h2>

<form action="{{ url('/admin/realizacje/add') }}" method="POST" class="text-white mb-4" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleFormControlFile1" style="font-size: 22px; text-transform: uppercase; color: red">Dodaj
            zdjęcie</label>
        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1"
            style="font-size: 17px; color:black;">
        <input type="text" name="directory" value="bathroom" style="display: none">
    </div>
    <button type="submit" class="btn btn-lg btn-success"> Dodaj </button>
</form>

@if ($imagesBathroom)
<div class="row mb-5" id="bathroom">
    @for ($i = 0; $i < $bathroomSize; $i++) @if ($i <=5) <div class="col-6 col-sm-4 col-xl-2 mb-4">
        <img data-enlargeable src="{{ asset("/graphics/gallery/bathroom/".$imgBathroom[$i]) }}"
            alt="{{ "łazienka".$i }}" class="w-100">
        <div class="dustbin">
            <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                @csrf
                <input type="text" name="file" value="{{ "/graphics/gallery/bathroom/".$imgBathroom[$i] }}"
                    class="d-none">
                <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
            </form>
        </div>
</div>
@endif

@if ($i > 5)
@if ( $i == 6)
<div class="col-12 row p-0 mx-auto" id="bathroomMore">
    @endif

    <div class="col-6 col-sm-4 col-xl-2 mb-4">
        <img data-enlargeable src="{{ asset("/graphics/gallery/bathroom/".$imgBathroom[$i]) }}"
            alt="{{ "łazienka".$i }}" class="w-100">
        <div class="dustbin">
            <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                @csrf
                <input type="text" name="file" value="{{ "/graphics/gallery/bathroom/".$imgBathroom[$i] }}"
                    class="d-none">
                <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
            </form>
        </div>
    </div>

    @if ( $bathroomSize == $i+1)
</div>
@endif
@endif

@endfor

@if ($bathroomSize > 6)
<div class="col-12 row justify-content-center">
    <button type="button" class="btn btn-lg btn-dark mx-auto text-uppercase showButton" onclick="bathroomMore()"> Więcej
    </button>
</div>
@endif
</div>
@endif

<!-- Inne -->

<h2 class="text-center mb-4 font-weight-bold"> Inne </h2>

<form action="{{ url('/admin/realizacje/add') }}" method="POST" class="text-white mb-4" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleFormControlFile1" style="font-size: 22px; text-transform: uppercase; color: red">Dodaj
            zdjęcie</label>
        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1"
            style="font-size: 17px; color:black;">
        <input type="text" name="directory" value="other" style="display: none">
    </div>
    <button type="submit" class="btn btn-lg btn-success"> Dodaj </button>
</form>

@if ($imagesOthers)
<div class="row mb-3" id="others">

    @for ($i = 0; $i < $othersSize; $i++) @if ($i <=5) <div class="col-6 col-sm-4 col-xl-2 mb-4">
        <img data-enlargeable src="{{ asset("/graphics/gallery/other/".$imgOthers[$i]) }}" alt="{{ "Inne".$i }}"
            class="w-100">
        <div class="dustbin">
            <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                @csrf
                <input type="text" name="file" value="{{ "/graphics/gallery/other/".$imgOthers[$i] }}" class="d-none">
                <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
            </form>
        </div>
</div>
@endif

@if ($i > 5)
@if ( $i == 6)
<div class="col-12 row p-0 mx-auto" id="othersMore">
    @endif

    <div class="col-6 col-sm-4 col-xl-2 mb-4">
        <img data-enlargeable src="{{ asset("/graphics/gallery/other/".$imgOthers[$i]) }}" alt="{{ "Inne".$i }}"
            class="w-100">
        <div class="dustbin">
            <form action="{{ url('/admin/realizacje/delete') }}" method="POST" class="m-2">
                @csrf
                <input type="text" name="file" value="{{ "/graphics/gallery/other/".$imgOthers[$i] }}" class="d-none">
                <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
            </form>
        </div>
    </div>

    @if ( $othersSize == $i+1)
</div>
@endif
@endif

@endfor

@if ($othersSize > 6)
<div class="col-12 row justify-content-center">
    <button type="button" class="btn btn-lg btn-dark mx-auto text-uppercase showButton" onclick="othersMore()"> Więcej
    </button>
</div>
@endif
</div>
@endif
</div>

<script>
    $('#kitchenMore').hide();
    $('#bathroomMore').hide();
    $('#othersMore').hide();
    var kitchen = bathroom = others = 0;

    function kitchenMore(){
        if(kitchen == 0){
            $('#kitchenMore').show();
            $('#kitchen .showButton').text("Mniej");
            kitchen = 1;
        } else {
            $('#kitchenMore').hide();
            $('#kitchen .showButton').text("Więcej");
            kitchen = 0;
        }
    }

    function bathroomMore(){
        if(bathroom == 0){
            $('#bathroomMore').show();
            $('#bathroom .showButton').text("Mniej");
            bathroom = 1;
        } else {
            $('#bathroomMore').hide();
            $('#bathroom .showButton').text("Więcej");
            bathroom = 0;
        }
    }

    function othersMore(){
        if(others == 0){
            $('#othersMore').show();
            $('#others .showButton').text("Mniej");
            others = 1;
        } else {
            $('#othersMore').hide();
            $('#others .showButton').text("Więcej");
            others = 0;
        }
    }

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