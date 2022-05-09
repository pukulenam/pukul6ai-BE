<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class person {
    public $name;
    public $total;
}

class ApiReportController extends Controller
{
    public function getAllReportsByProjectId(Request $request, $projectid) {
        $report = Report::where('project_id', $projectid)->get();

        $validator = Validator::make(['id' => $projectid], [ 'id' => 'required|integer|exists:projects']);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $project = Project::where('id', $projectid)->first();

        if ((auth()->user()->id != $project['userid']) && auth()->user()->role != "admin") {
            return response(["errors" => array("You Are Not Authenticated")], 422);
        }

        $admin = User::where('role', 'admin')->pluck('full_name');
        $work = array();
        $workload = array();

        foreach ($report as $r) {
            $r['end'] != NULL ? (
                $r['total_time'] = strtotime($r['end']) - strtotime($r['start'])
            ) : $r['total_time'] = NULL;

            if ($r['total_time'] != NULL) {
                $hour = floor($r['total_time'] / 3600);
                $min = (($r['total_time'] / 60) % 60);
                $r['bySecond'] = $r['total_time'];
                $r['total_time'] = sprintf("%02d:%02d", $hour, $min);
            }

            $adminCov = User::whereIn('id', (explode(",", $r['admin'])))->pluck('full_name');
            $r['admin'] = $adminCov;
            
            foreach ($adminCov as $a) {
                for ($i = 0; $i < count($admin); $i++) {
                    if ($a == $admin[$i]) {
                        array_key_exists($a, $work) ? (
                            $work[$a] += $r['bySecond'] ? (int)$r['bySecond'] : 0
                        ) : (
                            $work[$a] = $r['bySecond'] ? (int)$r['bySecond'] : 0
                        );
                        continue;
                    }
                }
            }
        }

        $i = 0;
        
        foreach ($work as $id => $val) {
            $tmp = new person();
            $tmp->name = $id;
            $tmp->total = sprintf("%02d:%02d", $val / 3600, ($val / 60) % 60);
            array_push($workload, $tmp);
        }

        $response['report'] = $report;
        $response['workload'] = $workload;

        return response($response, 200);
    }
    
    public function getOneReportById(Request $request,$id){
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [ 'id' => 'required|integer|exists:reports']);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        $report = Report::where('id', $id)->first();

        $project = Project::where('id', $report['project_id'])->first();

        if ((auth()->user()->id != $project['userid']) && auth()->user()->role != "admin") {
            return response(["errors" => array("You Are Not Authenticated")], 422);
        }

        $adminCov = User::whereIn('id', (explode(",", $report['admin'])))->pluck('full_name');
        $report['adminByName'] = $adminCov;

        return response($report, 200);
    }

    public function addReport(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'project_id' => 'required|integer|exists:projects,id',
            'start' => 'required|date_format:Y/m/d H:i:s',
            'end' => 'date_format:Y/m/d H:i:s',
            'admin' => 'required|string|max:255',
            'attachment' => 'string|max:255'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $admin = [];

        $count = 0;

        $tmp = "";
        for ($i = 0; $i < Str::length($request['admin']); $i++) {
            if ($request['admin'][$i] == ",") {
                $admin = Arr::add($admin, $count++, $tmp);
                $tmp = 0; continue;
            }
            $tmp .= $request['admin'][$i];
        }

        $admin = Arr::add($admin, $count++, $tmp);

        $res['errors'] = [];
        $err = 0;
        for ($i = 0; $i < $count; $i++) {
            $user = User::where('id', (int)$admin[$i])->first();
            if ($user['role'] != 'admin') {
                $res['errors'] = Arr::add($res['errors'], $err++, $user['full_name']." not an admin\n");
            }
        }

        if ($res['errors'] != [])
            return response($res, 422);

        $request['end'] = $request['end'] == NULL ? NULL : $request['end'];
        $request['attachment'] = $request['attachment'] == NULL ? NULL : $request['attachment'];
    
        $report = Report::create($request->toArray());

        return response($report, 200);
    }

    public function updateReport(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:reports',
            'project_id' => 'required|integer|exists:projects,id',
            'description' => 'required|string|max:255',
            'start' => 'required|date_format:Y/m/d H:i:s',
            'end' => 'date_format:Y/m/d H:i:s|nullable',
            'admin' => 'required|string|max:255',
            'attachment' => 'string|max:255|nullable'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        // admin validation by string parse
        $admin = [];

        $count = 0;

        $tmp = "";
        for ($i = 0; $i < Str::length($request['admin']); $i++) {
            if ($request['admin'][$i] == ",") {
                $admin = Arr::add($admin, $count++, $tmp);
                $tmp = 0; continue;
            }
            $tmp .= $request['admin'][$i];
        }

        $admin = Arr::add($admin, $count++, $tmp);

        $res['errors'] = [];
        $err = 0;
        for ($i = 0; $i < $count; $i++) {
            $user = User::where('id', (int)$admin[$i])->first();
            if ($user['role'] != 'admin') {
                $res['errors'] = Arr::add($res['errors'], $err++, $user['full_name']." not an admin\n");
            }
        }

        if ($res['errors'] != [])
            return response($res, 422);

        $report = Report::where('id', $request['id'])->first();
        $report['description'] = $request['description'];
        $report['start'] = $request['start'];
        $report['end'] = $request['end'] == NULL ? NULL : $request['end'];
        $report['admin'] = $request['admin'];
        $report['attachment'] = $request['attachment'] == NULL ? NULL : $request['attachment'];
    
        $report->save();

        return response($report, 200);
    }

    public function deleteReport(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:reports',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $report = Report::where('id', $request['id'])->first();
        $response["project"] = $report["description"];
        $response["project_id"] = $report['project_id'];
        $response["message"] = "Report Deleted {$report['name']}";

        $report->delete();

        return response($response, 200);
    }
}
