<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ApiScheduleController extends Controller
{
    function getAllSchedule() {
        $schedule = Schedule::all();

        return response($schedule, 200);
    }

    function getOneScheduleByAdminId(Request $request, $id) {
        $schedule = Schedule::where('adminid', $id);

        return response($schedule, 200);
    }

    function getOneScheduleByUserId(Request $request, $id) {
        $schedule = Schedule::where('userid', $id);

        return response($schedule, 200);
    }

    function addSchedule(Request $request) {
        
    }
}
