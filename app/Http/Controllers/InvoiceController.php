<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Invoices;

class InvoiceController extends Controller
{
    public function showAllInvoices(Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            return response()->json(Invoices::all());
        }
        return response('Unauthorized.', 401);
    }

    public function showInvoice($user_id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $invoice = Invoices::where('user_id', $user_id)->first();
            return response()->json($invoice);
        }
        return response('Unauthorized.', 401);
    }

    public function createInvoice(Request $request)
    {

        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $this->validate($request, [
                "user_id" => "required|unique:Invoices",
            ]);

            $Invoice = Invoices::create($request->all());
            return response()->json($Invoice, 201);
        }
        return response('Unauthorized.', 401);
    }

    public function updateInvoice($user_id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $Invoice = Invoices::where('user_id', $user_id)->first();

            $Invoice->update($request->all());
            return response()->json($Invoice, 200);
        }
        return response('Unauthorized.', 401);
    }

    public function updateInvoiceDetails($user_id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $Invoice = Invoices::where('user_id', $user_id)->first();

            $Invoice->update($request->all());
            return response()->json($Invoice, 200);
        }
        return response('Unauthorized.', 401);
    }

    public function updatePaymentStatus($user_id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $Invoice = Invoices::where('user_id', $user_id)->first();

            $Invoice->update($request->all());
            return response()->json($Invoice, 200);
        }
        return response('Unauthorized.', 401);
    }

    public function deteleInvoice($user_id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            Invoices::where('user_id', $user_id)->first()->delete();
            return response('Deleted Successfully', 200);
        }
        return response('Unauthorized.', 401);
    }
}
