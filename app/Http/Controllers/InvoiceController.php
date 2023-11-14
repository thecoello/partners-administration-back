<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function getInvoices()
    {   
        
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number','!=','null')->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->select(
            "invoices.id","invoices.user_id","pricetype","company_name","category","location","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file","coupons")->orderBy('invoices.invoice_number','asc')->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }

    }

    public function getInvoice($id)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.id','=',$id)->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->select("invoices.id","invoices.user_id",
        "pricetype","company_name","category","location","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file","coupons")->orderBy('invoices.invoice_number','asc')->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }
        
    }

    public function getInvoicesSearch($search)
    {      

        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number','!=','null')->leftJoin('packages','invoices.category','=','packages.id')->leftJoin('users','invoices.user_id','=','users.id')->leftJoin('locations','invoices.location','=','locations.id')->orderBy('invoices.invoice_number','asc')->where('invoices.company_name','like','%'.$search.'%')->orWhere('invoices.invoice_number','like','%'.$search.'%')->select("invoices.id","invoices.user_id",
        "pricetype","company_name","pack_name","location_name","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number","payment_status","payment_method","invoice_date","name","contact","email","contract_file","coupons")->simplePaginate(15);

        if($event && $invoices){
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        }else{
            return response()->json("Error obteniendo invoices");
        }

    }

    public function postInvoice(Request $request)
    {

        $eventInfo = DB::table('eventinfos')->get();

        $this->validate($request, [
            "user_id" => "required",
            "category" => "required",
            "location" => "required",
            "pricetype" => "required",
            "subtotal" => "required",
            "contract_file" => "required"
        ]);

        $request->file('contract_file')->move('public/contracts/', time() . "_" . $request->name . '_' . 'contract' . '.pdf');

        $iva = 0;
        $total = 0;

        if($request->country === "Spain"){
            $iva = (((float)$request->subtotal * (int)$eventInfo[0]->iva)/100);
            $total = (float)$request->subtotal + $iva;
        }else{
            $total = (float)$request->subtotal;  
        }

        $invoiceRequest = [
            "user_id" => $request->user_id,
            "category" => $request->category,
            "location" => $request->location,
            "pricetype" => $request->pricetype,
            "subtotal" => $request->subtotal,
            "iva" => $iva,
            "total" => $total,       
            "invoice_number" => $eventInfo[0]->invoice_pre . str_pad( $eventInfo[0]->invoice_number,3,'0',STR_PAD_LEFT),
            "contract_file" => 'public/contracts/' . time() . "_" . $request->name . '_' . 'contract' . '.pdf',
            "company_name" => $request->company_name,
            "address" => $request->address,
            "zip" => $request->zip,
            "country" => $request->country,
            "vat" => $request->vat,
            "payment_method" => $request->payment_method,
            "payment_status" => $request->payment_status
        ];

        DB::table('eventinfos')->update(array('invoice_number'=>($eventInfo[0]->invoice_number + 1)));

        $result = DB::table('invoices')->insert($invoiceRequest);
        return $result;
    }

    public function putInvoices($id, Request $request)
    {
        $iva = 0;
        $total = 0;
        $invoiceRequest = [];

        $eventInfo = DB::table('eventinfos')->get();

        if($request->country === "Spain"){
            $iva = (((float)$request->subtotal * (int)$eventInfo[0]->iva)/100);
            $total = (float)$request->subtotal + $iva;
        }else{
            $total = (float)$request->subtotal;  
        }
        
        if( $request->file('contract_file')){
            $request->file('contract_file')->move('public/contracts/', time() . "_" . $request->name . '_' . 'contract' . '.pdf');
            $invoiceRequest = [
                "user_id" => $request->user_id,
                "category" => $request->category,
                "location" => $request->location,
                "pricetype" => $request->pricetype,
                "subtotal" => $request->subtotal,
                "iva" => $iva,
                "total" => $total,       
                "company_name" => $request->company_name,
                "address" => $request->address,
                "zip" => $request->zip,
                "country" => $request->country,
                "vat" => $request->vat,
                "contract_file" => 'public/contracts/' . time() . "_" . $request->name . '_' . 'contract' . '.pdf',
                "coupons" => $request->coupons,
                "payment_method" => $request->payment_method,
                "payment_status" => $request->payment_status

            ];
        }else{
            $invoiceRequest = [
                "user_id" => $request->user_id,
                "category" => $request->category,
                "location" => $request->location,
                "pricetype" => $request->pricetype,
                "subtotal" => $request->subtotal,
                "iva" => $iva,
                "total" => $total,       
                "company_name" => $request->company_name,
                "address" => $request->address,
                "zip" => $request->zip,
                "country" => $request->country,
                "vat" => $request->vat,
                "coupons" => $request->coupons,
                "payment_method" => $request->payment_method,
                "payment_status" => $request->payment_status                
            ];
        }
        return DB::table('invoices')->where('id', $id)->update($invoiceRequest);
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
