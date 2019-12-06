<?php

namespace App\Http\Controllers;

use Hash;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255|confirmed',
            'role' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token, 'user_type' => $user->role, 'user_id' => $user->id], 200);
    }

    public function login(Request $request) {
        $user = User::where('username', $request->username)->first();
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token, 'user_type' => $user->role, 'user_id' => $user->id, 'user_fullname' => $user->resident->fullname], 200);
            } else {
                return response('Password missmatch', 422);
            }
        } else {
            return response('User does not exist', 422);
        }
    }

    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response('You have successfully logged out', 200);
    }
}
