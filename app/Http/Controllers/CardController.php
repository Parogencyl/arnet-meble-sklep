<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderPostRequest;
use App\Http\Requests\OrderFakturaPostRequest;
use DB;
use Auth;
use App\Http\Controllers\PrzelewyController;

class CardController extends Controller
{

    public function noLogin()
    {
        if(Auth::user()){
            return back();
        }
        return back()->with('error', "Nie jesteś zalogowany."); 
    }

    // Dodanie do ulubionych
    public function addToFavorites(Request $request){
        $id = $request->input('id');

        if(Auth::user()){
            
            if(DB::table('users_favorite')->insert(['user_id' => Auth::user()->id, "kategoria_id" => $id])){
                return back()->with('success', "Produkt został dodoany do listy ulubionych.");
            }
        }else {
            if(!session()->has('favorites')){
                $favorite = [$id];
                session()->put('favorites', $favorite);
            }else{
                session()->push('favorites', $id);
            }
            return back()->with('success', "Produkt został dodoany do listy ulubionych.");
        }
        return back()->with('error', "Nie udało się dodać produktu do listy ulubionych.");
    }
    
    // Usuwanie z ulubionych
    public function deleteFromFavorites(Request $request){
        $id = $request->input('id');
        
        if(Auth::user()){
            if(DB::table('users_favorite')->where('user_id', Auth::user()->id)->where("kategoria_id", $id)->delete()){
                return back()->with('success', "Produkt został usunięty z listy ulubionych.");
            }
        }else{
            for ($i=0; $i < count(session()->get('favorites')); $i++) { 
                if(session()->get('favorites')[$i] == $id){
                    $elements = session()->get('favorites');
                    unset($elements[$i]);
                    $elements = array_values($elements);
                    session()->put('favorites', $elements);
                    break;
                }
            }
            return back()->with('success', "Produkt został usunąć z listy ulubionych.");
        }
        return back()->with('error', "Nie udało się usunąć produktu z listy ulubionych.");
    }
    
    // Dodanie do koszyka
    public function addToCard(Request $request){
        $id = $request->input('id');
        $amount = 1;
        if($request->input('amount')){
            $amount = $request->input('amount');
        }
        
        if(Auth::user()){
            if(DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $id)->first()){
                $cart = DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $id)->first();
                DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $id)->update(['amount' => $amount+$cart->amount]);
                return back()->with('success', 'Produkt został dodany do koszyka.');
            }else{
                if(DB::table('cart')->insert(['user_id' => Auth::user()->id, 'kategoria_id' => $id, 'amount' => $amount])){
                    return back()->with('success', 'Produkt został dodany do koszyka.');
                }
            }
        }else{
            if(!session()->has('cart')){
                $cart = (object)['id' => $id, 'amount' => $amount];
                session()->push('cart', $cart);
            }else{
                $add = 0;
                for ($i=0; $i < count(session()->get('cart')); $i++) { 
                    if(session()->get('cart')[$i]->id == $id){
                        session()->get('cart')[$i]->amount += $amount;
                        $add = 1;
                        break;
                    }
                }
                if($add == 0){
                $obj = session()->get('cart');
                $obj[] = (object)['id' => $id, 'amount' => $amount]; 
                session()->put('cart', $obj);
                }
            }
            return back()->with('success', 'Produkt został dodany do koszyka.');
        }
            return back()->with('error', "Nie udało się dodać produktu do koszyka.");
    }

    //Usunięcie z koszyka
    public function deleteFromCart(Request $request){
        $kategoria_id = $request->input('kategoria_id');
        
        if(Auth::user()){
            if(DB::table('cart')->where('kategoria_id', $kategoria_id)->where('user_id', Auth::user()->id)->delete()){
                return back()->with('success', 'Produkt został usunięty z koszyka.');
            }
        }else{
            for ($i=0; $i < count(session()->get('cart')); $i++) { 
                if(session()->get('cart')[$i]->id == $kategoria_id){
                    $elements = session()->get('cart');
                    unset($elements[$i]);
                    $elements = array_values($elements);
                    session()->put('cart', $elements);
                    break;
                }
            }
            return back()->with('success', 'Produkt został usunięty z koszyka.');
        }
        return back()->with('error', "Nie udało się usunąć produktu z koszyka.");
    }
    
    public function summaryCart(Request $request){
        if(Auth::user()){
            $products = DB::table('cart')->where('user_id', Auth::user()->id)->get();
            for ($i=0; $i < count($products); $i++) { 
                DB::table('cart')->where('user_id', Auth::user()->id)->where('kategoria_id', $request->input('id'.$i))->update(['amount' => $request->input('amount'.$i)]);
            }
            session(['payment' => $request->input('payment')]);
            session(['delivery' => $request->input('delivery')]);
            return redirect('/koszyk/zamówienie'); 
        }else{
            for ($i=0; $i < count(session()->get('cart')); $i++) { 
                $amount[$i] = $request->input('amount'.$i);
                session()->get('cart')[$i]->amount = $amount[$i];
            }
            session(['payment' => $request->input('payment')]);
            session(['delivery' => $request->input('delivery')]);
            return redirect('/koszyk/zamówienie'); 
        }
        return back();
    }

    // Bez faktury
    public function summaryOrder(OrderPostRequest $request){
        if(Auth::user()){
            $validated = $request->validated();
            if($validated){
                $email = $request->input('email');
                $name = $request->input('name');
                $surname = $request->input('surname');
                $street = $request->input('street');
                $numberOfFlat = $request->input('numberOfFlat');
                $city = $request->input('city');
                $zip = $request->input('zip');
                $phone = $request->input('phone');
                $czyFaktura = $request->input('faktura');
                
                $client = (object)['email' => $email, 'name' => $name, 'surname' => $surname, 'street' => $street,
                'numberOfFlat' => $numberOfFlat, 'city' => $city, 'zip' => $zip, 'phone' => $phone, 'faktura' => $czyFaktura];
                session(['client' => $client]);
                
                if($request->input('commentsInput')){
                    session(['comment' => $request->input('comments')]);
                } else {
                    session(['comment' => null]);
                }

                return redirect('/koszyk/podsumowanie'); 
            }
        }else{
            $validated = $request->validated();
            if($validated){
                if($request->input('createAccount')){
                    session(['create' => true]);
                    $password = $request->input('password');
                    session(['password' => $password]);
                } else {
                    session(['create' => false]);
                }
                
                $email = $request->input('email');
                $name = $request->input('name');
                $surname = $request->input('surname');
                $street = $request->input('street');
                $numberOfFlat = $request->input('numberOfFlat');
                $city = $request->input('city');
                $zip = $request->input('zip');
                $phone = $request->input('phone');
                $czyFaktura = $request->input('faktura');
                
                $client = (object)['email' => $email, 'name' => $name, 'surname' => $surname, 'street' => $street,
                'numberOfFlat' => $numberOfFlat, 'city' => $city, 'zip' => $zip, 'phone' => $phone, 'faktura' => $czyFaktura];
                session(['client' => $client]);
                
                if($request->input('commentsInput')){
                    session(['comment' => $request->input('comments')]);
                } else {
                    session(['comment' => null]);
                }
                
                return redirect('/koszyk/podsumowanie'); 
            }
        }
        return back()->withInput();
    }

    // Z fakturą
    public function summaryOrderFaktura(OrderFakturaPostRequest $request){
        if(Auth::user()){
            $validated = $request->validated();
            if($validated){
                $email = $request->input('email');
                $name = $request->input('name');
                $surname = $request->input('surname');
                $street = $request->input('street');
                $numberOfFlat = $request->input('numberOfFlat');
                $city = $request->input('city');
                $zip = $request->input('zip');
                $phone = $request->input('phone');
                $czyFaktura = $request->input('faktura');
                
                $client = (object)['email' => $email, 'name' => $name, 'surname' => $surname, 'street' => $street,
                'numberOfFlat' => $numberOfFlat, 'city' => $city, 'zip' => $zip, 'phone' => $phone, 'faktura' => $czyFaktura];
                session(['client' => $client]);

                $company = $request->input('company');
                $nip = $request->input('nip');
                $street2 = $request->input('street2');
                $numberOfFlat2 = $request->input('numberOfFlat2');
                $city2 = $request->input('city2');
                $zip2 = $request->input('zip2');
                
                $faktura = (object)['company' => $company, 'nip' => $nip, 'street2' => $street2,
                'numberOfFlat2' => $numberOfFlat2, 'city2' => $city2, 'zip2' => $zip2];
                session(['faktura' => $faktura]);
                
                if($request->input('commentsInput')){
                    session(['comment' => $request->input('comments')]);
                } else {
                    session(['comment' => null]);
                }

                return redirect('/koszyk/podsumowanie'); 
            }
        }else{
            $validated = $request->validated();
            if($validated){
                if($request->input('createAccount')){
                    session(['create' => true]);
                    $password = $request->input('password');
                    session(['password' => $password]);
                } else {
                    session(['create' => false]);
                }

                $email = $request->input('email');
                $name = $request->input('name');
                $surname = $request->input('surname');
                $street = $request->input('street');
                $numberOfFlat = $request->input('numberOfFlat');
                $city = $request->input('city');
                $zip = $request->input('zip');
                $phone = $request->input('phone');
                $czyFaktura = $request->input('faktura');
                
                $client = (object)['email' => $email, 'name' => $name, 'surname' => $surname, 'street' => $street,
                'numberOfFlat' => $numberOfFlat, 'city' => $city, 'zip' => $zip, 'phone' => $phone, 'faktura' => $czyFaktura];
                session(['client' => $client]);

                $company = $request->input('company');
                $nip = $request->input('nip');
                $street2 = $request->input('street2');
                $numberOfFlat2 = $request->input('numberOfFlat2');
                $city2 = $request->input('city2');
                $zip2 = $request->input('zip2');

                $faktura = (object)['company' => $company, 'nip' => $nip, 'street2' => $street2,
                'numberOfFlat2' => $numberOfFlat2, 'city2' => $city2, 'zip2' => $zip2];
                session(['faktura' => $faktura]);
                
                if($request->input('commentsInput')){
                    session(['comment' => $request->input('comments')]);
                } else {
                    session(['comment' => null]);
                }

                return redirect('/koszyk/podsumowanie'); 
            }
        }
        return back()->withInput();
    }

    function buy(Request $request){

        $sessionProducts = array();
        $products = array();
        $total = $totalProducts = $delivery = 0;

        if(Auth::id()){
            $products = DB::table('cart')->where('user_id', Auth::user()->id)->join('products', 'cart.kategoria_id', '=', 'products.id')->get();
            for ($i=0; $i < count($products); $i++) { 
                if($products[$i]->ilosc_dostepnych && $products[$i]->w_sprzedazy){
                    $total += $products[$i]->cena * $products[$i]->amount;
                    $totalProducts += $products[$i]->cena * $products[$i]->amount;
                    if (!(session()->get('delivery') == 'Odbiór osobisty')) {
                        $delivery += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
                        $total += (ceil(($products[$i]->amount)/($products[$i]->ilosc_w_paczce)))*$products[$i]->koszt_wysylki;
                    }
                }
            }
        } else {
            if(session()->get('cart')){
                for ($i=0; $i < count(session()->get('cart')); $i++) { 
                    array_push($sessionProducts, DB::table('products')->where('id', session()->get('cart')[$i]->id)->first());
                    $sessionProducts[$i]->amount = session()->get('cart')[$i]->amount;
                }
                for ($i=0; $i < count($sessionProducts); $i++) { 
                    if($sessionProducts[$i]->ilosc_dostepnych && $sessionProducts[$i]->w_sprzedazy){
                        $total += $sessionProducts[$i]->cena * $sessionProducts[$i]->amount;
                        $totalProducts += $sessionProducts[$i]->cena * $sessionProducts[$i]->amount;
                        if (!(session()->get('delivery') == 'Odbiór osobisty')) {
                            $delivery += (ceil(($sessionProducts[$i]->amount)/($sessionProducts[$i]->ilosc_w_paczce)))*$sessionProducts[$i]->koszt_wysylki;
                            $total += (ceil(($sessionProducts[$i]->amount)/($sessionProducts[$i]->ilosc_w_paczce)))*$sessionProducts[$i]->koszt_wysylki;
                        }
                    }
                }
            }
            $products = $sessionProducts;
        }

        $total = number_format($total, 2, '.', '');

        $all_orders = DB::table("order")->orderBy('id', 'DESC')->first();
        if ($all_orders == null) {
            $all_orders = 0;
        } else {
            $all_orders = substr($all_orders->number_zamowienia, 0, -1);
        }
            
        
        $order_number = '';
        $all_orders += 1;
        for ($i=0; $i < 8-(strlen($all_orders)); $i++) { 
            $order_number .= '0';
        }
        $order_number .= $all_orders;
        $order_number .= 'A';
        
        $order_list = '';
        foreach($products as $product){
            $order_list .= $product->nazwa . ' - ' . $product->amount . ' szt. ('. $product->cena . '/szt.)'.' / ';
        }
        
        if (session()->get('payment') == 'Płatność online Przelewy24') {
            $type_of_payment = 'Przelew';
        }else{
            $type_of_payment = 'Za pobraniem';
        }

        if (session('client')->faktura == 'faktura') {
            $method_of_sales = 'Faktura';
            if (DB::table('faktura')->where('nip', session('faktura')->nip)->first()) {
                $faktura_id = DB::table('faktura')->where('nip', session('faktura')->nip)->first();
                $faktura_id = $faktura_id->id;
            } else {
                DB::table('faktura')->insert(['company' => session('faktura')->company, 'nip' => session('faktura')->nip, 'street' => session('faktura')->street2, 
                'local_number' => session('faktura')->numberOfFlat2, 'zip' => session('faktura')->zip2, 'city' => session('faktura')->city2]); 
                $faktura_id = DB::table('faktura')->where('nip', session('faktura')->nip)->first();
                $faktura_id = $faktura_id->id;
            }
        }else{
            $method_of_sales = 'Paragon';
            $faktura_id = NULL;
        }

        $_POST['p24_session_id'] = uniqid();
        $_POST['p24_order_id'] = $order_number;

        if(DB::table('order')->insert(['zamowienie' => $order_list, 'laczna_kwota' => $total, 'number_zamowienia' => $order_number, 
        'rodzaj_platnosci' => $type_of_payment, 'status' => 'Nieopłacone', 'uwagi_do_zamowienia' => session()->get('comment'),
        'sposob_dostawy' => session()->get('delivery'), 'numer_sesji' => $_POST['p24_session_id'],
        'potwierdzenie_sprzedazy' => $method_of_sales, 'faktura_id' => $faktura_id, 'email' => session('client')->email,
        'name' => session('client')->name, 'surname' => session('client')->surname, 'phone' => session('client')->phone,
        'street' => session('client')->street, 'local_number' => session('client')->numberOfFlat, 'zip' => session('client')->zip,
        'city' => session('client')->city])){

            $tableProducts = '';

            foreach($products as $product){
                $value = DB::table('products')->where('id', $product->id)->first();
                $elements = $value->ilosc_dostepnych - $product->amount;
                $value = $value->ilosc_kupionych + $product->amount;
                DB::table('products')->where('id', $product->id)->update(['ilosc_kupionych' => $value, 'ilosc_dostepnych' => $elements]);
                if(session()->get('delivery') == 'Odbiór osobisty'){
                    $product->koszt_wysylki = 0;
                }
                if (Auth::id()) {
                    DB::table('user_history')->insert(['user_id' => Auth::user()->id, 'price' => $product->cena, 'price_delivery' => $product->koszt_wysylki,
                    'product' => $product->nazwa, 'category' => $product->kategoria, 'delivery_number' => $order_number, 'image' => $product->zdjecie1, 'street' =>  session('client')->street, 
                    'local_number' =>  session('client')->numberOfFlat, 'zip' =>  session('client')->zip, 'city' =>  session('client')->city, 
                    'name' =>  session('client')->name, 'surname' =>  session('client')->surname, 'phone' =>  session('client')->phone]);

                    DB::table('cart')->where('user_id', Auth::user()->id)->delete();
                } else {
                    session()->forget('cart');
                }

                $tableProducts .= "<tr>
                <td style='text-align:center'>".ucfirst($product->nazwa)."</td>
                <td style='text-align:center'>".$product->amount."</td>
                <td style='text-align:center'>".($product->cena+$product->koszt_wysylki)." zł</td>
                <td style='text-align:center'>".$product->koszt_wysylki." zł</td>
                </tr>";
            }

            // Multiple recipients
            $to = session('client')->email;

            // Subject
            $subject = 'Dziękujemy za zakup.';


            // Message
            $message = '
            <html>
            <head>
            <title>Dziękujemy za zakup w serwisie Arnet Meble Sklep</title>
            </head>
            <body>
            <div>
            <img src="https://arnet-meble-sklep.pl/graphics/logo.png" alt="logo" width="200">
            </div>
            <p>Witaj, otrzymaliśmy Twoje zamówienie złożone w serwisie <a href="https://arnet-meble-sklep.pl">arnet-meble-sklep</a> - za co bardzo dziękujemy. </p>
            <p> Poniżej znajdują się informacje dotyczące Twojego zamówienia. </p>
            <p> <b> Numer zamówienia:</b> '.$order_number.'</p>
            <p> <b> Metoda płatności:</b> '.$type_of_payment.'</p>
            <p> <b> Metoda dostawy:</b> '.session()->get('delivery').' </p>
            <hr>
            <table>
                <tr>
                <th style="text-align:center">Produkt</th><th style="text-align:center">Ilość</th><th style="text-align:center">Cena za sztukę</th><th style="text-align:center">Kosz dostawy</th>
                </tr>'.$tableProducts.'
            </table>
            <hr>
            <p> Pozdrawiamy i zapraszamy do zamawiania produktów w naszym seriwsie <a href="https://arnet-meble-sklep.pl/"> arnet-meble-sklep </a> </p> 
            <p> Nasza obsługa jest czynna od 8:00 do 16:00 we wszystkie dni robocze. W razie potrzebny prosimy o kontakt za pośrednictwem zakładki w naszym sewisie 
            <a href="https://arnet-meble-sklep.pl/kontakt">kontakt</a> </p>
            <p> <b> Życzymy miłego dnia! </b> </p>
            <p> <b> Arnet Meble </b> </p>
            </body>
            </html>
            ';

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers
            $headers[] = 'To: '.session('client')->name.' <'.session('client')->email.'>';
            $headers[] = 'From: Arnet Meble Sklep <arnetgryfow@poczta.onet.pl>';

            // Mail it
            mail($to, $subject, $message, implode("\r\n", $headers));
            
            if($type_of_payment == 'Przelew'){
                $oPrzelewy24_API = new PrzelewyController();

                        // Powrotny adres URL
                $p24_url_return = 'https://arnet-meble-sklep.pl/';
                
                    // Adres dla weryfikacji płatności
                $p24_url_status = 'https://arnet-meble-sklep.pl/przelew/weryfikacja';

                $pay = $oPrzelewy24_API->Verify($_POST);

                if($pay){
                    $redirect = $oPrzelewy24_API->Pay($_POST['p24_amount'], $order_number, session('client')->email, 
                    $p24_url_return, $p24_url_status, $_POST['p24_session_id']);
                    Header('Location: ' . $redirect); exit;
                }
            }
            
            return redirect('/')->with('success', "Dziękujemy za zakup.");
        }else{
            return back()->with('error', "Zakup nie powiódł się.");
        }
        
    }
}

