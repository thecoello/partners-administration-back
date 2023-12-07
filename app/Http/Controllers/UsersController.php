<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class UsersController extends Controller
{

    public function getUsers()
    {
        return DB::table("users")->select("id","name","contact","email","user_type")->orderBy("id", "desc")->simplePaginate(15);
    }

    public function getUser($id)
    {
        $result = DB::table("users")->select("id","name","contact","email","user_type")->where("id", $id)->orderBy("id", "desc")->get();
        return  $result;
    }

    public function getUserSearch($search)
    {      
        $result =  DB::table("users")->where("users.contact","like","%".$search."%")->orWhere("users.name","like","%".$search."%")->orWhere("users.email","like","%".$search."%")->select(
        "id","name","contact","email","user_type")->orderBy("id", "desc")->simplePaginate(15);

        if($result){
            return $result;
        }else{
            return response()->json("Error obteniendo invoices");
        }
    }

    public function postUser(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "user_type" => "required",
        ]);

        $userRequest = [
            "name" => $request->name,
            "contact" => $request->contact,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "user_type" => $request->user_type,
            "user_token" => Str::random(64)
        ];

        $result = DB::table("users")->insert($userRequest);
        return $result;
    }

    public function updateUser($id, Request $request)
    {
        $_request = request()->all();

        if($request->password != ''){
            $_request["password"] = Hash::make($request->password);
        }else{
            unset($_request['password']);
        }

        $result = DB::table("users")->where("id", $id)->update($_request);

        return $result;
    }

    public function deteleUser($id)
    {
        $result = DB::table("users")->delete($id);
        return $result;
    }
}