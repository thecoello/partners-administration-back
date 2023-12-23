<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
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
                return  response(['Authtoken' => $token, 'user_id'=>$findUser->id],200)->header('Authtoken', $token);
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
        $user['name'] = Auth::user()->name;
        return $user;
    }

    public function resetPassword(Request $request){
        
        $findUser = DB::table("users")->where("users.email", "like", $request->email)->first('*');

        if($request->password == $request->passwordr){

            if($findUser){
                $_request = request()->all();
                unset($_request['passwordr']);

                if($request->password != ''){
                    $_request["password"] = Hash::make($request->password);
                }
                
                DB::table("users")->where("email", $request->email)->update($_request);

                return Response()->json('User updated',200);
        
            }else{
                return Response()->json('User does not exist', 401);
            }

        }else{
            return Response()->json('Password not the same', 401);
        }

    }
}
