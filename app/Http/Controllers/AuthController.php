<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validated = $request->validate([
            "name"=> "required|string|min:3|max:20",
            "email"=> "required|string|unique:users,email",
            "password"=> "required|string|min:6|confirmed",
        ]);
        $user = User::create([
            "name"=> $validated["name"],
            "email"=> $validated["email"],
            "password"=> Hash::make($validated["password"]),
        ]);
        $token = $user->createToken("auth_token",["read-book","delete-book","update-book","insert-book","read-author"])->plainTextToken;
        return response()->json([
            "success"=> true,
            "user"=> new UserResource($user),
            "token"=> $token
        ]);
    }
    public function login(Request $request){
        $validated = $request->validate([
            "email"=> "required|string",
            "password"=> "required|string|min:6",
        ]);
        $user = User::where('email', $validated["email"])->first();
        if(!user || !Hash::check($validated["password"], $user->password)){
            return response()->json([
                "success"=> false,
                "message"=> "email or password is incorrect"
            ]);
        }
        $user = $user->createToken("auth_token",["delete","update"])->plainTextToken;
        return response()->json([
            "success"=> true,
            "user"=> new UserResource($user),
            "token"=> $token,
        ]);
    }
    public function logout(Request $request){
        try{
        if($request->user() && $request->user()->currentAccessToken()){
            $request->user()->tokens()->delete();
        }
        }catch(Exception $error){
            return response()->json([
                "messgae"=> $error->getMessage(),
            ]);
        }
        // return response()->json([
        //     "message"=> "user has already been logged out",
        // ]);
        // $request->user()->currentAccessToken()->delete();
        // return response()->json([
        //     "data"=> "You are logged out",
        // ]);
    }
}
