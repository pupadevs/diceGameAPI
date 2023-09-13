<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;









class UserController extends Controller
{
    public function login(Request $request){


        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required' => 'Email is required.',
            'password.required' => 'Please enter a password.',
        ];


        $validator = Validator::make($request->all(),$rules, $messages);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if(Auth::attempt($data)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json(['message' => 'Logged in', 'user' => $user->name, 'auth_token' => $token], 200);

        }
        return response()->json(['message' => 'User or password'], 401);
    }

   




}
