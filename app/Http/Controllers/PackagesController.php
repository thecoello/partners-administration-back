<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Packages;
use Illuminate\Support\Facades\DB;

class PackagesController extends Controller
{
    public function getPackages()
    {
        
        $packs = DB::table('packages')->select('*')->get();
        $locations = DB::table('locations')->select('*')->get();

        return['packinfo'=>$packs, 'locations'=>$locations];
    }

    public function updatePackages($id, Request $request)
    {
        return DB::table('packages')->where('id', $id)->update($request->all());
    }

  
}
