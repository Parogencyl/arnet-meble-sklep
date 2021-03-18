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

    @media screen and (min-width: 576px) {
        form {
            width: 100%;
        }
    }

    @media screen and (min-width: 768px) {
        form {
            width: 75%;
        }
    }

    @media screen and (min-width: 992px) {
        form {
            width: 50%;
        }
    }

    .input-group input {
        font-size: 18px;
    }

    .input-group textarea {
        font-size: 18px;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold"> KONTAKT </h1>

<div class="container">
    <p> Potrzebujesz pomocy wględem zagospodarowania wolnej przestrzeni, bądź trapią cię innego rodzaju pytania? Napisz
        do nas, a my postaram się rozwiać wszelkie wątpliwość bądź dylematy. </p>

    <form method="post" action="{{ url('/kontakt/send') }}" class="mx-auto">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-male"></i></span>
            </div>
            <input type="text" class="form-control p-3" name="name" placeholder="Imię nazwisko" aria-label="Jan Nowak"
                aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
            </div>
            <input type="email" class="form-control p-3" name="email" placeholder="Email" aria-label="osoba@email.pl"
                aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text font-weight-bold">Pytanie</span>
            </div>
            <textarea class="form-control" name="text" aria-label="With textarea"
                placeholder="Treść wiadomości"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-success"> Wyślij </button>
        </div>
    </form>
    @if ($message = Session::get('send'))
    <div class="alert alert-success alert-block mt-3 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block mt-3 text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
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

@endsection