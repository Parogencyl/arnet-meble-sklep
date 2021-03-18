<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Request as requestUrl;

class ProductController extends Controller
{
    public function index(Request $request){
        
        $category = requestUrl::segment(2);
        $subcategory = "";
        $select = 'new';

        if(requestUrl::segment(3) !== null ){
            $subcategory = requestUrl::segment(3);
            if( DB::table('products')->where('kategoria', $subcategory)->where('w_sprzedazy', 1)->orderBy('id', 'desc')->get()){
                $products = DB::table('products')->where('kategoria', $subcategory)->orderBy('id', 'desc')->paginate(32);
            }
            return view('products', ['products' => $products, 'category' => $category, 'subcategory' => $subcategory, 'select' => $select]);
        } else {
            $products = DB::table('products')->where('rodzaj', $category)->where('w_sprzedazy', 1)->orderBy('id', 'desc')->paginate(32);
            return view('products', ['products' => $products, 'category' => $category, 'subcategory' => $subcategory, 'select' => $select]);
        }
    }

    public function sort(Request $request){

        $sortBy = $request->input('sort');
        $category = requestUrl::segment(2);
        $subcategory = "";

        
        if(requestUrl::segment(3) !== 'sort' ){
            $subcategory = requestUrl::segment(3);
            if ($sortBy == 'new') {
                if( DB::table('products')->where('kategoria', $subcategory)->where('w_sprzedazy', 1)->orderBy('id', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('kategoria', $subcategory)->orderBy('id', 'desc')->paginate(32);
                    $select = 'new';
                }
            }else if($sortBy == 'down'){
                if( DB::table('products')->where('kategoria', $subcategory)->where('w_sprzedazy', 1)->orderBy('cena', 'asc')->paginate(32)){
                    $products = DB::table('products')->where('kategoria', $subcategory)->orderBy('cena', 'asc')->paginate(32);
                    $select = 'down';
                }
            } else if($sortBy == 'up'){
                if( DB::table('products')->where('kategoria', $subcategory)->where('w_sprzedazy', 1)->orderBy('cena', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('kategoria', $subcategory)->orderBy('cena', 'desc')->paginate(32);
                    $select = 'up';
                }
            } else {
                if( DB::table('products')->where('kategoria', $subcategory)->where('w_sprzedazy', 1)->orderBy('ilosc_kupionych', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('kategoria', $subcategory)->orderBy('ilosc_kupionych', 'desc')->paginate(32);
                    $select = 'most';
                }
            }

            return redirect('/produkty'.'/'.$category.'/'.$subcategory)->with(['products' => $products, 'category' => $category, 'subcategory' => $subcategory, 'select' => $select]);           
        } else {

            if ($sortBy == 'new') {
                if( DB::table('products')->where('rodzaj', $category)->where('w_sprzedazy', 1)->orderBy('id', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('rodzaj', $category)->orderBy('id', 'desc')->paginate(32);
                    $select = 'new';
                }
            }else if($sortBy == 'down'){
                if( DB::table('products')->where('rodzaj', $category)->where('w_sprzedazy', 1)->orderBy('cena', 'asc')->paginate(32)){
                    $products = DB::table('products')->where('rodzaj', $category)->orderBy('cena', 'asc')->paginate(32);
                    $select = 'down';
                }
            } else if($sortBy == 'up'){
                if( DB::table('products')->where('rodzaj', $category)->where('w_sprzedazy', 1)->orderBy('cena', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('rodzaj', $category)->orderBy('cena', 'desc')->paginate(32);
                    $select = 'up';
                }
            } else {
                if( DB::table('products')->where('rodzaj', $category)->where('w_sprzedazy', 1)->orderBy('ilosc_kupionych', 'desc')->paginate(32)){
                    $products = DB::table('products')->where('rodzaj', $category)->orderBy('ilosc_kupionych', 'desc')->paginate(32);
                    $select = 'most';
                }
            }

            return redirect('/produkty'.'/'.$category)->with(['products' => $products, 'category' => $category, 'subcategory' => $subcategory, 'select' => $select]);           
        }
    }
}
