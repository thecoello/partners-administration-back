<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EventInfo;
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

}
