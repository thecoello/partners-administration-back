<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Packages;

class PackagesController extends Controller
{
    public function showAllPackages(Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
        return response()->json(Packages::all());
        }
        return response('Unauthorized.', 401);
    }

    public function showPackage($id, Request $request)
    {

        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            return response()->json(Packages::find($id));
        }
        return response('Unauthorized.', 401);
    }

    public function createPackage(Request $request)
    {

        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {

            $this->validate($request, [
                "pack_name" => "required",
                "price_normal" => "required",
                "price_early" => "required",
                "price_all_early" => "required",
                "Package_type" => "required",
            ]);

            $Package = Packages::create($request->all());
            return response()->json($Package, 201);
        }
        return response('Unauthorized.', 401);
    }

    public function updatePackage($id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            $Package = Packages::findOrFail($id);

            $this->validate($request, [
                "pack_name" => "required",
                "price_normal" => "required",
                "price_early" => "required",
                "price_all_early" => "required",
                "Package_type" => "required",
            ]);

            $Package->update($request->all());
            return response()->json($Package, 200);
        }
        return response('Unauthorized.', 401);
    }

    public function detelePackage($id, Request $request)
    {
        $cookie = $request->cookie('lumen_session');
        $session = $request->session($cookie);
        if ($session->get('key')) {
            Packages::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }
        return response('Unauthorized.', 401);
    }
}
