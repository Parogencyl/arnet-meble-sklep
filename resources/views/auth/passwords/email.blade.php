@extends('layouts.nav')

<style>
    #main {
        height: calc(100vh - 110px - 60px - 130px)
    }

    @media screen and (max-width: 768px) {
        #main {
            height: calc(100vh - 110px - 69px - 174px)
        }
    }
</style>

@section('content')

<section class="container">

    <div class="row justify-content-center align-items-center" id="main">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card bg-light">
                <div class="card-header bg-dark text-white text-center text-uppercase" style="font-size: 18px;">
                    Odzyskanie hasła </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ url('odzyskanie_hasła') }}">
                        @csrf

                        <div class="form-group row justify-content-center mt-4">
                            <div class="col-12 col-md-10 col-xl-9 ">
                                <input id="email" type="email" class="form-control" name="email"
                                    placeholder="Adres email" value="{{ old('email') }}" required autocomplete="email"
                                    autofocus>
                            </div>
                        </div>

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-12 row justify-content-center">
                                <button type="submit" class="btn mb-1 btn-success btn-lg text-uppercase">
                                    Odzyskaj hasło
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</section>
@endsection