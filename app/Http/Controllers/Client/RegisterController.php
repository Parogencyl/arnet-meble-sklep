<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __constructor(){
        $this->middleware('guest');
    }

    public function showRegisterForm(){
        return view('auth/register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ])){


            // Multiple recipients
            $to = $request->input('email');

            // Subject
            $subject = 'Witaj w serwisie arnet-meble-sklep.';


            // Message
            $message = '
            <html>
            <head>
            <title>Dziękujemy za zarejstrowanie się w serwisie arnet-meble-sklep</title>
            </head>
            <body>
            <div>
            <img src="https://arnet-meble-sklep.pl/graphics/logo.png" alt="logo" width="100">
            </div>
            <p>Witaj, właśnie zarejestrowałeś/aś się w serwisie <a href="https://arnet-meble-sklep.pl/"> arnet-meble-sklep </a> - za co bardzo dziękujemy. </p>
            <p> Dzięki rejestracji możliwe jest przeglądanie historii zamówień, a także wystawianie opinii zakupionym produktom. </p>
            <p> W panelu użytkownika możliwe jest także podanie danych osobowych oraz miejsca zamieszkania, co usprawia proces zamawiania produktów w naszym seriwsie. </p>
            <hr>
            <p> Pozdrawiamy i zapraszamy do zamawiania produktów w naszym seriwsie <a href="https://arnet-meble-sklep.pl/"> arnet-meble-sklep </a> </p> 
            <p> Nasza obsługa jest czynna od 8:00 do 16:00 we wszystkie dni robocze. W razie potrzebny prosimy o kontakt za pośrednictwem zakłądki w naszym sewisie 
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
            $headers[] = 'To: '.$request->input('email');
            $headers[] = 'From: Arnet Meble Sklep <arnetgryfow@poczta.onet.pl>';

            // Mail it
            mail($to, $subject, $message, implode("\r\n", $headers));

            return redirect('logowanie');
        }
        
        return redirect()->back()->with('error', "Wprowadzone dane nie spełniają wymagań.")->withInput();   

    }
}
