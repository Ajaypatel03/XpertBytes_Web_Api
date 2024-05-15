<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request){

        $request->validate([
            "name"=>'required|string',
            "email"=>'required|email|string|unique:users',
            "password"=>'required',
            "phoneNo"=>'required|numeric',
        ]);

        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
            "phoneNo"=>$request->phoneNo,
        ]);

        return response()->json([

            "status"=>true,
            "message"=>"Admin Registered Successfully In XB ",
            "data"=>[]
        ]);

    }

    public function login(Request $request){

        $request->validate([
            "email"=>'required|email|string',
            "password"=>'required',
        ]); 

        $user = User::where('email',$request->email)->first();
        
        if(!empty($user)){
            if(Hash::check($request->password , $user->password)){

                $token = $user->createToken("LoginToken")->accessToken;
                return response()->json([
                    "status"=>true,
                    "message"=>"Admin Login Successfully In XB",
                    "token"=>$token,
                    "data"=>[]
                ]);
            }else{
                return response()->json([
                    "status"=>false,
                    "message"=>"Password Not Match,Please check The Password",
                    "data"=>[]
                ]);
            }            
        }else{
            return response()->json([
                    "status"=>false,
                    "message"=>"Invalid Email Value",
                    "data"=>[]
                ]);
        }
    }

    public function profile(){

        $userData = auth()->user();
        
        return response()->json([
                "status"=>true,
                "message"=>"Profile Information",
                "data"=> $userData,
                // "id"=>auth()->user()->name
            ]);
    }

    public function logout(){

        $userData = auth()->user();
        $userData->token()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Admin Successfully logged out',
        ]);
    }
}