<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Barangay;

class BarangayController extends Controller {
    public function index() {
        return response(['barangays' => Barangay::with(['user'])->get()]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $barangay = Barangay::create(array_merge($request->toArray(), ['user_id' => $user->id]));

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token, 'user' => $user, 'barangay' => $barangay], 201);
    }

    public function show(Barangay $barangay) {
        return response(['barangay' => Barangay::with(['user'])->get()]);
    }

    public function update(Request $request, Barangay $barangay) {
        $request['password'] = Hash::make($request['password']);
        $barangay->update($request->toArray());
        $barangay->user->update($request->toArray());
        return response(['barangay' => $barangay], 200);
    }

    public function destroy(Barangay $barangay) {
        $barangay->user->delete();
        $barangay->delete();
        return response(null, 204);
    }
}
