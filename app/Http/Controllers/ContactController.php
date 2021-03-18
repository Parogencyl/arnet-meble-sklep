<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|max:60|min:5',
            'email' => 'required|email',
            'text' => 'required',
        ]);

        $name = $request->input('name');
        $email_from = $request->input('email');
        $text = $request->input('text');
        
        $email_message = "<p>Email wysłany przez ".$name.".</p><p>Adres email: ".$email_from."</p><p>".$text."</p>";

        $to = "arnetgryfow@poczta.onet.pl"; 

        // Subject
        $subject = 'Pytanie wysłane z serwisu arnet-meble-sklep.';

        // Message
        $message = '
        <html>
        <head>
        <title>Pytanie wysłane z serwisu arnet-meble-sklep</title>
        </head>
        <body>
        <div>
        <img src="https://arnet-meble-sklep.pl/graphics/logo.png" alt="logo" width="100">
        </div>
        '.$email_message.'
        </body>
        </html>
        ';

        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        //$headers[] = 'To: Arnet Meble Sklep <arnetgryfow@poczta.onet.pl>';
        $headers[] = 'To: Arnet Meble Sklep <arnetgryfow@poczta.onet.pl>';
        $headers[] = 'From: '.$email_from;

        if(mail($to, $subject, $message, implode("\r\n", $headers))){
            return back()->with('send', 'Wiadomość została wysłana.');
        } else {
            return back()->with('error', 'Nie udało się wysłać wiadomości. Upewnij się, że wszystkie dane zostały poprawnie wprowadzone.');
        }
        
    }
}
