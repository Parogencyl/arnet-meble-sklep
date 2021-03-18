<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductManageRequest;
use App\Http\Requests\ProductAddRequest;

use DB;
use stdClass;
use OploadedFile;
use Storage;

class ProductController extends Controller
{
    public function deleteProduct(Request $request)
    {
        $id = $request->input('id');
        $name = DB::table('products')->where('id', $id)->first();

        DB::table('products')->where('id', $id)->update(['w_sprzedazy' => 0]);
        
        return back()->with('success', 'Produkt "'.$name->nazwa.'" został usunięty.');
    }

    public function productManage(ProductManageRequest $request)
    {
        switch($request->submite) {
            case 'save':
                $validated = $request->validated();
            if($validated){
                $product = DB::table('products')->where('id', $request->input('id'))->first();
                $columns = DB::getSchemaBuilder()->getColumnListing('products');
                unset($columns[count($columns)-1]);
                unset($columns[0]);
                unset($columns[1]);
                unset($columns[2]);
                $columns = array_values($columns);

                $obj = new stdClass;

                for ($i = 0; $i < count($columns); $i++){
                    $name = $columns[$i];
                    if (str_contains($name, 'zdjecie')) {
                        $file = $request->file($name);
                        if($file){
                            if ($name == 'zdjecie1') {
                                $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_1.jpg";
                                Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_1.jpg");
                                $obj->$name = $fileName;
                            } else if ($name == 'zdjecie2') {
                                $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_2.jpg";
                                Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_2.jpg");
                                $obj->$name = $fileName;
                            } else if ($name == 'zdjecie3') {
                                $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_3.jpg";
                                Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_3.jpg");
                                $obj->$name = $fileName;
                            } else if ($name == 'zdjecie4') {
                                $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_4.jpg";
                                Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_4.jpg");
                                $obj->$name = $fileName;
                            } else{
                                $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_5.jpg";
                                Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_5.jpg");
                                $obj->$name = $fileName;
                            }
                        }else{
                            unset($columns[$i]);
                            $columns = array_values($columns);
                        }
                    }else {
                        if($request->input($name)){
                            $obj->$name = lcfirst($request->input($name));
                        }else {
                            $obj->$name = null;
                        }
                    }
                }

                $obj->ilosc_kupionych = $product->ilosc_kupionych;
                //dd($obj);

            DB::table('products')->where('id', $request->input('id'))->update((array)$obj);

            }
                return back()->with('success', 'Dane produktu zostały zaktualizowane.');
                
            break;
            case 'delete':
                $id = $request->input('id');
                $name = DB::table('products')->where('id', $id)->first();
                
                DB::table('products')->where('id', $id)->update(['w_sprzedazy' => 0]);
                return redirect('/admin/produkty/'.$request->input('category').'/'.$request->input('subcategory'))->with('success', 'Produkt "'.$name->nazwa.'" został usunięty.');
            break;
        }
        return back()->with('error', 'Nie udało się wykonać danej czynności.')->withInput();
    }

    public function productAdd(ProductAddRequest $request)
    {
        $validated = $request->validated();
        if($validated){
            $columns = DB::getSchemaBuilder()->getColumnListing('products');
            unset($columns[0]);
            $columns = array_values($columns);

            $obj = new stdClass;

            for ($i = 0; $i < count($columns); $i++){
                $name = $columns[$i];
                if (str_contains($name, 'zdjecie')) {
                    $file = $request->file($name);
                    if($file){
                        if ($name == 'zdjecie1') {
                            $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_1.jpg";
                            Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_1.jpg");
                            $obj->$name = $fileName;
                        } else if ($name == 'zdjecie2') {
                            $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_2.jpg";
                            Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_2.jpg");
                            $obj->$name = $fileName;
                        } else if ($name == 'zdjecie3') {
                            $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_3.jpg";
                            Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_3.jpg");
                            $obj->$name = $fileName;
                        } else if ($name == 'zdjecie4') {
                            $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_4.jpg";
                            Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_4.jpg");
                            $obj->$name = $fileName;
                        } else{
                            $fileName = '/graphics/produkty'.'/'.$request->input('nazwa')."_5.jpg";
                            Storage::disk('public_uploads_products')->putFileAs('', $request->file($name), $request->input('nazwa')."_5.jpg");
                            $obj->$name = $fileName;
                        }
                    }else{
                        unset($columns[$i]);
                    }
                }else {
                    if(lcfirst($request->input($name))){
                        $obj->$name = lcfirst($request->input($name));
                    }else {
                        $obj->$name = null;
                    }
                }
            }

            DB::table('products')->insert((array)$obj);

        }
            return redirect('/admin/produkty/'.lcfirst($request->input('rodzaj')).'/'.lcfirst($request->input('kategoria')))->with('success', 'Produkt '.$request->input('nazwa').' został dodany.');
                
        return back()->with('error', 'Nie udało się dodać produktu.');
    }
    
    public function restore(Request $request)
    {
        $id = $request->input('id');
        
        if(DB::table('products')->where('id', $id)->update(['w_sprzedazy' => 1])){
            return back()->with('success', 'Produkt został przywrócony do sprzedaży.');
        }
        return back()->with('error', 'Nie udało się przywrócić produktu do sprzedaży.');
    }
}
