<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Collector;

class CollectorController extends Controller {
    public function index() {
        $data = [];
        foreach(Collector::all() as $collector) {
            $data[] = [
                'id' => $collector->id,
                'username' => $collector->user->username,
                'name' => $collector->name,
                'license_number' => $collector->license_number,
                'plate_number' => $collector->plate_number,
            ];
        }
        return response(['collectors' => $data]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:255',

            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $collector = Collector::create(array_merge($request->toArray(), ['user_id' => $user->id]));

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response(['token' => $token, 'user' => $user, 'collector' => $collector], 201);
    }

    public function show(Collector $collector) {
        $collector->user;
        return response(['collector' => $collector], 201);
    }

    public function update(Request $request, Collector $collector) {
        $request['password'] = Hash::make($request['password']);
        $collector->update($request->toArray());
        $collector->user->update($request->toArray());
        return response(['collector' => $collector], 200);
    }

    public function destroy(Collector $collector) {
        $collector->user->delete();
        $collector->delete();
        return response(null, 204);
    }
}
