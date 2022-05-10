<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiScheduleController extends Controller
{
    function getAllSchedule() {
        $schedule = Schedule::all();

        return response($schedule, 200);
    }

    function getOneScheduleByUserId(Request $request, $id) {
        $schedule = Schedule::where('userid', $id)->get();

        if ((auth()->user()->id != $id) && auth()->user()->role != "admin") {
            return response(["errors" => array("You Are Not Authenticated")], 422);
        }

        return response($schedule, 200);
    }

    function addSchedule(Request $request) {
        $event = Http::withHeaders([
            'Authorization' => "Bearer ".env('CALENDLY_API')
        ])->get($request['time']);
        
        $event = json_decode($event, true);

        $event['resource']['start_time'] = strtotime($event['resource']['start_time']);
        $event['resource']['start_time'] = date("Y/m/d H:i:s", $event['resource']['start_time']);

        $request['time'] = $event['resource']['start_time'];
        $request['name'] = $event['resource']['name'];

        $validator = Validator::make($request->all(), [
            'userid' => 'required|integer|exists:users,id',
            'time' => 'required|date_format:Y/m/d H:i:s',
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $schedule = Schedule::create($request->toArray());

        return response($schedule, 200);
    }
}
