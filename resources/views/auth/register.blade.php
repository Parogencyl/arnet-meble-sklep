@extends('layouts.nav')

@section('content')

<style>
    form p {
        margin-bottom: 0;
    }
</style>

<section class="container my-5">

    <div class="row justify-content-center align-items-center" id="main">
        <div class="col-12 col-sm-10 col-md-8 col-xl-6">
            <div class="card bg-light">
                <div class="card-header bg-dark text-white text-center text-uppercase" style="font-size: 18px;">
                    Rejestracja </div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-xl-9">
                            <p class="mb-0 font-weight-bold"> Rejestracja umożliwia: </p>
                            <p class="mb-0"> - Dostęp do historii zakupów </p>
                            <p class="mb-0"> - Wystawianie opinii po zakupie </p>
                            <p class="mb-3"> - Zapamiętanie zawartości koszyka </p>
                        </div>
                    </div>

                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('client/register/submit') }}">
                        @csrf

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-12 col-md-10 col-xl-9">
                                <input id="email" type="email" class="form-control" name="email" required
                                    autocomplete="email" value="{{ old('email') }}" placeholder="Adres email">
                                <p id="emailError" class="text-danger"> </p>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-12 col-md-10 col-xl-9">
                                <input id="password" type="password" class="form-control" name="password" required
                                    placeholder="Hasło">
                                <p id="passwordError" class="text-danger"> </p>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-12 col-md-10 col-xl-9">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="Powtórz hasło"
                                    autocomplete="new-password">
                                <p id="passwordConfirmError" class="text-danger"> </p>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-12 col-md-10 col-xl-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" required>
                                    <label class="form-check-label ml-3" for="gridCheck1">
                                        Akceptuję <a href="{{ url('regulamin') }}" class="text-dark font-weight-bold"
                                            target="_blank">
                                            regulamin </a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-12 row justify-content-center">
                                <button type="submit" class="btn btn-success btn-lg text-uppercase">
                                    Zarejestruj
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.getElementById('email').addEventListener('focusout', () => {
        var email = document.getElementById('email').value;
        var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        document.getElementById('emailError').innerHTML = "";
        if(email == ""){
            document.getElementById('emailError').innerHTML = "Należy podać adres email.";
        }else if(email.length < 6){
            document.getElementById('emailError').innerHTML = "Niepoprawna forma adresu email.";
        } else if(!document.getElementById('email').value.match(mailformat)){
            document.getElementById('emailError').innerHTML = "Niepoprawna forma adresu email.";
        }
    });

    document.getElementById('password').addEventListener('focusout', () => {
        var password = document.getElementById('password').value;
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,25}$/;
        document.getElementById('passwordError').innerHTML = "";
        if(password == ""){
            document.getElementById('passwordError').innerHTML = "Należy podać hasło.";
        }else if(!password.match(passw)){
            if(password.length < 8){
            document.getElementById('passwordError').innerHTML += "Hasło powinno składać się z co najmniej 8 znaków. <br>";
            } 
            if(password.length > 25){
            document.getElementById('passwordError').innerHTML += "Hasło nie może zawierać więcej niż 25 znaków. <br>";
            } 
            document.getElementById('passwordError').innerHTML += "Hasło powinno składać się z: małej litery, dużej litery oraz liczby. <br>";
        } 
        if(document.getElementById('password-confirm').value != ""){
            passwordConfirm();
        }
    });

    function passwordConfirm(){
        var password = document.getElementById('password').value;
        var passwordConfirm = document.getElementById('password-confirm').value;
        document.getElementById('passwordConfirmError').innerHTML = "";
        if(password != passwordConfirm){
            document.getElementById('passwordConfirmError').innerHTML = "Błędne hasło.";
        }
    }

    document.getElementById('password-confirm').addEventListener('focusout', () => {
        passwordConfirm();
    });

</script>

@endsection