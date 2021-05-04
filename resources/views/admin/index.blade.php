<?php
    $baners = array();
    if($banersFiles = File::allFiles(public_path('graphics/baners'))){
        for ($i=0; $i < count($banersFiles); $i++) { 
            $baners[$i] =  $banersFiles[$i]->getFilename();
        }
        natsort($baners);
    }

?>

@extends('layouts.adminNav')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('content')

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

<div class="bilbord py-4 container py-0 mb-5 mt-3">

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="12000">
        <div class="carousel-inner">
            @if($baners != '[]')

            @if (isset($baners[0]))
            <div class="carousel-item active">
                <img src="{{ asset('/graphics/baners/'.$baners[0]) }}" class="d-block w-100" style="height: 100%"
                    alt="Baner 1">
                @if (!isset($baners[1]))
                <div class="dustbin">
                    <form action="{{ url('/admin/deleteBaner') }}" method="POST" class="m-2">
                        @csrf
                        <input type="text" name="file" value="1" class="d-none">
                        <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                </div>
                @endif
            </div>

            @if (isset($baners[1]))
            <div class="carousel-item">
                <img src="{{ asset('/graphics/baners/'.$baners[1]) }}" class="d-block w-100" style="height: 100%"
                    alt="Baner 2">
                @if (!isset($baners[2]))
                <div class="dustbin">
                    <form action="{{ url('/admin/deleteBaner') }}" method="POST" class="m-2">
                        @csrf
                        <input type="text" name="file" value="2" class="d-none">
                        <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                </div>
                @endif
            </div>

            @if (isset($baners[2]))
            <div class="carousel-item">
                <img src="{{ asset('/graphics/baners/'.$baners[2]) }}" class="d-block w-100" style="height: 100%"
                    alt="Baner 3">
                <div class="dustbin">
                    <form action="{{ url('/admin/deleteBaner') }}" method="POST" class="m-2">
                        @csrf
                        <input type="text" name="file" value="3" class="d-none">
                        <button type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                </div>
            </div>

            @else

            <div class="carousel-item">
                <form action="{{ url('/admin/addBaner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center border border-success py-5 image-upload bg-success">
                        <label for="file-input3">
                            <i class="fas fa-plus text-white py-5" style="font-size: 80px;"></i>
                        </label>

                        <input type="text" name="el" value="3" class="d-none">

                        <input id="file-input3" type="file" name="baner" onchange="form.submit()">
                    </div>
                </form>
            </div>

            @endif

            @else

            <div class="carousel-item">
                <form action="{{ url('/admin/addBaner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center border border-success py-5 image-upload bg-success">
                        <label for="file-input2">
                            <i class="fas fa-plus text-white py-5" style="font-size: 80px;"></i>
                        </label>

                        <input type="text" name="el" value="2" class="d-none">

                        <input id="file-input2" type="file" name="baner" onchange="form.submit()">
                    </div>
                </form>
            </div>

            @endif

            @else

            <div class="carousel-item active">
                <form action="{{ url('/admin/addBaner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center border border-success py-5 image-upload bg-success">
                        <label for="file-input1">
                            <i class="fas fa-plus text-white py-5" style="font-size: 80px;"></i>
                        </label>

                        <input type="text" name="el" value="1" class="d-none">

                        <input id="file-input1" type="file" name="baner" onchange="form.submit()">
                    </div>
                </form>
            </div>

            @endif

            @else

            <div class="carousel-item active">
                <form action="{{ url('/admin/addBaner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center border border-success py-5 image-upload bg-success">
                        <label for="file-input1">
                            <i class="fas fa-plus text-white py-5" style="font-size: 80px;"></i>
                        </label>

                        <input type="text" name="el" value="1" class="d-none">

                        <input id="file-input1" type="file" name="baner" onchange="form.submit()">
                    </div>
                </form>
            </div>

            @endif

        </div>

        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>


<div class="implementation py-4">

    <h2 class="text-center mb-4 font-weight-bold"> NASZE REALIZACJE </h2>

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
        <button class="btn btn-dark btn-lg"> <a href="{{ url('admin/realizacje') }}"
                class="text-decoration-none text-white">
                Więcej </a>
        </button>
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