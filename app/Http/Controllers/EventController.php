<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function showAllEvents(Request $request)
    {   
        return DB::table('eventinfos')->get();
    }

  
    public function updateEvent(Request $request)
    {
        return DB::table('eventinfos')->update($request->all());
    }

    public function resetEvent(Request $request)
    {
        if(Auth::user()->id ==  $request->id){
            if(Auth::user()->user_type == 1 ){
                $invoices = DB::table('invoices')->truncate();
                $standinfo = DB::table('standsinformation')->truncate();
                return DB::table('eventinfos')->update(array('invoice_number' => 1));

                if($invoices && $standinfo){

                    return response()->json("ok", 200);
                }
            }
        }else{
            return response()->json("Error", 400);
        }
        
    }

}
