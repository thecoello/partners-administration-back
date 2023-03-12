<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Locations;

class LocationsController extends Controller
{
    public function showAllLocations(Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            return response()->json(Locations::all());
        }
        return response('Unauthorized.', 401);
    }

    public function showLocation($id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            return response()->json(Locations::find($id));
        }
        return response('Unauthorized.', 401);
    }

    public function createLocation(Request $request)
    {

        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $this->validate($request, [
                "pack_name" => "required",
                "price_normal" => "required",
                "price_early" => "required",
                "price_all_early" => "required",
                "Location_type" => "required",
            ]);

            $Location = Locations::create($request->all());
            return response()->json($Location, 201);
        }
        return response('Unauthorized.', 401);
    }

    public function updateLocation($id, Request $request)
    {

        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
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
        return response('Unauthorized.', 401);
    }

    public function deteleLocation($id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            Locations::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }
        return response('Unauthorized.', 401);
    }
}
