<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Resident;
use App\Barangay;

class ResidentController extends Controller {
    public function index() {
        return response(['resident' => Resident::with(['user', 'barangay'])->get()]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create(array_merge($request->toArray(), ['verified' => false]));
        $barangay = Barangay::where('name', $request->barangay)->first();
        $resident = Resident::create(array_merge($request->toArray(), ['user_id' => $user->id, 'barangay_id' => $barangay->id]));

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token, 'user' => $user, 'resident' => $resident], 201);
    }

    public function show(Resident $resident) {
        $resident->user; $resident->barangay;
        return response(['resident' => $resident], 200);
    }

    public function update(Request $request, Resident $resident) {
        $request['password'] = Hash::make($request['password']);
        $resident->update($request->toArray());
        $resident->user->update($request->toArray());
        return response(['resident' => $resident], 200);
    }

    public function destroy(Resident $resident) {
        $resident->user->delete();
        $resident->delete();
        return response(null, 204);
    }
}
