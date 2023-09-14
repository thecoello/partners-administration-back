<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoices;
use App\Models\Users;
use App\Models\Locations;
use App\Models\Packages;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class UsersController extends Controller
{
    public function getUsers()
    {
        $result = DB::table('users')->select('id','name','contact','email','contract_file','user_type')->get();
        return $result;
    }

    public function getUser($id)
    {
        $result = DB::table('users')->select('id','name','contact','email','contract_file','user_type')->where('id', $id)->get();
        return  $result;
    }

    public function postUser(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "contract_file" => "required|mimes:pdf",
            "user_type" => "required",
        ]);

        $request->file('contract_file')->move('public/contracts/', time() . "_" . $request->name . '_' . 'contract' . '.pdf');

        $userRequest = [
            "name" => $request->name,
            "contact" => $request->contact,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "contract_file" => 'public/contracts/' . time() . "_" . $request->name . '_' . 'contract' . '.pdf',
            "user_type" => $request->user_type,
        ];

        $result = DB::table('users')->insert($userRequest);
        return $result;
    }

    public function updateUser($id, Request $request)
    {
        $request['password'] = Hash::make($request->password);
        $result = DB::table('users')->where('id', $id)->update(request()->all());
        return $result;
    }

    public function deteleUser($id)
    {
        $result = DB::table('users')->delete($id);
        return $result;
    }
}