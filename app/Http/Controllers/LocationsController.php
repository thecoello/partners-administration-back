<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationsController extends Controller
{
    public function getLocations()
    {
        $result = DB::table('locations')->select('*')->get();
        return $result;
    }

    public function postLocations(Request $request)
    {
        $this->validate($request, [
            "location_name" => "required",
        ]);

        $result = DB::table('locations')->insert($request->all());
        return $result;
    }

    public function updateLocations($id, Request $request)
    {
        $result = DB::table('locations')->where('id', $id)->update(request()->all());
        return $result;
    }

    public function deleteLocations($id)
    {
        $result = DB::table('locations')->delete($id);
        return $result;
    }
}
