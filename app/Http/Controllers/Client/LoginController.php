<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;

class LoginController extends Controller
{

    public function __constructor(){
        $this->middleware('guest');
    }

    public function showLoginForm(){
        return view('auth/login');
    }

    public function login(Request $request){

        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:25',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('error', 'Błędne dane.')
                ->withInput();
        }

        if(Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/moje_konto/zarzadzanie');
        } else {
            return back()->with('error', 'Błędne dane');
        }

    }
}
