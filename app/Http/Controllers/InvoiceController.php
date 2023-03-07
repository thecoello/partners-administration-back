<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function showAllInvoices()
    {
        return response()->json(Invoice::all());
    }

    public function showInvoice($id)
    {
        return response()->json(Invoice::find($id));
    }

    public function createInvoice(Request $request)
    {

        $this->validate($request, [
            "invoice_number" => "required|unique:Invoice",
        ]);


        $Invoice = Invoice::create($request->all());
        return response()->json($Invoice, 201);
    }

    public function updateInvoice($id, Request $request)
    {
        $Invoice = Invoice::findOrFail($id);

        $Invoice->update($request->all());
        return response()->json($Invoice, 200);
    }

    public function deteleInvoice($id)
    {
        Invoice::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
