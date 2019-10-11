<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        return Report::all();
    }

    public function create(Request $request){
        
        $validator = Validator::make($request->all(), [
            'photo_url' => 'required',
            'description' => 'nullable',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        Report::create([
            'user_id' => auth()->user()->id,
            'photo_url' => $request->photo_url,
            'description' => $request->description,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response('Report successfully been created.', 201);
    }

    public function find($id)
    {
        $report = Report::findOrFail($id);
        return $report;        
    }

    public function update($id, Request $request) {
        $report = Report::findOrFail($id);

        $report->update($request->only([
            'photo_url',
            'lat',
            'lng'
        ]));

        return response('Report updated!', 200);
    }

    public function delete(Request $request) {
        $report = Report::findOrFail($request->report_id);
        $report->delete();

        return response('Report successfully deleted!', 200);
    }
}
