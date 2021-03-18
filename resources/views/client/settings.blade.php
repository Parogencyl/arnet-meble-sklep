@extends('layouts.nav')

<style>
    #rightSide {
        background-color: rgb(230, 230, 230);
        border-radius: 5px;
    }

    p {
        font-size: 16px;
    }

    span {
        font-size: 16px;
    }

    form .btn-danger {
        opacity: 0.8;
        transition: 0.5s;
    }

    form .btn-danger:hover {
        opacity: 1;
    }

    input {
        padding: 3px;
    }

    input:focus {
        border: 1px solid red;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> Ustawienia konta </h1>

<div class="container">
    <div class="row justify-content-center">
        @include('layouts.clientNav')

        <div class="col-sm col-11 ml-sm-5 border p-3" id="rightSide">
            <p class="font-weight-bold title text-uppercase mb-2"> Zmiana hasła </p>
            <div>
                <form action="{{ route('client/changePassword') }}" method="POST">
                    @csrf
                    <input type="password" id="oldPassword" class="form-control w-auto d-inline-block mb-1"
                        name="oldPassword" placeholder="Aktualne hasło" required>
                    <p id="oldPasswordError" class="text-danger mb-1"> </p>
                    @if ($message = Session::get('errorOldPassword'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <input type="password" id="password" class="form-control w-auto d-inline-block mb-1" name="password"
                        placeholder="Nowe hasło" required>
                    <p id="passwordError" class="text-danger mb-1"> </p>

                    <input type="password" id="password-confirm" class="form-control w-auto d-inline-block mb-1"
                        name="password_confirmation" placeholder="Powtórz hasło" required>
                    <p id="passwordConfirmError" class="text-danger mb-1"> </p>

                    <button class="btn btn-success" type="submit"> ZMIEŃ </button>
                </form>
                @if ($message = Session::get('errorPassword'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <p class="font-weight-bold title text-uppercase mb-2 mt-5"> Usunięcie konta </p>
                <form action="{{ route('client/deleteAccount') }}" method="POST">
                    @csrf
                    <p class="m-0 font-weight-bold mb-2" style="font-size: 15px"> wpisz <span class="text-danger"> TAK,
                        </span> aby usunąć konto </p>
                    <input type="text" id="delete" class="form-control w-auto d-inline-block mb-1" maxlength="3"
                        minlength="3" name="delete" required>
                    <p id="deleteError" class="text-danger mb-1"> </p>

                    <button class="btn btn-danger" type="submit"> Usuń </button>
                </form>
                @if ($message = Session::get('errorDelete'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('oldPassword').addEventListener('focusout', () => {
        var oldPassword = document.getElementById('oldPassword').value;
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,25}$/;
        document.getElementById('oldPasswordError').innerHTML = "";
        if(oldPassword == ""){
            document.getElementById('oldPasswordError').innerHTML = "Należy podać hasło.";
        }else if(!oldPassword.match(passw)){
            if(oldPassword.length < 8){
            document.getElementById('oldPasswordError').innerHTML += "Hasło powinno składać się z co najmniej 8 znaków. <br>";
            } 
            if(oldPassword.length > 25){
            document.getElementById('oldPasswordError').innerHTML += "Hasło nie może zawierać więcej niż 25 znaków. <br>";
            } 
            document.getElementById('oldPasswordError').innerHTML += "Hasło powinno składać się z: małej litery, dużej litery oraz liczby. <br>";
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

    document.getElementById('delete').addEventListener('focusout', () => {
        var deleteInput = document.getElementById('delete').value;
        document.getElementById('deleteError').innerHTML = "";
        if(deleteInput == ""){
            document.getElementById('deleteError').innerHTML = "Należy wpisać TAK, aby usunąć konto.";
        }else if(deleteInput.uppercase() != 'TAK'){
            document.getElementById('deleteError').innerHTML = "Należy wpisać TAK, aby usunąć konto.";
        } 
    });
</script>

@endsection