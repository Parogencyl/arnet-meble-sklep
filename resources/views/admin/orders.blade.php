<?php
    $orders = DB::table('order')->orderBy('id', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
    if (session()->get('ordersSort') != null) {
        $orders = session()->get('ordersSort') ;
        $way = session()->get('way') ;
    }else{
        $way = NULL;
    }

?>
@extends('layouts.adminNav')
<link rel="stylesheet" href="{{ asset('css/admin/opinions.css') }}">
<style>
    table {
        width: 94%;
        padding-left: 3%;
        padding-right: 3%;
    }

    @media screen and (max-width: 1600px) {
        table {
            width: 99%;
            padding-left: 0.5%;
            padding-right: 0.5%;
        }
    }

    th {
        cursor: default;
    }
</style>

@section('content')

<div>
    <h1 class="text-center font-weight-bold mb-5 mt-4"> Zamówienia </h1>

    <table class="table text-center table-striped table-bordered table-responsive" id="data">
        <caption class="text-center"> Realizacja zamówień </caption>
        <thead class="thead-dark">
            <tr style="cursor: pointer">
                <th scope="col" class="align-middle">
                    <form action="{{ url('/admin/zamowienia/sort') }}" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="typeSort" value="lp" class="d-none">
                        @if ($way == 'idUp')
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Lp. <i
                                class="fas fa-arrow-up"></i>
                        </button>
                        @elseif($way == 'idDown')
                        <input type="text" name="way" value="up" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Lp. <i
                                class="fas fa-arrow-down"></i>
                        </button>
                        @else
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Lp.
                        </button>
                        @endif
                    </form>
                </th>
                <th scope="col" class="align-middle"> Zamówienie </th>
                <th scope="col" class="align-middle"> Kwota </th>
                <th scope="col" class="align-middle"> Osoba </th>
                <th scope="col" class="align-middle"> Adres </th>
                <th scope="col" class="align-middle"> Email </th>
                <th scope="col" class="align-middle"> Telefon </th>
                <th scope="col" class="align-middle"> Pobranie </th>
                <th scope="col" class="align-middle"> Faktura </th>
                <th scope="col" class="align-middle"> Opłacone </th>
                <th scope="col" class="align-middle"> Uwagi </th>
                <th scope="col" class="align-middle"> Numer zamówienia </th>
                <th scope="col" class="align-middle" style="cursor: pointer">
                    <form action="{{ url('/admin/zamowienia/sort') }}" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="typeSort" value="date" class="d-none">
                        @if ($way == 'dateUp')
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Data zakupu
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        @elseif($way == 'dateDown')
                        <input type="text" name="way" value="up" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Data zakupu
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        @else
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Data zakupu
                        </button>
                        @endif
                    </form>
                </th>
                <th scope="col" class="align-middle" style="cursor: pointer">
                    <form action="{{ url('/admin/zamowienia/sort') }}" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="typeSort" value="status" class="d-none">
                        @if ($way == 'statusUp')
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Status
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        @elseif($way == 'statusDown')
                        <input type="text" name="way" value="up" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Status
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        @else
                        <input type="text" name="way" value="down" class="d-none">
                        <button type="submit" class="border-0 bg-transparent text-white font-weight-bold"> Status
                        </button>
                        @endif
                    </form>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
            <tr>
                <td scope="row" class="align-middle font-weight-bold"> {{ $item->id }} </td>
                <td class="align-middle"> {{ $item->zamowienie }} </td>
                <td class="align-middle"> {{ $item->laczna_kwota }} zł</td>
                <td class="align-middle"> {{ $item->name }} {{ $item->surname }} </td>
                <td class="align-middle"> {{ $item->street }}
                    {{ $item->local_number }} <br> {{ $item->zip }} {{ $item->city }} </td>
                <td class="align-middle"> {{ $item->email }} </td>
                <td class="align-middle"> {{ $item->phone }} </td>
                @if ($item->rodzaj_platnosci == "Przelew")
                <td class="align-middle"> Nie </td>
                @else
                <td class="align-middle"> Tak </td>
                @endif
                @if ($item->potwierdzenie_sprzedazy == "Paragon")
                <td class="align-middle"> Nie </td>
                @else
                <td class="align-middle"> {{$item->company}} <br> NIP: {{$item->nip}} <br> {{$item->fakturaStreet}}
                    {{$item->fakturaLocal}} <br> {{$item->fakturaZip}} {{$item->fakturaCity}} </td>
                @endif
                <td class="align-middle"> {{ $item->status }} </td>
                <td class="align-middle"> {{ $item->uwagi_do_zamowienia }} </td>
                <td class="align-middle"> {{ $item->number_zamowienia }} </td>
                <td class="align-middle"> {{ $item->created_at }} </td>
                <td class="align-middle">
                    <form action="/admin/zamowienia/realizacja" method="POST" class="mb-0">
                        @csrf
                        <input type="text" name="id" value="{{$item->id}}" class="d-none">
                        <select name="realizacja" onchange="form.submit()">
                            @if ($item->realizacja == '1')
                            <option value="1" selected='selected'> Przygotowywanie </option>
                            <option value="2"> Gotowe do wysyłki </option>
                            <option value="3"> Wysłane </option>
                            <option value="4"> Dostarczone </option>
                            <option value="5"> Zwrot </option>
                            @endif
                            @if ($item->realizacja == '2')
                            <option value="1"> Przygotowywanie </option>
                            <option value="2" selected='selected'> Gotowe do wysyłki </option>
                            <option value="3"> Wysłane </option>
                            <option value="4"> Dostarczone </option>
                            <option value="5"> Zwrot </option>
                            @endif
                            @if ($item->realizacja == '3')
                            <option value="1"> Przygotowywanie </option>
                            <option value="2"> Gotowe do wysyłki </option>
                            <option value="3" selected='selected'> Wysłane </option>
                            <option value="4"> Dostarczone </option>
                            <option value="5"> Zwrot </option>
                            @endif
                            @if ($item->realizacja == '4')
                            <option value="1"> Przygotowywanie </option>
                            <option value="2"> Gotowe do wysyłki </option>
                            <option value="3"> Wysłane </option>
                            <option value="4" selected='selected'> Dostarczone </option>
                            <option value="5"> Zwrot </option>
                            @endif
                            @if ($item->realizacja == '5')
                            <option value="1"> Przygotowywanie </option>
                            <option value="2"> Gotowe do wysyłki </option>
                            <option value="3"> Wysłane </option>
                            <option value="4"> Dostarczone </option>
                            <option value="5" selected='selected'> Zwrot </option>
                            @endif
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mx-auto mt-4 mb-4" id="pagination">
        {{ $orders->render() }}
    </div>

</div>


@endsection