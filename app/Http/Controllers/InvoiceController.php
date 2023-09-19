<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoices()
    {
        $result = DB::table('invoices')->leftJoin('users','invoices.user_id','=','users.id')->select()->where('invoice_number','!=','null')->orderBy('invoices.invoice_number','asc')->simplePaginate(15);

        return $result;
    }

    public function getInvoice($id)
    {
        $result = DB::table('invoices')->leftJoin('users','invoices.user_id','=','users.id')->where('invoices.id','=',$id)->where('invoice_number','!=','null');

        return $result;
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
