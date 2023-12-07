<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class StandInformationController extends Controller
{


    public function getStandsInfo()
    {
        $standInformation = DB::table('standsinformation')->leftJoin('invoices','invoices.id', '=', 'standsinformation.invoice_id')->get();
               
        return $standInformation;
  
    }

    public function getStandInfo($id)
    {
        $locations = DB::table('locations')->get();
        $invoice = DB::table('invoices')->where('invoices.id', '=', $id)->get();
        $standInformation = DB::table('standsinformation')->where('standsinformation.invoice_id', '=', $id)->get();

        if ($locations && $invoice) {
            return response()->json(['locations' => $locations, 'invoice' => $invoice, 'standinformation' => $standInformation]);
        } else {
            return response()->json("Error obteniendo invoices");
        }
    }

    public function postStandInfo(Request $request)
    {
        $_request = $request->all();

        if($request->file('logo')){
            $request->file('logo')->move('public/logos/', time() . '_' .'logo'. '_' . $request->file('logo')->getClientOriginalName());
            $_request['logo'] = 'public/logos/'. time() . '_' .'logo'. '_' . $request->file('logo')->getClientOriginalName();
        }

        if($request->file('document1')){
            $request->file('document1')->move('public/documents/', time() . '_' .'document1'. '_' . $request->file('document1')->getClientOriginalName());
            $_request['document1'] = 'public/documents/'. time() . '_' .'document1'. '_' . $request->file('document1')->getClientOriginalName();
            
        }

        if($request->file('document2')){
            $request->file('document2')->move('public/documents/', time() . '_' .'document2'. '_' . $request->file('document2')->getClientOriginalName());
            $_request['document2'] = 'public/documents/'. time() . '_' .'document2'. '_' . $request->file('document2')->getClientOriginalName();

        }

        if($request->file('document3')){
            $request->file('document3')->move('public/documents/', time() . '_' .'document3'. '_' . $request->file('document3')->getClientOriginalName());
            $_request['document3'] = 'public/documents/'. time() . '_' .'document3'. '_' . $request->file('document3')->getClientOriginalName();
        }

        print_r($_request);


        return DB::table('standsinformation')->insert($_request);
    }

    public function putStandInfo($id, Request $request)
    {
        $_request = $request->all();

        if($request->file('logo')){
            $request->file('logo')->move('public/logos/', time() . '_' .'logo'. '_' . $request->file('logo')->getClientOriginalName());
            $_request['logo'] = 'public/logos/'. time() . '_' .'logo'. '_' . $request->file('logo')->getClientOriginalName();
        }

        if($request->file('document1')){
            $request->file('document1')->move('public/documents/', time() . '_' .'document1'. '_' . $request->file('document1')->getClientOriginalName());
            $_request['document1'] = 'public/documents/'. time() . '_' .'document1'. '_' . $request->file('document1')->getClientOriginalName();
        }

        if($request->file('document2')){
            $request->file('document2')->move('public/documents/', time() . '_' .'document2'. '_' . $request->file('document2')->getClientOriginalName());
            $_request['document2'] = 'public/documents/'. time() . '_' .'document2'. '_' . $request->file('document2')->getClientOriginalName();
        }

        if($request->file('document3')){
            $request->file('document3')->move('public/documents/', time() . '_' .'document3'. '_' . $request->file('document3')->getClientOriginalName());
            $_request['document3'] = 'public/documents/'. time() . '_' .'document3'. '_' . $request->file('document3')->getClientOriginalName();
        }

        return DB::table('standsinformation')->where('invoice_id', $id)->update($_request);
    }
}