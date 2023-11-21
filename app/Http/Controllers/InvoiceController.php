<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getInvoice($id)
    {
        $event = DB::table('eventinfos')->get();

        $invoices =  DB::table('invoices')->where('invoices.id', '=', $id)->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->select(
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

        $invoices =  DB::table('invoices')->where('invoices.invoice_number', '!=', 'null')->leftJoin('packages', 'invoices.category', '=', 'packages.id')->leftJoin('users', 'invoices.user_id', '=', 'users.id')->leftJoin('locations', 'invoices.location', '=', 'locations.id')->orderBy('invoices.invoice_number', 'asc')->where('invoices.company_name', 'like', '%' . $search . '%')->orWhere('invoices.invoice_number', 'like', '%' . $search . '%')->select(
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

        if($request->file('contract_file')){
            $request->file('contract_file')->move('public/contracts/', time() . '_' .'contract'. '_' . $request->file('contract_file')->getClientOriginalName());
            $_request['contract_file'] = 'public/contracts/'. time() . '_' .'contract'. '_' . $request->file('contract_file')->getClientOriginalName();
        }

        if($request->file('voucher')){
            $request->file('voucher')->move('public/vouchers/', time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/'. time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName();
        }

        $_request["invoice_number"] = $eventInfo[0]->invoice_pre . str_pad($eventInfo[0]->invoice_number, 3, '0', STR_PAD_LEFT);

        DB::table('eventinfos')->update(array('invoice_number' => ($eventInfo[0]->invoice_number + 1)));
        return DB::table('invoices')->insert($_request);
    }

    public function putInvoices($id, Request $request)
    {
        $_request = $request->all();
        $eventInfo = DB::table('eventinfos')->get();
        $price = 0;
        $country = '';
        $iva = 0;

        $request->subtotal ? $price = $request->subtotal : $price =  floatval(DB::table('invoices')->where('id', $id)->get('subtotal')[0]->subtotal);
        $request->country ? $country = $request->country : $country =  DB::table('invoices')->where('id', $id)->get('country')[0]->country;

        if ($country === "Spain") {
            $iva =  (((float)$price * (int)$eventInfo[0]->iva) / 100);
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price + $iva;
        } else {
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price;
        }

        if($request->hasFile('contract_file')){
            $request->file('contract_file')->move('public/contracts/', time() . '_' .'contract'. '_' . $request->file('contract_file')->getClientOriginalName());
            $_request['contract_file'] = 'public/contracts/'. time() . '_' .'contract'. '_' . $request->file('contract_file')->getClientOriginalName();
        }

        if($request->hasFile('voucher')){
            $request->file('voucher')->move('public/vouchers/', time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/'. time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName();
        }     
        
        return DB::table('invoices')->where('id', $id)->update($_request);
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

        $request->subtotal ? $price = $request->subtotal : $price =  floatval(DB::table('invoices')->where('id', $id)->get('subtotal')[0]->subtotal);
        $request->country ? $country = $request->country : $country =  DB::table('invoices')->where('id', $id)->get('country')[0]->country;

        if ($country === "Spain") {
            $iva =  (((float)$price * (int)$eventInfo[0]->iva) / 100);
            $_request['iva'] = $iva;
            $_request['total'] = (float)$price + $iva;
        } else {
            $_request['total'] = (float)$price;
        }

        if($request->hasFile('voucher')){
            $request->file('voucher')->move('public/vouchers/', time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName());
            $_request['voucher'] = 'public/vouchers/'. time() . '_' .'voucher'. '_' . $request->file('voucher')->getClientOriginalName();
        }    

        return DB::table('invoices')->where('id', $id)->update($_request);
    }
}