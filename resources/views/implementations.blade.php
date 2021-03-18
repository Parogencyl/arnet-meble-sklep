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

@extends('layouts.nav')

<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<link rel=" stylesheet " href=" https://unpkg.com/flickity-fullscreen@1/fullscreen.css ">
<!-- JavaScript -->
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src=" https://unpkg.com/flickity-fullscreen@1/fullscreen.js "> </script>

@section('content')

<style>
    section img {
        height: 200px;
        box-shadow: 0 0 4px 1px black;
        transition: 0.4s;
        cursor: zoom-in;
    }

    section img:hover {
        box-shadow: 0 0 5px 2px black;
    }
</style>
<section>
    <h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> Realizacje </h1>

    <div class="container">

        <!-- Kuchnia -->

        @if ($imagesKitchen)
        <h2 class="text-center mb-4 font-weight-bold"> Kuchnia </h2>

        <div class="row mb-5" id="kitchen">

            @for ($i = 0; $i < $kitchenSize; $i++) @if ($i <=7) <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                <img data-enlargeable src="{{ asset("graphics/gallery/kitchen/".$imgKitchen[$i]) }}"
                    alt="{{ "kuchnia".$i }}" class="w-100">
        </div>
        @endif

        @if ($i > 7)
        @if ( $i == 8)
        <div class="col-12 row p-0 mx-auto" id="kitchenMore">
            @endif

            <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                <img data-enlargeable src="{{ asset("graphics/gallery/kitchen/".$imgKitchen[$i]) }}"
                    alt="{{ "kuchnia".$i }}" class="w-100">
            </div>

            @if ( $kitchenSize == $i+1)
        </div>
        @endif
        @endif

        @endfor

        @if ($kitchenSize > 8)
        <div class="col-12 row justify-content-center p-0 mx-auto">
            <button type="button" class="btn btn-lg btn-dark text-uppercase" onclick="kitchenMore()"> Więcej
            </button>
        </div>
        @endif
    </div>
    @endif


    <!-- Łazienka -->

    @if ($imagesBathroom)
    <h2 class="text-center mb-4 font-weight-bold"> Łazienka </h2>

    <div class="row mb-5" id="bathroom">
        @for ($i = 0; $i < $bathroomSize; $i++) @if ($i <=7) <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
            <img data-enlargeable src="{{ asset("graphics/gallery/bathroom/".$imgBathroom[$i]) }}"
                alt="{{ "łazienka".$i }}" class="w-100">
    </div>
    @endif

    @if ($i > 7)
    @if ( $i == 8)
    <div class="col-12 row p-0 mx-auto" id="bathroomMore">
        @endif

        <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
            <img data-enlargeable src="{{ asset("graphics/gallery/bathroom/".$imgBathroom[$i]) }}"
                alt="{{ "łazienka".$i }}" class="w-100">
        </div>

        @if ( $bathroomSize == $i+1)
    </div>
    @endif
    @endif

    @endfor

    @if ($bathroomSize > 8)
    <div class="col-12 row justify-content-center p-0 mx-auto">
        <button type="button" class="btn btn-lg btn-dark mx-auto text-uppercase" onclick="bathroomMore()"> Więcej
        </button>
    </div>
    @endif
    </div>
    @endif

    <!-- Inne -->


    @if ($imagesOthers)
    <h2 class="text-center mb-4 font-weight-bold"> Inne </h2>

    <div class="row mb-3" id="others">

        @for ($i = 0; $i < $othersSize; $i++) @if ($i <=7) <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
            <img data-enlargeable src="{{ asset("graphics/gallery/other/".$imgOthers[$i]) }}" alt="{{ "Inne".$i }}"
                class="w-100">
    </div>
    @endif

    @if ($i > 7)
    @if ( $i == 8)
    <div class="col-12 row p-0 mx-auto" id="othersMore">
        @endif

        <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
            <img data-enlargeable src="{{ asset("graphics/gallery/other/".$imgOthers[$i]) }}" alt="{{ "Inne".$i }}"
                class="w-100">
        </div>

        @if ( $othersSize == $i+1)
    </div>
    @endif
    @endif

    @endfor

    @if ($othersSize > 8)
    <div class="col-12 row justify-content-center p-0 mx-auto">
        <button type="button" class="btn btn-lg btn-dark mx-auto text-uppercase" onclick="othersMore()"> Więcej
        </button>
    </div>
    @endif
    </div>
    @endif

    </div>
</section>
<script>
    $('#kitchenMore').hide();
    $('#bathroomMore').hide();
    $('#othersMore').hide();
    var kitchen = bathroom = others = 0;

    function kitchenMore(){
        if(kitchen == 0){
            $('#kitchenMore').show();
            $('#kitchen button').text("Mniej");
            kitchen = 1;
        } else {
            $('#kitchenMore').hide();
            $('#kitchen button').text("Więcej");
            kitchen = 0;
        }
    }

    function bathroomMore(){
        if(bathroom == 0){
            $('#bathroomMore').show();
            $('#bathroom button').text("Mniej");
            bathroom = 1;
        } else {
            $('#bathroomMore').hide();
            $('#bathroom button').text("Więcej");
            bathroom = 0;
        }
    }

    function othersMore(){
        if(others == 0){
            $('#othersMore').show();
            $('#others button').text("Mniej");
            others = 1;
        } else {
            $('#othersMore').hide();
            $('#others button').text("Więcej");
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