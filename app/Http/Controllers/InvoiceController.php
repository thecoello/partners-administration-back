<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getInvoices()
    {
        $result = DB::select('SELECT invoices.*, users.name, users.contact, users.email, users.contract_file FROM invoices LEFT JOIN users ON invoices.user_id = users.id');
        return $result;
    }

    public function getInvoice($id)
    {
        $result = DB::select('SELECT invoices.*, users.name, users.contact, users.email, users.contract_file FROM invoices LEFT JOIN users ON invoices.user_id = users.id WHERE invoices.id = ' . $id . '');
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
