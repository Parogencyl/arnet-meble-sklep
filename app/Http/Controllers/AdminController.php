<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/admin/main');
    }

    public function delete(Request $request){
        
        $file = $request->input('file');
        
        if(File::delete(public_path($file))){
            return back()->with('success', 'Zdjęcie zostało usunięte.');
        } else {
            return back()->with('error', 'Nie udało się usunąć zdjęcia.');
        }
        
    }
    
    public function add(Request $request){
        
        $fileName = $request->file('image');
        $directory = $request->input('directory');

        if($fileName){

            if($directory == "kitchen"){
                $images = File::allFiles(public_path('/graphics/gallery/kitchen'));
            } else if($directory == "bathroom"){
                $images = File::allFiles(public_path('/graphics/gallery/bathroom'));
            } else {
                $images = File::allFiles(public_path('/graphics/gallery/other'));
            }

            for ($i=0; $i < count($images); $i++) { 
                $img[$i] =  $images[$i]->getFilename();
            }

            if(count($images)){
                natsort($img);
                foreach($img as $image){
                    $array = $image;
                }
                preg_match_all('!\d+!', $array, $matches);
                $number = (int)$matches[0][0]+1;
            } else {
                $number = 1;
            }

            $name = "image".$number.".jpg";

            if(Storage::disk('public_uploads_implementations')->putFileAs('/'.$directory, $fileName, $name)){
                return back()->with('success', 'Udało się dodać nowe zdjęcie.');
            } else {
                return back()->with('error', 'Nie udało się dodać nowego zdjęcia');
            }

    }else {
            return back()->with('error', 'Należy wybrać plik przed dodaniem');
        }
        
    }

    public function addBaner(Request $request){
        
        $fileName = $request->file('baner');
        $number = $request->input('el');

        $name = "baner".$number.".jpg";

        if(Storage::disk('public_uploads_baners')->putFileAs('/baners', $fileName, $name)){
            return back()->with('success', 'Udało się dodać nowe zdjęcie.');
        } else {
            return back()->with('error', 'Nie udało się dodać nowego zdjęcia');
        }

    }

    public function deleteBaner(Request $request){
        
        $number = $request->input('file');

        $name = "/graphics/baners/baner".$number.".jpg";

        //dd($number);

        if(File::exists(public_path('graphics/baners/baner'.$number.'.jpg'))){
            if(File::delete(public_path('graphics/baners/baner'.$number.'.jpg'))){
                return back()->with('success', 'Udało się usunąć zdjęcie numer '.$number);
            } else {
                return back()->with('error', 'Nie udało się usunąć zdjęcia numer '.$number);
            }
        } else {
            return back()->with('error', 'Nie ma takiego pliku.');
        }
    }
}
