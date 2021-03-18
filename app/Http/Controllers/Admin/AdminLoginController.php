<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;

class AdminLoginController extends Controller
{

    public function __constructor(){
        $this->middleware('guest:admin');
    }

    public function showLoginForm(){
        return view('admin/login');
    }

    public function login(Request $request){
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:25',
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Błędne dane.')->withInput();
        }
            
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect('admin');
            } else {
                
                return back()->with('error', 'Błędne dane.')->withInput();
        }

    }
}
