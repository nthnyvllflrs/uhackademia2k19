<?php

namespace App\Http\Controllers;

use Hash;

use App\User;
use App\UserInformation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',

            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            
            'role' => 'required|integer|max:255',
        ]);

        if($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 401);
        }

        $user = User::create($request->all());
        
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token], 201);
    }

    public function login(Request $request) {
        if(auth()->attempt($request->only(['username', 'password'])))
        {
            $user = User::where('username', $request->username)->first();
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response(['token' => $token], 200);
        }
        else
            return abort(401);
    }

    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response('You have successfully logged out', 200);
    }
}
