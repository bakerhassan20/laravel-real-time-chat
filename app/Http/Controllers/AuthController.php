<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request)
    {
       $rules = [
        'name' => 'required|string',
        'email'=> 'required|string|unique:users',
        'password'=> 'required|string|min:6',
       ];
       $validator = Validator::make($request ->all(),$rules);

       if($validator->fails()){
         return response()->json($validator->errors(), 400);
       }

       $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),

       ]);

       $token = $user->createToken('Personal Access Token')->plainTextToken;
       $response =['user'=>$user,'token'=>$token];
       return response()->json($response, 200);

    }

    public function login(Request $request)
    {
      $rules = [
        'email'=> 'required',
        'password'=> 'required|string',
       ];
        $request ->validate($rules);

        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
          $token = $user->createToken('Personal Access Token')->plainTextToken;
          $response=['user'=>$user,'token'=>$token];
          return response()->json($response, 200);

        }

        $response = ['message' =>'incorrect email or password'];
        return response()->json($response, 400);


    }
}
