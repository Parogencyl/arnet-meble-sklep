<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request){
        $email = $request->input('email');

        if (DB::table('users')->where('email', $email)->first()) {

            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $password = implode($pass);

            DB::table('users')->where('email', $email)->update(['password' => Hash::make($password)]);

            $to = $request->input('email');
            // Subject
            $subject = 'Odzyskanie hasła w seriwsie arnet-meble-sklep.';

            // Message
            $message = '
            <html>
            <head>
            <title>Wygenerowanie nowego hasła.</title>
            </head>
            <body>
            <div>
            <img src="https://arnet-meble-sklep.pl/graphics/logo.png" alt="logo" width="100">
            </div>
            <p>Witaj drogi użtkowniku, właśnie zresetowaliśmy Twoje dotychczasowe hasło na nowe. </p>
            <p> <b>Hasło:</b> '.$password.' </p>
            <p> Z powyższym hasłem możliwe jest ponowne zalogowanie się do konta w serwisie <a href="https://arnet-meble-sklep.pl/"> arnet-meble-sklep </a> </p>
            <p> Po zalogowaniu się zachęcamy do przejścia do zakładki "Ustawienia konta", gdzie można zmienić hasło. </p>
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
            
            return redirect('logowanie')->with('success', 'Nowe hasło zostało przesłane na email.');
        } else {
            return back()->with('error', 'Podany email nie istnieje.');
        }
    }
}
