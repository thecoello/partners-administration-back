<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Packages;

class PackagesController extends Controller
{
    public function showAllPackages(){
        return response()->json(Packages::all());
    }

    public function showPackage($id){
        return response()->json(Packages::find($id));
    }

    public function createPackage(Request $request){

        $this->validate($request, [
            "pack_name" => "required",
            "price_normal" => "required",
            "price_early" => "required",
            "price_all_early" => "required",
            "Package_type" => "required",
        ]);

        $Package = Packages::create($request->all());
        return response()->json($Package,201);
    }

    public function updatePackage($id, Request $request)
    {
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

    public function detelePackage($id)
    {
        Packages::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
