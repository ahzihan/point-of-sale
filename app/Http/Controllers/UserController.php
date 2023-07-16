<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserRegistration(Request $request){

        try{
            User::create([
                "firstName"=>$request->input('firstName'),
                "lastName"=>$request->input('lastName'),
                "email"=>$request->input('email'),
                "mobile"=>$request->input('mobile'),
                "password"=>$request->input('password'),
            ]);

        return response()->json([
            "message"=>"User Register Successfully!",
            "status"=>"success"
        ],200);
        }catch(Exception $e){
            return response()->json([
            "message"=>$e->getMessage(),
            "status"=>"failed"
        ],200);
        }

    }
}
