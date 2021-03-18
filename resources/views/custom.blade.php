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

@section('style')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
@yield('style')
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


<section class="position-relative p-3 pt-5 pb-5">
    <div class="bgImage" style="background-image: url({{ asset('/graphics/kuchnia_custom.jpg')}} )"> </div>
    <div class="darkening"> </div>
    <div class="text text-center row justify-content-center">
        <p class="col-xl-6 col-md-8 col-sm-10 col-12 mb-3"> Mieszkania jak i ich lokatorzy zawsze się różnią
        </p>
        <div class="dash"> </div>
        <p class="col-11 col-md-8 mt-3 imgBody"> Dlatego dla naszych klientów oferujemy także
            stworzenie
            mebli
            specjalnie dla ich mieszkań. Nie zawsze możliwe jest dostosowanie wnętrzna według własnych oczekiwań. Gdy
            zachodzi potrzeba umeblowania wnętrza często dobry rozwiązaniem są meble na wymiar. Sprawdzają się one we
            wszystkich wnętrzach i pozwalają najopymalniej wykorzystać dostępną przestrzeń zarówno w małych jak i dużych
            pomieszczeniach. </p>
    </div>
</section>

<section class="implementation py-4">

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
        <button class="btn btn-dark btn-lg"> <a href="{{ url('realizacje') }}" class="text-decoration-none text-white">
                Więcej </a>
        </button>
    </div>

</section>

<section class="row justify-content-center pt-5 pb-3 px-3 mx-0">
    <div class="col-md-4 col-12">
        <h2 class="text-center font-weight-bold"> Cennik mebli na wymiar </h2>
        <div class="d-flex justify-content-start">
            <div class="dashMeble"> </div>
        </div>
        <p class="text-justify mebleText"> Dla wielu osób wydaje się, że meble na wymiar są znacznie droższe od gotowych
            mebli. Co
            raz częściej jednak
            okazuje się, że ceny takich produktów są jednakowe, bądź nieznacznie się różnią. </p>
        <p class="text-justify mebleText"> Nie ma powodów do obaw. Po przedstawieniu wizji naszym pracownikom jak ma
            wyglądać
            mebel zostanie on
            wyceniony tak, aby Klient był jak najbardziej usastysfakcjonowany. </p>
    </div>
    <div class="col-md-4 col-12">
        <h2 class="text-center font-weight-bold"> Meble kuchenne na wymiar </h2>
        <div class="d-flex justify-content-center">
            <div class="dashMeble"> </div>
        </div>
        <p class="text-justify mebleText"> Meble kuchenne jest to część mebli na wymiar, w których nasza firma
            specjalizuje się od
            lat. Doskonale
            wiemy, że kuchania jest sercem każdego domu,
            dlatego w realizację takich projektów wkładamy dużo pracy, ale zabudowy kuchenne naszych klientów były nie
            tylko estetyczne, ale praktyczne i odporne zmienne warunki panujące w kuchniach. </p>
        <p class="text-justify mebleText"> To właśnie meble kuchenne na wymiar cieszą się nawiększym zainteresowaniem
            wsród
            klientów. Nasi pracownicy
            pomogą Wam stworzyćidealny projekt do waszego wnętrza, dzięki któremu najoptymalniej zostanie wykorzystana
            dostępna przestrzeń. Oferujemy Wam także podzespoły najlepszych firm, tak oby kuchnie były nowoczne oraz
            trwałe, by każdy Klient mógł cieszyć się swoją kuchnią przez lata.
        </p>
    </div>
    <div class="col-md-4 col-12">
        <h2 class="text-center font-weight-bold"> Meble na wymiar </h2>
        <div class="d-flex justify-content-end">
            <div class="dashMeble"> </div>
        </div>
        <p class="text-justify mebleText"> W naszej ofercie mebli na wymiar znajdują się nie tylko meble kuchnne, ale
            także szafy,
            półki, a także meble
            łazienkowe, czy komody. </p>
        <p class="text-justify mebleText"> Różne fronty, korpusy oraz wykończenia pozwalają Klientom na zamówienie mebli
            dopasowanych do własnych
            potrzeb oraz wyglądu wnętrza.
        </p>
    </div>
</section>

<section class="pb-5 implementation pt-1">
    <div class="container">
        <h2 class="text-center pb-1 mt-5 mb-3 font-weight-bold"> Lokalizacja firmy </h2>
        <p class="font-weight-bold mb-3" style="font-size: 16px;"> W celu stworzenia projektu mebli na wymiar zapraszamy
            do
            naszego biura. Możliwe
            jest także przedstawienie
            swojej koncepcji projektu przez telefon bądź za pośrednictwem poczty <a href='{{ url('kontakt') }}'>
                email</a>.</p>
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
                <p class="text-sm-left text-center"> <i class="fas fa-envelope mr-1"></i> arnetgryfow@poczta.onet.pl
                </p>
            </div>
        </div>
    </div>
</section>


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