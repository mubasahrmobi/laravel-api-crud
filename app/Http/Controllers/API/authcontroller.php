<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class authcontroller extends Controller
{
  public function signup(Request $request){
    $validuser = Validator::make(
        $request->all(),
        [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]
    );
    if($validuser->fails()){
        return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validuser->errors()->all(),
        ],401);
    }
    $user = User::create([
        'name'=> $request->name,
        'email' => $request->email,
        'password'=>$request->password,
    ]);
    return response()->json([
        'status' => true,
        'message' => 'User create Succesfully',
        'user' => $user,
    ],200);
  }

  public function login(Request $request){
    $validuser = Validator::make(
        $request->all(),
        [
            'email' => 'required|email',
            'password' => 'required',
        ]
    );
    if($validuser->fails()){
        return response()->json([
            'status' => false,
            'message' => 'Authentication Fail',
            'errors' => $validuser->errors()->all(),
        ],404);
    }
    if(Auth::attempt(['email' => $request->email,'password'=>$request->password,])){
        $authuser = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Logged in Succesfully',
            'token' =>  $authuser->createToken("API TOKEN")->plainTextToken,
            'token_type' => 'bearer',
        ],200);
    }else{
        return response()->json([
            'status' => false,
            'message' => 'Email or password does not Match',
        ],401);
    }
  }

  public function logout(Request $request){
    $user = $request->user();
    $user->tokens()->delete();

    return response()->json([
        'status' => true,
        'user' => $user,
        'message' => ' you Logged out Succesfully',
    ],200);
  }
}
