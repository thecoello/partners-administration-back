<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvoicesExport;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\MailController;

class InvoiceController extends Controller
{

    public function getInvoices()
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number', '!=', 'null')->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->select(
            "invoices.id",
            "invoices.user_id",
            "pricetype",
            "company_name",
            "category",
            "location",
            "quantity",
            "vat",
            "subtotal",
            "iva",
            "total",
            "address",
            "zip",
            "country",
            "invoice_number",
            "payment_status",
            "payment_method",
            "invoice_date",
            "name",
            "contact",
            "email",
            "contract_file",
            "coupons",
            "voucher"
        )->orderBy('invoices.invoice_number', 'asc')->simplePaginate(15);

        if ($event && $invoices) {
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        } else {
            return response()->json("Error obteniendo invoices");
        }
    }


    public function getInvoicesExcel()
    {
        return DB::table('invoices')->get();
    }

    public function getInvoicesByUser($id)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.user_id', 'like', $id)->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->select(
            "invoices.id",
            "invoices.user_id",
            "pricetype",
            "company_name",
            "category",
            "location",
            "quantity",
            "vat",
            "subtotal",
            "iva",
            "total",
            "address",
            "zip",
            "country",
            "invoice_number",
            "payment_status",
            "payment_method",
            "invoice_date",
            "name",
            "contact",
            "email",
            "contract_file",
            "coupons",
            "voucher"
        )->orderBy('invoices.invoice_number', 'asc')->simplePaginate(15);

        if ($event && $invoices) {
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        } else {
            return response()->json("Error obteniendo invoices");
        }
    }

    public function getInvoice($id)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.id', 'like', $id)->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->select(
            "invoices.id",
            "invoices.user_id",
            "pricetype",
            "company_name",
            "category",
            "location",
            "quantity",
            "vat",
            "subtotal",
            "iva",
            "total",
            "address",
            "zip",
            "country",
            "invoice_number",
            "payment_status",
            "payment_method",
            "invoice_date",
            "name",
            "contact",
            "email",
            "contract_file",
            "coupons",
            "voucher"
        )->orderBy('invoices.invoice_number', 'asc')->simplePaginate(15);

        if ($event && $invoices) {
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        } else {
            return response()->json("Error obteniendo invoices");
        }
    }

    public function getInvoicesSearch($search)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.invoice_number', '!=', 'null')->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->orderBy('invoices.invoice_number', 'asc')->where('invoices.company_name', 'like', '%' . $search . '%')->orWhere('invoices.invoice_number', 'like', '%' . $search . '%')->orWhere('contact', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->select(
            "invoices.id",
            "invoices.user_id",
            "pricetype",
            "company_name",
            "pack_name",
            "location_name",
            "quantity",
            "vat",
            "subtotal",
            "iva",
            "total",
            "address",
            "zip",
            "country",
            "invoice_number",
            "payment_status",
            "payment_method",
            "invoice_date",
            "name",
            "contact",
            "email",
            "contract_file",
            "coupons",
            "voucher"
        )->simplePaginate(15);

        if ($event && $invoices) {
            return response()->json(['eventinfo' => $event, 'invoices' => $invoices]);
        } else {
            return response()->json("Error obteniendo invoices");
        }
    }

    public function postInvoice(Request $request)
    {
        $eventInfo = DB::table('eventinfos')->get();
        $user = DB::table('users')->where('id', $request->user_id)->first('*');
        $iva = 0;

        $this->validate($request, [
            "user_id" => "required",
            "category" => "required",
            "location" => "required",
            "pricetype" => "required",
            "subtotal" => "required",
            "contract_file" => "required"
        ]);

        $_request = $request->all();

        if ($request->country === "Spain") {
            $iva =  (((float)$request->subtotal * (int)$eventInfo[0]->iva) / 100);
            $_request['iva'] = $iva;
            $_request['total'] = (float)$request->subtotal + $iva;
        } else {
            $_request['total'] = (float)$request->subtotal;
        }

        if ($request->file('contract_file')) {
            $request->file('contract_file')->move('public/contracts/', time() . '_' . 'contract' . '_' . $request->file('contract_file')->getClientOriginalName());
            $_request['contract_file'] = 'public/contracts/' . time() . '_' . 'contract' . '_' . $request->file('contract_file')->getClientOriginalName();
        }

        if ($request->file('voucher')) {
            $request->file('voucher')->move('public/vouchers/', time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/' . time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName();
        }

        $_request["invoice_number"] = $eventInfo[0]->invoice_pre . str_pad($eventInfo[0]->invoice_number, 3, '0', STR_PAD_LEFT);

        DB::table('eventinfos')->update(array('invoice_number' => ($eventInfo[0]->invoice_number + 1)));

        $createInvoice = DB::table('invoices')->insert($_request);
        $mail = new MailController();

        if ($createInvoice) {
            $mail->invoiceAvailable($_request["invoice_number"], $user);
            return $createInvoice;
        }
    }

    public function putInvoices($id, Request $request)
    {
        $_request = $request->all();
        $eventInfo = DB::table('eventinfos')->get();
        $price = 0;
        $country = '';
        $iva = 0;
        $invoice = DB::table('invoices')->where('id', $id)->get()->all()[0];
        $user = DB::table('users')->where('id', $invoice->user_id)->get()->all()[0];
        $mail = new MailController();


        $request->subtotal ? $price = $request->subtotal : $price =  floatval($invoice->subtotal);
        $request->country ? $country = $request->country : $country =  $invoice->country;

        if ($country === "Spain") {
            $iva =  (((float)$price * (int)$eventInfo[0]->iva) / 100);
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price + $iva;
        } else {
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price;
        }

        if ($request->hasFile('contract_file')) {
            $request->file('contract_file')->move('public/contracts/', time() . '_' . 'contract' . '_' . $request->file('contract_file')->getClientOriginalName());
            $_request['contract_file'] = 'public/contracts/' . time() . '_' . 'contract' . '_' . $request->file('contract_file')->getClientOriginalName();
        }

        if ($request->hasFile('voucher')) {
            $request->file('voucher')->move('public/vouchers/', time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/' . time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName();
        }

        $invoiceUpdated = DB::table('invoices')->where('id', $id)->update($_request);

        if ($request->payment_status == "Payed" && $invoice->payment_status != "Payed") {
            $mail->invoicePayed($invoice->invoice_number, $user);
        }

        if ($invoiceUpdated && $request->hasFile('voucher')) {
            $mail->proofOfPayment($invoice, $user);
            return $invoiceUpdated;
        }

        return $invoiceUpdated;
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

        $_request = $request->all();
        $eventInfo = DB::table('eventinfos')->get();
        $price = 0;
        $country = '';
        $iva = 0;
        $invoice = DB::table('invoices')->where('id', $id)->get()->all()[0];
        $user = DB::table('users')->where('id', $invoice->user_id)->get()->all()[0];
        $mail = new MailController();

        $request->subtotal ? $price = $request->subtotal : $price =  floatval($invoice->subtotal);
        $request->country ? $country = $request->country : $country =  $invoice->country;

        if ($country === "Spain") {
            $iva =  (((float)$price * (int)$eventInfo[0]->iva) / 100);
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price + $iva;
        } else {
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price;
        }

        if ($request->hasFile('voucher')) {
            $request->file('voucher')->move('public/vouchers/', time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/' . time() . '_' . 'voucher' . '_' . $request->file('voucher')->getClientOriginalName();
        }

        $invoiceUpdated = DB::table('invoices')->where('id', $id)->update($_request);

        if ($request->payment_status == "Payed" && $invoice->payment_status != "Payed") {
            $mail->invoicePayed($invoice->invoice_number, $user);
        }

        if ($invoiceUpdated && $request->hasFile('voucher')) {
            $mail->proofOfPayment($invoice, $user);
            return $invoiceUpdated;
        }

        return $invoiceUpdated;
    }
}
