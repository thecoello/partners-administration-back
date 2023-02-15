<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersControllers extends Controller
{
    public function showAllUsers(){
        return response()->json(Users::all());
    }

    public function showUser($id){
        return response()->json(Users::find($id));
    }

    public function createUser(Request $request){
        $user = Users::create($request->all());
        return response()->json($user,201);
    }

    public function updateUser($id, Request $request)
    {
        $user = Users::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function deteleUser($id)
    {
        Users::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
