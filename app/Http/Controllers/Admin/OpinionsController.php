<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;

class OpinionsController extends Controller
{
    public function addComment(Request $request){
        if(DB::table('opinions')->where('id', $request->input('idComment'))->update(['accepted' => $request->input('accepted')])){
            return back()->with('success', 'Komentarz został odblokowany.');
        }
        return back()->with('error', 'Nie udało się odblokować komentarza.');
    }

    public function deleteComment(Request $request){
        if(DB::table('opinions')->where('id', $request->input('idComment'))->update(['accepted' => $request->input('accepted')])){
            return back()->with('success', 'Komentarz został usunięty.');
        }
        return back()->with('error', 'Nie udało się usunąć komentarza.');
    }
}
