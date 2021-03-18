<style>
    #navLeft {
        background-color: rgb(230, 230, 230);
        border-radius: 5px;
        display: inline-block;
        min-width: 200px;
        height: 243px;
    }

    #navLeft a {
        color: black;
        text-decoration: none;
        padding: 5px 15px;
        display: block;
        font-weight: bold;
        transition: 0.5s;
    }

    #navLeft a:hover {
        background-color: white;
    }

    #navTitle {
        color: white;
        background-color: rgb(110, 110, 110);
        font-size: 17px;
        font-weight: bold;
        border-radius: 5px 5px 0 0;
    }

    .title {
        font-size: 18px;
        margin-bottom: 0;
    }
</style>

<div id="navLeft" class="mb-sm-0 mb-3">
    <div class="text-center py-3 px-4" id="navTitle"> {{ Auth::user()->email }} </div>
    <div class="py-3">
        <a href="{{ url('/moje_konto/zarzadzanie') }}" id="navItem1" class="my-1 col-12"> Moje dane </a>
        <a href="{{ url('/moje_konto/historia_zakupow') }}" id="navItem2" class="my-1 col-12"> Historia zakupów </a>
        <a href="{{ url('/moje_konto/ustawienia') }}" id="navItem3" class="my-1 col-12"> Ustawienia konta </a>
        <a href="#" id="navItem4" href="{{ route('logout') }}" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();" class="my-1 col-12">
            Wyloguj
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form> </a>
    </div>
</div>