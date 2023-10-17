<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class InvoiceController extends Controller
{

    public function getInvoices()
    {   
        
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number','!=','null')->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->select(
        "pricetype","company_name","pack_name","location_name","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file")->orderBy('invoices.invoice_number','asc')->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }

    }

    public function getInvoice($id)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.id','=',$id)->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->select(
        "pricetype","company_name","pack_name","location_name","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file")->orderBy('invoices.invoice_number','asc')->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }
        
    }

    public function getInvoicesSearch($search)
    {      

        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number','!=','null')->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->orderBy('invoices.invoice_number','asc')->where('invoices.company_name','like','%'.$search.'%')->orWhere('invoices.invoice_number','like','%'.$search.'%')->select(
        "pricetype","company_name","pack_name","location_name","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file")->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }

    }

    public function postInvoice(Request $request)
    {

        $this->validate($request, [
            "user_id" => "required",
            "category" => "required",
            "location" => "required",
            "pricetype" => "required",
            "subtotal" => "required",
            "invoice_number" => "required",
        ]);

        $request->file('contract_file')->move('public/contracts/', time() . "_" . $request->name . '_' . 'contract' . '.pdf');


        $eventInfo = DB::table('eventinfos')->get('eventinfos.invoice_number');

        $invoiceRequest = [
            "user_id" => $request->user_id,
            "category" => $request->category,
            "location" => $request->location,
            "pricetype" => $request->pricetype,
            "subtotal" => $request->subtotal,
            "invoice_number" => $eventInfo->invoice_number
        ];


        DB::table('eventinfos')->update(array('invoice_number'=>($eventInfo->invoice_number + 1)));


        $result = DB::table('invoices')->insert($request->all());
        return $result;
    }

    public function putInvoices($id, Request $request)
    {
        $result = DB::table('invoices')->where('id', $id)->update(request()->all());
        return $result;
    }

    public function putInvoicesUser($id, Request $request)
    {
        $this->validate($request, [
            "company_name" => "required",
            "address" => "required",
            "zip" => "required",
            "country" => "required",
            "vat" => "required",              
        ]);

        $result = DB::table('invoices')->where('id', $id)->update(request()->all());
        return $result;
    }
}
