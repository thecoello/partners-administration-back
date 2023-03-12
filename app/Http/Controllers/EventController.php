<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventInfo;

class EventController extends Controller
{
    public function showAllEvents(Request $request)
    {
        $cookie = $request->cookie('lumen_session');        
        $session = $request->session($cookie);

        if($session->get('key')){
            return response()->json(EventInfo::all());
        }
        return response('Unauthorized.', 401);

    }

  
    public function updateEvent($id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');        
        $session = $request->session($cookie);

        if($session->get('key')){
            $Events = EventInfo::all();
            $request->offsetSet("invoice_number", $Events[0]->invoice_number+1);
            $Events[0]->update($request->all());
            return response()->json($Events, 200); 
        }
        return response('Unauthorized.', 401);

    }

}
