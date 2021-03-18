@extends('layouts.nav')

<style>
    p {
        font-size: 17px;
        text-align: justify;
    }

    h2 {
        position: relative;
    }

    h2:after {
        content: " ";
        position: absolute;
        bottom: 0;
        left: 10%;
        width: 80%;
        height: 2px;
        background-color: gray;
        border-radius: 5px;
    }

    .row p {
        margin-bottom: 10px;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold"> O FIRMIE </h1>

<section class="container mb-5">
    <p> Firma Arnet funkcjonuje od 2000 roku. Przedmiotem naszej działalności jest projektowanie, wykonawstwo i montaż
        mebli
        kuchennych i innych. <br><br>


        <strong>
            Idea naszej firmy dotycząca sprzedaży mebli oparta jest na kompleksowym podejściu do klienta, zaproponowanie
            mu
            pełnego rozwiązania problemu urządzenia każdego wnętrza.
        </strong>
        <br><br>

        Firma szczególnie specjalizuje się w wyposażaniu w meble i sprzęt kuchni o nietypowych kształtach, otwartych na
        salon lub jadalnię oraz ekstremalnie małych, gdzie szczególnego znaczenia nabiera wykorzystanie powierzchni.
        <br><br>

        Wysoka jakość materiałów, z którego wykonane są nasze meble sprawia, że będą one cieszyć nie tylko nasze oczy,
        ale i
        oczy naszych dzieci.
        <br><br>

        Oferujemy szeroką gamę wykończeń od klasycznych do najnowocześniejszych. Montujemy sprzęt renomowanych
        producentów
        oraz okucia najlepszych marek.
        <br><br>

        Oferowane przez "ARNET" meble to przyjemne i ładne miejsce nie tylko do pracy ale i do wspólnego spędzania
        czasu w
        gronie rodziny, rozmów, spotkań z przyjaciółmi. Możemy w ich otoczeniu spędzić miłe chwile, oderwać się od
        szarości
        codziennego życia. </p>

    <h2 class="text-center pb-1 my-5"> Lokalizacja firmy </h2>
    <div class="row">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10035.2463496048!2d15.432476897497105!3d51.03810052610562!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x68010cb6389dd322!2sArnet%20-%20Studio%20Mebli!5e0!3m2!1spl!2spl!4v1607017692469!5m2!1spl!2spl"
            class="col-sm-12 col-md-6" height="400px" frameborder="0" style="border:0;" allowfullscreen=""
            aria-hidden="false" tabindex="0"></iframe>
        <div class="col-sm-12 col-md-6 font-weight-bold my-auto pl-sm-4 pl-0">
            <p class="text-sm-left text-center"> <i class="fas fa-building"></i> Arnet - Studio mebli </p>
            <p class="text-sm-left text-center"> <i class="fas fa-map-marker-alt"> </i> Ubocze 291 </p>
            <p class="text-sm-left text-center"> <i class="fas fa-map-marker-alt"> </i> 59-620 Ubocze </p>
            <p class="text-sm-left text-center"> <i class="fas fa-phone-square"> </i> (75) 78-11-343 </p>
            <p class="text-sm-left text-center"> <i class="fas fa-phone-square"> </i> 609 752 994 </p>
        </div>
    </div>
</section>

@endsection