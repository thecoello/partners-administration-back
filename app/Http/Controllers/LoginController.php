<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function postLogin(Request $request)
    {
        $findUser = DB::table("users")->where("users.email", "like", $request->email)->first('*');

        if ($findUser) {
            $checkPass = Hash::check($request->password, $findUser->password);

            if ($checkPass) {
                $token = $findUser->user_token;          
                return  response(['Authorization' => $token, 'user_id'=>$findUser->id],200)->header('Authorization', $token);
            } else {
                return response()->json(['status' => 'fail'], 401);
            }
        } else {
            return response()->json(['status' => 'user not found'], 404);
        } 
    }

    public function getAuthUser(){
        $user['id'] = Auth::user()->id;
        $user['user_type'] = Auth::user()->user_type;
        return $user;
    }
}
