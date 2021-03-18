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

    #addressTitle a {
        color: #212529;
        text-decoration: none;
    }

    #addressTitle a i {
        transition: 1s;
    }
</style>

@section('content')

<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-3 font-weight-bold text-uppercase"> Dane konta </h1>

<div class="container">
    <div class="row justify-content-center">
        @include('layouts.clientNav')

        <div class="col-sm col-11 ml-sm-5 border p-3" id="rightSide">
            <div>
                <p class="font-weight-bold title text-uppercase mb-2"> Imię </p>
                <div class="">
                    @if (Auth::user()->name)
                    <span class="my-auto"> {{ Auth::user()->name }} </span>
                    <form action="{{ route('client/deleteName') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addName') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="name"
                            placeholder="Imię" autocomplete="name" value="{{ old('name') }}" required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorName'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <div>
                <p class="font-weight-bold title text-uppercase mb-2"> Nazwisko </p>
                <div class="">
                    @if (Auth::user()->surname)
                    <span class="my-auto"> {{ Auth::user()->surname }} </span>
                    <form action="{{ route('client/deleteSurname') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addSurname') }}" method="POST">
                        @csrf
                        <input type="text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="surname"
                            placeholder="Nazwisko" autocomplete="surname" value="{{ old('surname') }}" required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorSurname'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <div>
                <p class="font-weight-bold title text-uppercase mb-2"> Telefon </p>
                @if (Auth::user()->phone)
                <span class=" my-auto"> {{ Auth::user()->phone }} </span>
                <form action="{{ route('client/deletePhone') }}" method="POST" class="d-inline-block ml-3">
                    @csrf
                    <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                </form>
                @else
                <form action="{{ route('client/addPhone') }}" method="POST">
                    @csrf
                    <input type="text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="phone" maxlength="16"
                        minlength="7" placeholder="Numer telefonu" autocomplete="phone" value="{{ old('phone') }}"
                        required>
                    <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                    </button>
                </form>
                @if ($message = Session::get('errorPhone'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                @endif
            </div>

            <div>
                <p class="font-weight-bold title text-uppercase pb-2" id="addressTitle"> <a href="#"> Adres zamieszkania
                        <i class="fas fa-sort-up text-danger"></i></a>
                </p>
                <div id="address" class="pt-2">
                    <span class="font-weight-bold mr-2 my-auto"> Ulica: </span>
                    @if (Auth::user()->street)
                    <span class="my-auto" id="street"> {{ Auth::user()->street }} </span>
                    <form action="{{ route('client/deleteStreet') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addStreet') }}" method="POST" class="d-inline-block">
                        @csrf
                        <input type="text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="street"
                            placeholder="Nazwa ulicy/miejscowości" autocomplete="street" value="{{ old('street') }}"
                            required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorStreet'))
                    <div class="alert alert-danger alert-block mb-0">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif

                    <br>

                    <span class="font-weight-bold mr-1"> Numer domu/mieszkania: </span>
                    @if (Auth::user()->local_number)
                    <span class="my-auto" id="localNumber"> {{ Auth::user()->local_number }} </span>
                    <form action="{{ route('client/deleteLocalNumber') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addLocalNumber') }}" method="POST" class="d-inline-block">
                        @csrf
                        <input type=" text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="localNumber"
                            placeholder="12" autocomplete="localNumber" value="{{ old('localNumber') }}" required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorLocalNumber'))
                    <div class="alert alert-danger alert-block mb-0">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif

                    <br>

                    <span class="font-weight-bold mr-1"> Kod pocztowy: </span>
                    @if (Auth::user()->zip)
                    <span class="my-auto" id="zip"> {{ Auth::user()->zip }} </span>
                    <form action="{{ route('client/deleteZip') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addZip') }}" method="POST" class="d-inline-block">
                        @csrf
                        <input type=" text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="zip"
                            placeholder="40-200" autocomplete="zip" value="{{ old('zip') }}" required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorZip'))
                    <div class="alert alert-danger alert-block mb-0">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif


                    <br>

                    <span class="font-weight-bold mr-1"> Miejscowość: </span>
                    @if (Auth::user()->city)
                    <span class="my-auto" id="city"> {{ Auth::user()->city }} </span>
                    <form action="{{ route('client/deleteCity') }}" method="POST" class="d-inline-block ml-3">
                        @csrf
                        <button class="btn btn-danger" type="submit"> <i class="fas fa-trash-alt"> </i> </button>
                    </form>
                    @else
                    <form action="{{ route('client/addCity') }}" method="POST" class="d-inline-block">
                        @csrf
                        <input type=" text" class="form-control mb-0 mb-2 w-auto d-inline-block" name="city"
                            placeholder="Nazwa ulicy/miejscowości" autocomplete="city" value="{{ old('city') }}"
                            required>
                        <button class="btn btn-success ml-sm-4 ml-1"> <i class="fas fa-plus-square"></i>
                        </button>
                    </form>
                    @if ($message = Session::get('errorCity'))
                    <div class="alert alert-danger alert-block mb-0">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @endif


                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var open = 0;
    $("#address").hide();
    $("#addressTitle").on("click", function() {
        if(open == 0){
            $("#address").show(1000);
            $("#addressTitle a i").css({'transform' : 'rotate(180deg)'});
            open = 1;
        }else {
            $("#address").hide(1000);
            $("#addressTitle a i").css({'transform' : 'rotate(0deg)'});
            open = 0;
        }
    });
</script>

@endsection