<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resident;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    public function index()
    {
        return Resident::all();
    }

    public function create(Request $request){
        
        $validator = Validator::make($request->all(), [
            'contact_number' => 'required',
            'address' => 'required|string',
            'lat' => 'required|min:-90|max:90',
            'lng' => 'required|min:-180|max:180',
        ]);

        if($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        Resident::create([
            'user_id' => auth()->user()->id,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);


        //Return object
        return response('Resident successfully been created.', 201);
    }

    public function find($id)
    {
        $resident = Resident::findOrFail($id);
        return $resident;        
    }

    public function update($id, Request $request) {
        $resident = Resident::findOrFail($id);

        $resident->update($request->only([
            'contact_number',
            'address',
            'lat',
            'lng',
        ]));

        //Return object
        return response('Resident updated!', 200);
    }

    public function delete(Request $request) {
        //TODO: Validation if deleter is owner of object
        $resident = Resident::findOrFail($request->resident_id);
        $resident->delete();

        return response('Resident successfully deleted!', 200);
    }
}
