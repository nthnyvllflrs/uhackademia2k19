<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Barangay;
use App\CollectorSchedule;

class CollectorScheduleController extends Controller {
    public function index(Request $request) {
        $data = [];
        if($request->user()->role == 'Administrator') {
            foreach(CollectorSchedule::all() as $schedule) {
                $data[] = [
                    'id' => $schedule->id,
                    'barangay' => $schedule->barangay->name,
                    'date' => $schedule->date,
                    'time' => $schedule->time,
                ];
            }
        }
        return response(['schedules' => $data], 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'barangay' => 'required|string|max:255',
            'date' => 'required|string',
            'time' => 'required|string',
        ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $barangay = Barangay::where('name', $request->barangay)->first();
        $collector_schedule = CollectorSchedule::create(array_merge($request->toArray(), ['barangay_id' => $barangay->id]));
        $collector_schedule->barangay;
        return response(['collector_schedule' => $collector_schedule,], 201);
    }

    public function show(CollectorSchedule $collector_schedule) {
        $collector_scheduler->barangay;
        return response(['collector_scheduler' => $collector_scheduler]);
    }

    public function update(Request $request, CollectorSchedule $collector_schedule) {
        $barangay = Barangay::where('name', $request->barangay)->first();
        $collector_schedule->update(array_merge($request->toArray(), ['barangay_id' => $barangay->id]));
        return response(['collector_schedule' => $collector_schedule], 200);
    }

    public function destroy(CollectorSchedule $collector_schedule) {
        $collector_schedule->delete();
        return response(null, 204);
    }
}
