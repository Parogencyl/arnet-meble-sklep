<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegisterController extends Controller
{
    public function __constructor(){
        $this->middleware('guest:admin');
    }

    public function showRegisterForm(){
        return view('admin/register');
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

        if(Admin::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ])){
            return redirect('admin/login');
        }
        
          

    }
}
