<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Resident;
use App\Report;

class ReportController extends Controller {
    public function index() {
        return response(['reports' => Report::with(['resident.user'])->get()]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'resident' => 'required|string|max:255',
            'description' => 'string|max:255',
            'photo' => 'mimes:jpeg,jpg,png|max:10000',
            'address' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $user = User::where('username', $request->resident)->first();
        $resident = Resident::where('user_id', $user->id)->first();
        $report = Report::create(array_merge($request->toArray(), ['resident_id' => $resident->id]));
        $report->resident->user;
        return response(['report' => $report], 201);
    }

    public function show(Report $report) {
        $report->resident->user;
        return response(['report' => $report], 201);
    }

    public function update(Request $request, Report $report) {
        $user = User::where('username', $request->resident)->first();
        $resident = Resident::where('user_id', $user->id)->first();
        $report->update(array_merge($request->toArray(), ['resident_id' => $resident->id]));
        $report->resident->user;
        return response(['report' => $report], 201);
    }

    public function destroy(Report $report) {
        $report->delete();
        return response(null, 204);
    }
}
