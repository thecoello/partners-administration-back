<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersControllers extends Controller
{
    public function showAllUsers(){
        return response()->json(Users::all());
    }
}
