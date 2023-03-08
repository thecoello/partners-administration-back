<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Invoices;

class InvoiceController extends Controller
{
    public function showAllInvoices()
    {
        return response()->json(Invoices::all());
    }

    public function showInvoice($user_id)
    {
        $invoice = Invoices::where('user_id', $user_id)->first();

        return response()->json($invoice);
    }

    public function createInvoice(Request $request)
    {

        $this->validate($request, [
            "user_id" => "required|unique:Invoices",
        ]);


        $Invoice = Invoices::create($request->all());
        return response()->json($Invoice, 201);
    }

    public function updateInvoice($id, Request $request)
    {
        $Invoice = Invoices::findOrFail($id);

        $this->validate($request, [
            "user_id" => "required|unique:Invoice",
        ]);

        $Invoice->update($request->all());
        return response()->json($Invoice, 200);
    }

    public function deteleInvoice($id)
    {
        Invoices::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
