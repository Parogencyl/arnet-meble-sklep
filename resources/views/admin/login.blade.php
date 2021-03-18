@extends('layouts.adminNav')

<style>
    @media screen and (min-height: 700px) {

        #main {
            height: calc(100vh - 110px - 60px - 130px)
        }
    }

    @media screen and (max-width: 768px and min-height: 700px) {
        #main {
            height: calc(100vh - 110px - 69px - 174px)
        }
    }

    #register a {
        font-size: 18px;
        text-decoration: underline;
    }
</style>

@section('content')

<section class="container">

    <div class="row justify-content-center align-items-center" id="main">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card bg-light">
                <div class="card-header bg-dark text-white text-center text-uppercase" style="font-size: 18px;"> Panel
                    administracyjny </div>

                <div class="card-body py-0">

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin/login/submit') }}">
                            @csrf

                            <div class="form-group row justify-content-center mt-4">
                                <div class="col-12 col-md-10 col-xl-9">
                                    <input id="email" type="email" value="{{ old('email') }}" class="form-control"
                                        name="email" required autocomplete="email" autofocus placeholder="Adres email">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center mb-3">
                                <div class="col-12 col-md-10 col-xl-9">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        placeholder="Hasło">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center mb-3">
                                <div class="col-12 col-md-10 col-xl-9">
                                    @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center mb-3">
                                <div class="col-12 row justify-content-center">
                                    <button type="submit" class="btn mb-3 btn-success btn-lg text-uppercase">
                                        zaloguj
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