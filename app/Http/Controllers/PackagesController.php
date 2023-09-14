<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Packages;
use Illuminate\Support\Facades\DB;

class PackagesController extends Controller
{
    public function getPackages()
    {
        $result = DB::table('packages')->select('*')->get();
        return $result;
    }

    public function postPackages(Request $request)
    {
        $this->validate($request, [
            "pack_name" => "required",
            "price_normal" => "required",
            "price_early" => "required",
            "price_all_normal" => "required",
            "price_all_early" => "required",
        ]);

        $result = DB::table('packages')->insert($request->all());
        return $result;
    }

    public function updatePackages($id, Request $request)
    {
        $result = DB::table('packages')->where('id', $id)->update(request()->all());
        return $result;
    }

    public function deletePackages($id)
    {
        $result = DB::table('packages')->delete($id);
        return $result;
    }
}
