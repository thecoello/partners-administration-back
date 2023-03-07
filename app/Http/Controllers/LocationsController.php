<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Locations;

class LocationsController extends Controller
{
    public function showAllLocations(){
        return response()->json(Locations::all());
    }

    public function showLocation($id){
        return response()->json(Locations::find($id));
    }

    public function createLocation(Request $request){

        $this->validate($request, [
            "pack_name" => "required",
            "price_normal" => "required",
            "price_early" => "required",
            "price_all_early" => "required",
            "Location_type" => "required",
        ]);

        $Location = Locations::create($request->all());
        return response()->json($Location,201);
    }

    public function updateLocation($id, Request $request)
    {
        $Location = Locations::findOrFail($id);

        $this->validate($request, [
            "pack_name" => "required",
            "price_normal" => "required",
            "price_early" => "required",
            "price_all_early" => "required",
            "Location_type" => "required",
        ]);


        $Location->update($request->all());
        return response()->json($Location, 200);
    }

    public function deteleLocation($id)
    {
        Locations::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
