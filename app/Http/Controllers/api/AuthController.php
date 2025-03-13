<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request){

        $data = $request->validate([
            "email" => 'required',
            "password" => 'required'
        ]);


        $user = User::where("email",$data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                'message' => 'email or password is incorrect!'
            ],401);
        }

        $token = $user->createToken("mytoken")->plainTextToken;

        return response()->json([
            "message" => "Login successfuly",
            "token" => $token
        ],200);

    
    }
    

    public function register(Request $request){
        $data = $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);

        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password'])
        ]);
        $token = $user->createToken('mytoken')->plainTextToken;
        return response()->json([
            "message" => "user ".$user->name." account created successfuly!",
            "token_user" => $token
        ], 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "logged out!"
        ]);
    }


}
