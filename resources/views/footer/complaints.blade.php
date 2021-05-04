@extends('layouts.nav')

<style>
    .card h2 button {
        font-size: 20px;
    }

    p {
        font-size: 16px;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold"> REKLAMACJE I ZWROTY </h1>

<section class="container mb-5">
    <div class="accordion" id="accordionExample">

        <div class="card">
            <div class="card-header p-0" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn p-4 btn-block text-left font-weight-bold collapsed" type="button"
                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        Reklamacja
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <p>
                        O więcej informacji prosimy o kontakt mailowy na adres <b>arnetgryfow@poczta.onet.pl</b> lub o
                        skorzystanie z
                        <a href="https://arnet-meble-sklep.pl/kontakt"> formularza kontaktowego </a> na naszej stronie.
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header p-0" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn p-4 btn-block text-left font-weight-bold collapsed" type="button"
                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        Zwrot
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <p>
                        O więcej informacji prosimy o kontakt mailowy na adres <b>arnetgryfow@poczta.onet.pl</b> lub o
                        skorzystanie z
                        <a href="https://arnet-meble-sklep.pl/kontakt"> formularza kontaktowego </a> na naszej stronie.
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header p-0" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn p-4 btn-block text-left font-weight-bold collapsed" type="button"
                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                        aria-controls="collapseThree">
                        Rękojmia
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <p>
                        O więcej informacji prosimy o kontakt mailowy na adres <b>arnetgryfow@poczta.onet.pl</b> lub o
                        skorzystanie z
                        <a href="https://arnet-meble-sklep.pl/kontakt"> formularza kontaktowego </a> na naszej stronie.
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header p-0" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn p-4 btn-block text-left font-weight-bold collapsed" type="button"
                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                        aria-controls="collapseFour">
                        Gwarancja
                    </button>
                </h2>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                    <p>
                        O więcej informacji prosimy o kontakt mailowy na adres <b>arnetgryfow@poczta.onet.pl</b> lub o
                        skorzystanie z
                        <a href="https://arnet-meble-sklep.pl/kontakt"> formularza kontaktowego </a> na naszej stronie.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection