<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationsController extends Controller
{
    public function getLocations()
    {
        return DB::table('locations')->get();
    }

    public function updateLocations($id, Request $request)
    {
        $locationsUpdate = DB::table('locations')->where('id', $id)->update($request->all());
        $allLocations = [];
        $location1 = DB::table('locations')->where('id',1)->get()[0]->location_name;
        $location2 = DB::table('locations')->where('id',2)->get()[0]->location_name;
        $location3 = DB::table('locations')->where('id',3)->get()[0]->location_name;
        $allLocations["location_name"] = $location1 . '+' . $location2 . '+' . $location3;
        $allLocationsUpdate = DB::table('locations')->where('id', 4)->update($allLocations);

        if($locationsUpdate && $allLocationsUpdate){
            return $allLocationsUpdate;
        }
         
    }

}
