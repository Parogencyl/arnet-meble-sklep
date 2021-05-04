<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use Illuminate\Support\Facades\Hash;

class InformationController extends Controller
{
    /*
        Zarządzanie danymi użytkownika
    */

    // imię

    public function addName(Request $request){
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'string', 'max:255', 'min:3'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorName', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['name' => $request->input('name')])){
            return back();
        }
        
        return back()->with('errorName', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteName(){
        DB::table('users')->where('email', Auth::user()->email)->update(['name' => null]);
        return back();
    }

    // naziwsko

    public function addSurname(Request $request){
        $validator = Validator::make(request()->all(), [
            'surname' => ['required', 'string', 'max:255', 'min:3'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorSurname', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['surname' => $request->input('surname')])){
            return back();
        }
        
        return back()->with('errorSurname', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteSurname(){
        DB::table('users')->where('email', Auth::user()->email)->update(['surname' => null]);
        return back();
    }

    // numer telefonu

    public function addPhone(Request $request){
        $validator = Validator::make(request()->all(), [
            'phone' => ['required', 'string', 'max:16', 'min:7'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorPhone', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['phone' => $request->input('phone')])){
            return back();
        }
        
        return back()->with('errorPhone', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deletePhone(){
        DB::table('users')->where('email', Auth::user()->email)->update(['phone' => null]);
        return back();
    }
    
    public function addStreet(Request $request){
        $validator = Validator::make(request()->all(), [
            'street' => ['required', 'string', 'max:16', 'min:7'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorStreet', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['street' => $request->input('street')])){
            return back();
        }
        
        return back()->with('errorStreet', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteStreet(){
        DB::table('users')->where('email', Auth::user()->email)->update(['street' => null]);
        return back();
    }

    // numer mieszkania

    public function addLocalNumber(Request $request){
        $validator = Validator::make(request()->all(), [
            'localNumber' => ['required', 'string', 'max:15'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorLocalNumber', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['local_number' => $request->input('localNumber')])){
            return back();
        }
        
        return back()->with('errorLocalNumber', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteLocalNumber(){
        DB::table('users')->where('email', Auth::user()->email)->update(['local_number' => null]);
        return back();
    }

    // kod pocztowy
    
    public function addZip(Request $request){
        $validator = Validator::make(request()->all(), [
            'zip' => ['required', 'string', 'regex:/^[0-9]{2}-?[0-9]{3}$/'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorZip', "Wprowadzone dane nie spełniają wymagań. Kod pocztowy powinien posiadać formę 00-000")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['zip' => $request->input('zip')])){
            return back();
        }
        
        return back()->with('errorZip', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteZip(){
        DB::table('users')->where('email', Auth::user()->email)->update(['zip' => null]);
        return back();
    }

    // miasto
    
    public function addCity(Request $request){
        $validator = Validator::make(request()->all(), [
            'city' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorCity', "Wprowadzone dane nie spełniają wymagań.")->withInput();
        }
        
        if(DB::table('users')->where('email', Auth::user()->email)->update(['city' => $request->input('city')])){
            return back();
        }
        
        return back()->with('errorCity', "Wprowadzone dane nie spełniają wymagań.")->withInput();   
    }

    public function deleteCity(){
        DB::table('users')->where('email', Auth::user()->email)->update(['city' => null]);
        return back();
    }


     // zmiena hasła
    
     public function changePassword(Request $request){
        $validator = Validator::make(request()->all(), [
            'oldPassword' => ['required', 'string', 'min:8', 'max:25'],
            'password' => ['required', 'string', 'min:8', 'max:25', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorPassword', "Wprowadzone dane nie spełniają wymagań.");
        }

        if(Hash::check($request->input('oldPassword'), Auth::user()->password)){
            if(DB::table('users')->where('email', Auth::user()->email)->update(['password' => Hash::make($request->input('password'))]) ){
                return back()->with('success', "Hasło zostało zmienione.");
            }
        }else {
            return back()->with('errorOldPassword', "Podane hasło jest nieprawidłowe.");
        }
        
        return back()->with('errorPassword', "Wprowadzone dane nie spełniają wymagań.");   
    }

    // usunięcie konta

    public function deleteAccount(Request $request){
        $validator = Validator::make(request()->all(), [
            'delete' => ['required', 'string', 'min:3', 'max:3'],
        ]);
        if ($validator->fails()) {
            return back()->with('errorDelete', "Wprowadzone dane nie spełniają wymagań.");
        }

        if(strtoupper($request->input('delete')) == 'TAK'){
            if(DB::table('users_favorite')->where('user_id', Auth::user()->id)->delete() );
            if(DB::table('user_history')->where('user_id', Auth::user()->id)->delete() );
            if(DB::table('cart')->where('user_id', Auth::user()->id)->delete() );

            if(DB::table('users')->where('email', Auth::user()->email)->delete() ){
                Auth::logout();
                return redirect('/');
            }
        }else {
            return back()->with('errorDelete', "Należy wpisać TAK, aby usunąć konto.");
        }
        
        return back()->with('errorDelete', "Należy wpisać TAK, aby usunąć konto.");   
    }

    // Dodanie opinii

    public function addOpinion(Request $request){
        
        if(DB::table('opinions')->insert(['evaluation' => $request->input('evaluation'), 'image' => $request->input('image'),
        'product' => $request->input('product'), 'name' => $request->input('name'), 'comment' => $request->input('comment')])){

            $id = DB::table('opinions')->get();
            for ($i=0; $i < count($id); $i++) { 
                $number[$i] = json_decode( json_encode($id[$i]), true);
            }

            $id = $number[count($id)-1]['id'];
            
            DB::table('user_history')->where('id', $request->input('element'))->update(['evaluation' => $request->input('evaluation'), 
            'comment' => $request->input('comment'), 'opinion_id' => $id]);

            return back();

        } else {   
            if(DB::table('opinions')->insert(['evaluation' => $request->input('evaluation'), 'image' => $request->input('image'),
            'product' => $request->input('product'), 'name' => $request->input('name')])){

                $id = DB::table('opinions')->get();
                for ($i=0; $i < count($id); $i++) { 
                    $number[$i] = json_decode( json_encode($id[$i]), true);
                }
                $id = $number[count($id)-1]['id'];

                DB::table('user_history')->where('id', $request->input('element'))->update(['evaluation' => $request->input('evaluation'), 
                'opinion_id' => $id ]);

                return back();

            }else{
                return back()->with('errorAdd', "Wprowadzone dane nie spełniają wymagań.");
            }
        }
        
        return back()->with('errorAdd', "Wprowadzone dane nie spełniają wymagań.");   
    }

    // Usuniecie opinii

    public function deleteOpinion(Request $request){
        if(DB::table('user_history')->where('id', $request->input('element'))->update(['evaluation' => null, 
            'comment' => null, 'opinion_id' => null]) ){

                DB::table('opinions')->where('id', $request->input('evaluationId'))->delete();
                return back();

        }
        
        return back()->with('errorDelete', "Nie udało się usunąć komentarza.");   
    }
}
