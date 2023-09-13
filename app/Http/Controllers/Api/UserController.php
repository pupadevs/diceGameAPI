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

    public function register(Request $request){

       $rules = [
            'name' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        $messages = [
            'email.required' => 'The email field is required.',
            'password.min' => 'The length is less than 8.',
            'password.required' => 'The password field is required.',
        ];


     $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }
        $name = $request->filled('name') ? $request->name : 'Anonymous';
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
           ])->assignRole('player');


        return response()->json(['message' => 'register completed', 'name' => $user->name, 'email' => $user->email], 201);


    }




}
