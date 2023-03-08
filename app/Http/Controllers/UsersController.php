<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


use App\Models\Users;

class UsersController extends Controller
{
    public function showAllUsers(){
        return response()->json(Users::all());
    }

    public function showUser($id){
        return response()->json(Users::find($id));
    }

    public function createUser(Request $request){

        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "contract_file" => "required|mimes:pdf",
            "user_type" => "required",
        ]);

        $request->file('contract_file')->move('public/contracts/', time() ."_".$request->name .'_'.'contract'.'.pdf');

        $userRequest = [
            "name" => $request->name,
            "contact" => $request->contact,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "contract_file" => 'public/contracts/'. time() ."_".$request->name .'_'.'contract'.'.pdf',
            "user_type" => $request->user_type,
        ];
        
        
        $user = Users::create($userRequest);
        return response()->json($user,201); 
    }

    public function updateUser($id, Request $request)
    {
        $user = Users::findOrFail($id);

        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email",
            "password" => "required",
            "user_type" => "required",
        ]);

        $request->offsetSet("password",Hash::make($request->password));

        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function deteleUser($id)
    {
        Users::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
