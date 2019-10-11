<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Resident;
use App\Report;

class ReportController extends Controller {
    public function index(Request $request) {
        if($request->user()->role == 'Administrator') {
            foreach(Report::all() as $report) {
                $data[] = [
                    'id' => $report->id,
                    'username' => $report->resident->user->username,
                    'barangay' => $report->resident->barangay->name,
                    'date_time' => date('d-m-Y H:i:s', strtotime($report->created_at)),
                ];
            }
            return response(['reports' => $data]);
        } else if($request->user()->role == 'Barangay') {
            $barangay = $request->user()->barangay;
            $report_list = Report::join('residents', 'reports.resident_id', 'residents.id')
            ->join('barangays', 'residents.barangay_id', 'barangays.id')
            ->select('*')
            ->where('barangays.name', $barangay->name)
            ->get();
            foreach($report_list as $report) {
                $data[] = [
                    'id' => $report->id,
                    'username' => $report->resident->user->username,
                    'barangay' => $report->resident->barangay->name,
                    'date_time' => date('d-m-Y H:i:s', strtotime($report->created_at)),
                ];
            }
            return response(['reports' => $data]);
        }
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
