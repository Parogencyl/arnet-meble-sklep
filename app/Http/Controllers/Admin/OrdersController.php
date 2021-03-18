<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')) {
            $orders = DB::table('order')->orderBy('id', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
            return view('/admin/orders', ['orders' => $orders, 'way' => NULL]);
        }
    }
    
    public function sort(Request $request){

        
        switch($request->input('typeSort')){
            case 'lp':
                if ($request->input('way') == 'up') {
                    $orders = DB::table('order')->orderBy('id', 'ASC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                    $orders->setPath('/admin/zamowienia');
                    return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'idUp');
                }else{
                    $orders = DB::table('order')->orderBy('id', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                    $orders->setPath('/admin/zamowienia');
                    return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'idDown');
                }
                break;
                
                case 'date':
                    if ($request->input('way') == 'up') {
                        $orders = DB::table('order')->orderBy('created_at', 'ASC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                        return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'dateUp');
                    }else{
                        $orders = DB::table('order')->orderBy('created_at', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                        $orders->setPath('/admin/zamowienia');
                        return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'dateDown');
                    }
                    break;
                    
                    case 'status':
                        if ($request->input('way') == 'up') {
                            $orders = DB::table('order')->orderBy('realizacja', 'ASC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                            $orders->setPath('/admin/zamowienia');
                            return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'statusUp');
                        }else{
                            $orders = DB::table('order')->orderBy('realizacja', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                            $orders->setPath('/admin/zamowienia');
                            return redirect('/admin/zamowienia')->with('ordersSort', $orders)->with('way', 'statusDown');
                        }
                        break;
                        
                        $orders = DB::table('order')->orderBy('id', 'ASC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
                        $orders->setPath('/admin/zamowienia');
                    return view('/admin/orders', ['orders' => $orders, 'way' => NULL]);
                }
            }

    public function realizacja(Request $request){
        $orders = DB::table('order')->orderBy('id', 'DESC')->leftJoin('faktura', 'order.faktura_id', '=', 'faktura.id')->select('order.*', 'faktura.company', 'faktura.nip', 'faktura.street as fakturaStreet', 'faktura.zip as fakturaZip' , 'faktura.local_number as fakturaLocal' , 'faktura.city as fakturaCity')->paginate(5);
        DB::table('order')->where('id', $request->input('id'))->update(['realizacja' => $request->input('realizacja')]);
        return view('/admin/orders', ['orders' => $orders, 'way' => NULL]);
    }

}
