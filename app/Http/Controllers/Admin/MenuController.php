<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MenuController extends Controller
{
    public function newCategory(Request $request)
    {
        $category = $request->input('category');
        $name = $request->input('name');

        if(DB::table('menu_category')->insert(['kategoria' => $category, 'typ' => $name])){
            return back()->with('success', "Kategoria ".$name." została dodana.");
        }
        return back()->with('error', "Nie udało się dodać kategorii.");
    }

    public function deleteCategory(Request $request)
    {
        $category = $request->input('kategoria');
        $name = $request->input('typ');

        if(DB::table('menu_category')->where('kategoria', $category)->where('typ', $name)->delete()){
            return back()->with('success', "Kategoria ".$name." została usunięta.");
        }
        return back()->with('error', "Nie udało się usunąć kategorii.");
    }
}
