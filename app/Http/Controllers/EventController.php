<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventInfo;

class EventController extends Controller
{
    public function showAllEvents()
    {
        return response()->json(EventInfo::all());
    }

  
    public function updateEvent($id, Request $request)
    {
        $Events = EventInfo::all();
       
        $request->offsetSet("invoice_number", $Events[0]->invoice_number+1);

        $Events[0]->update($request->all());
        
        return response()->json($Events, 200); 
    }

}
