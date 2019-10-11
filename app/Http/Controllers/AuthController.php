<?php

namespace App\Http\Controllers;

use Hash;

use App\User;
use App\UserType;
use App\UserInformation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',

            'type' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user_type_id = UserType::where('name', $request->type)->first()->id;
        $request['password'] = Hash::make($request['password']);

        $user = User::create(array_merge($request->toArray(), ['user_type_id' => $user_type_id]));
        $user_information = UserInformation::create(array_merge($request->toArray(), ['user_id' => $user->id]));
        
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token], 200);
    }

    public function login(Request $request) {
        $user = User::where('username', $request->username)->first();
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token], 200);
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
