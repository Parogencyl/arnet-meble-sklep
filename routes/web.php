<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logowanie', function () {
    return view('auth/login');
});

Route::get('/realizacje', function () {
    return view('implementations');
});

Route::get('/o_nas', function () {
    return view('about');
});

Route::get('/kontakt', function () {
    return view('contact');
});

Route::post('/kontakt/send', [App\Http\Controllers\ContactController::class, 'send']);

Route::get('/opinie', function () {
    return view('footer/opinions');
});

Route::get('/ulubione', function () {
    return view('client/favorites');
});

Route::get('/na-wymiar', function () {
    return view('custom');
});




Route::get('/przelew', function () {
    return view('przelew');
});




Route::get('/produkty/{category}', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/produkty/{category}/{subcategory}', [App\Http\Controllers\ProductController::class, 'index']);
Route::post('/product/{category}/sort', [App\Http\Controllers\ProductController::class, 'sort']);
Route::post('/product/{category}/{subcategory}/sort', [App\Http\Controllers\ProductController::class, 'sort']);

Route::get('/produkty/{category}/{subcategory}/{productName}', function () {
    return view('details');
});

// Dodanie do koszyka
Route::post('/product/addToCard', [App\Http\Controllers\CardController::class, 'addToCard']);
Route::post('/product/deleteFromCart', [App\Http\Controllers\CardController::class, 'deleteFromCart']);

// Ulubione
Route::post('/product/addToFavorites', [App\Http\Controllers\CardController::class, 'addToFavorites']);
Route::post('/product/deleteFromFavorites', [App\Http\Controllers\CardController::class, 'deleteFromFavorites']);

Route::post('/noLogin', [App\Http\Controllers\CardController::class, 'noLogin']);


Route::get('/koszyk', function () {
    if(Auth::user()){
            return view('client/cartLogin');
    }else{
            return view('client/cart');
    }
});


Route::get('/koszyk/zamówienie', function () {
    if(Auth::user()){
        if(DB::table('cart')->where('user_id', Auth::user()->id)->first()){
            return view('client/orderLogin');
        }else{
            return view('client/cart');
        }
    }else{
        if(session()->get('cart')){
            return view('client/order');
        }else{
            return view('client/cart');
        }
    }
});
Route::post('/summaryCart', [App\Http\Controllers\CardController::class, 'summaryCart']);

Route::get('/koszyk/podsumowanie', function () {
    if(Auth::user()){
        if(DB::table('cart')->where('user_id', Auth::user()->id)->first()){
            return view('client/summary');
        }else{
            return view('client/order');
        }
    }else{
        if(session()->get('cart')){
            return view('client/summary');
        }else{
            return view('client/order');
        }
    }
});
Route::post('/summaryOrder', [App\Http\Controllers\CardController::class, 'summaryOrder']);
Route::post('/summaryOrderFaktura', [App\Http\Controllers\CardController::class, 'summaryOrderFaktura']);

Route::post('/summary/buy', [App\Http\Controllers\CardController::class, 'buy']);

Route::get('/szafa przesuwna', function () {
    return view('design/szafa_przesuwna');
});

/*

Stopka

*/

Route::get('/regulamin', function () {
    return view('footer/regulations');
});

Route::get('/reklacje_i_zwroty', function () {
    return view('footer/complaints');
});

/*

Klient

*/

Route::get('/rejestracja', [App\Http\Controllers\Client\RegisterController::class, 'showRegisterForm'])->name('client/register');
Route::post('/rejestracja', [App\Http\Controllers\Client\RegisterController::class, 'register'])->name('client/register/submit');
Route::get('/logowanie', [App\Http\Controllers\Client\LoginController::class, 'showLoginForm'])->name('client/login');
Route::post('/logowanie', [App\Http\Controllers\Client\LoginController::class, 'login'])->name('client/login/submit');
Route::get('/odzyskanie_hasła', function (){
    return view('auth/passwords/email');
})->name('client/getPassword');
Route::post('/odzyskanie_hasła', [App\Http\Controllers\Client\ResetPasswordController::class, 'reset']);

Route::prefix('moje_konto')->group(function() {
    Route::post('/dodaj_imie', [App\Http\Controllers\Client\InformationController::class, 'addName'])->name('client/addName');
    Route::post('/usun_imie', [App\Http\Controllers\Client\InformationController::class, 'deleteName'])->name('client/deleteName');
    Route::post('/dodaj_nazwisko', [App\Http\Controllers\Client\InformationController::class, 'addSurname'])->name('client/addSurname');
    Route::post('/usun_nazwisko', [App\Http\Controllers\Client\InformationController::class, 'deleteSurname'])->name('client/deleteSurname');
    Route::post('/dodaj_numer', [App\Http\Controllers\Client\InformationController::class, 'addPhone'])->name('client/addPhone');
    Route::post('/usun_numer', [App\Http\Controllers\Client\InformationController::class, 'deletePhone'])->name('client/deletePhone');
    Route::post('/dodaj_ulice', [App\Http\Controllers\Client\InformationController::class, 'addStreet'])->name('client/addStreet');
    Route::post('/usun_ulice', [App\Http\Controllers\Client\InformationController::class, 'deleteStreet'])->name('client/deleteStreet');
    Route::post('/dodaj_numer_lokalu', [App\Http\Controllers\Client\InformationController::class, 'addLocalNumber'])->name('client/addLocalNumber');
    Route::post('/usun_numer_lokalu', [App\Http\Controllers\Client\InformationController::class, 'deleteLocalNumber'])->name('client/deleteLocalNumber');
    Route::post('/dodaj_zip', [App\Http\Controllers\Client\InformationController::class, 'addZip'])->name('client/addZip');
    Route::post('/usun_zip', [App\Http\Controllers\Client\InformationController::class, 'deleteZip'])->name('client/deleteZip');
    Route::post('/dodaj_city', [App\Http\Controllers\Client\InformationController::class, 'addCity'])->name('client/addCity');
    Route::post('/usun_city', [App\Http\Controllers\Client\InformationController::class, 'deleteCity'])->name('client/deleteCity');
    Route::post('/zmien_haslo', [App\Http\Controllers\Client\InformationController::class, 'changePassword'])->name('client/changePassword');
    Route::post('/usun_konto', [App\Http\Controllers\Client\InformationController::class, 'deleteAccount'])->name('client/deleteAccount');
    Route::post('/dodaj_opinie', [App\Http\Controllers\Client\InformationController::class, 'addOpinion'])->name('client/addOpinion');
    Route::post('/usun_komentarz', [App\Http\Controllers\Client\InformationController::class, 'deleteOpinion'])->name('client/deleteOpinion');

    Route::get('/zarzadzanie', function () {
        return view('client/main');
    })->middleware('auth');
    Route::get('/ustawienia', function () {
        return view('client/settings');
    })->middleware('auth');
    Route::get('/historia_zakupow', function () {
        return view('client/history');
    })->middleware('auth');
});


/*************

ADMIN

*************/

Route::prefix('admin')->group(function() {
    Route::get('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'showLoginForm'])->name('admin/login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminLoginController::class, 'login'])->name('admin/login/submit');
    //Route::get('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'showRegisterForm'])->name('admin/register');
    //Route::post('/register', [App\Http\Controllers\Admin\AdminRegisterController::class, 'register'])->name('admin/register/submit');
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/realizacje', function() {
        return view('admin/implementations');
    })->middleware('auth:admin');
    Route::get('/zarzadzanie', function() {
        return view('admin/main');
    })->middleware('auth:admin');
    Route::get('/strona_glowna', function() {
        return view('admin/index');
    })->middleware('auth:admin');
    Route::get('/opinie', function() {
        return view('admin/opinions');
    })->middleware('auth:admin');
    Route::get('/zamowienia', function() {
        return view('admin/orders');
    })->middleware('auth:admin');

    //Route::post('/zamowienia', [App\Http\Controllers\Admin\OrdersController::class, 'index']);
    Route::post('/zamowienia/sort', [App\Http\Controllers\Admin\OrdersController::class, 'sort']);
    Route::post('/zamowienia/realizacja', [App\Http\Controllers\Admin\OrdersController::class, 'realizacja']);
    
    Route::post('/realizacje/delete', [App\Http\Controllers\AdminController::class, 'delete']);
    Route::post('/realizacje/add', [App\Http\Controllers\AdminController::class, 'add']);
    Route::post('/dodaj_komentarz', [App\Http\Controllers\Admin\OpinionsController::class, 'addComment'])->name('admin/addComment');
    Route::post('/usun_komentarz', [App\Http\Controllers\Admin\OpinionsController::class, 'deleteComment'])->name('admin/deleteComment');

    Route::post('/newCategory', [App\Http\Controllers\Admin\MenuController::class, 'newCategory'])->name('admin/newCategory');
    Route::post('/deleteCategory', [App\Http\Controllers\Admin\MenuController::class, 'deleteCategory'])->name('admin/deleteCategory');
    
    Route::post('/product/delete', [App\Http\Controllers\Admin\ProductController::class, 'deleteProduct'])->name('admin/product/delete');
    Route::post('/product/manage', [App\Http\Controllers\Admin\ProductController::class, 'productManage'])->name('admin/product/manage');
    Route::post('/product/add', [App\Http\Controllers\Admin\ProductController::class, 'productAdd'])->name('admin/product/add');
    Route::post('/product/restore', [App\Http\Controllers\Admin\ProductController::class, 'restore'])->name('admin/product/restore');
    
    Route::post('/addBaner', [App\Http\Controllers\AdminController::class, 'addBaner'])->name('admin/addBaner');
    Route::post('/deleteBaner', [App\Http\Controllers\AdminController::class, 'deleteBaner'])->name('admin/deleteBaner');
    
    Route::get('/produkty/{category}', function (Request $request) {
        return view('admin/products', ['category' => $request->path()]);
    })->middleware('auth:admin');
    
    Route::get('/produkty/{category}/{subcategory}', function () {
        return view('admin/products');
    })->middleware('auth:admin');
    
    Route::get('/produkty/{category}/{subcategory}/{productName}', function () {
        return view('admin/details');
    })->middleware('auth:admin');

    Route::get('/dodaj_produkt/{category}/{subcategory}/formularz', function () {
        return view('admin/addProduct');
    })->middleware('auth:admin');
    Route::get('/dodaj_produkt/{category}/formularz', function () {
        return view('admin/addProduct');
    })->middleware('auth:admin');
});




