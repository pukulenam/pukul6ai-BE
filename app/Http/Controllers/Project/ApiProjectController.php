<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiProjectController extends Controller
{
    public function getAllProjectsByUserId(Request $request,$userid){
        $project = Project::where('userid',$userid)->get();

        if ((auth()->user()->id != $userid) && auth()->user()->role != "admin") {
            return response(["errors" => array("You Are Not Authenticated")], 422);
        }
        
        foreach ($project as $p) {
            $total_time = 0;
            $report = Report::where('project_id', $p['id'])->get();

            foreach ($report as $r) {
                $r['end'] != NULL ? (
                    $total_time += strtotime($r['end']) - strtotime($r['start'])
                ) : NULL;
            }

            $p['adminid'] = User::where('id', $p['adminid'])->pluck('full_name')[0];
            $p['total_time'] = $total_time;
        }

        return response($project, 200);
    }

    public function getAllProjectsByAdminId(Request $request,$adminid){
        $project = Project::where('adminid',$adminid)->get();
        
        foreach ($project as $p) {
            $total_time = 0;
            $report = Report::where('project_id', $p['id'])->get();

            foreach ($report as $r) {
                $r['end'] != NULL ? (
                    $total_time += strtotime($r['end']) - strtotime($r['start'])
                ) : NULL;
            }

            $p['adminid'] = User::where('id', $p['adminid'])->pluck('full_name')[0];
            $p['total_time'] = $total_time;
        }

        return response($project, 200);
    }

    public function getAllProjects() {
        $project = Project::all();

        foreach ($project as $p) {
            $total_time = 0;
            $report = Report::where('project_id', $p['id'])->get();

            foreach ($report as $r) {
                $r['end'] != NULL ? (
                    $total_time += strtotime($r['end']) - strtotime($r['start'])
                ) : NULL;
            }

            $p['adminid'] = User::where('id', $p['adminid'])->pluck('full_name')[0];
            $p['total_time'] = $total_time;
        }

        return response($project, 200);
    }

    public function getOneProjectById(Request $request,$id){
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [ 'id' => 'required|integer|exists:projects']);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $project = Project::where('id', $id)->first();

        if ((auth()->user()->id != $project['userid']) && auth()->user()->role != "admin") {
            return response(["errors" => array("You Are Not Authenticated")], 422);
        }

        $report = Report::where('project_id', $project['id'])->get();
        
        $total_time = 0;
        foreach ($report as $r) {
            $r['end'] != NULL ? (
                $total_time += strtotime($r['end']) - strtotime($r['start'])
            ) : NULL;
        }

        $project['total_time'] = $total_time;
        $project['adminid'] = User::where('id', $project['adminid'])->pluck('full_name')[0];

        return response($project, 200);
    }

    public function addProject(Request $request){
        $validator = Validator::make($request->all(), [
            'userid' => 'required|exists:users,id',
            'adminid' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'start' => 'date_format:Y/m/d H:i:s',
            'end' => 'date_format:Y/m/d H:i:s',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $is_admin = User::where('id', $request['adminid'])->first();
        if ($is_admin['role'] != 'admin') {
            $res['errors'] = array($is_admin['full_name'] . "is not an admin");
            return response($res, 422);
        }

        $request['progress'] = 0;
        $request['start'] = $request['start'] ? NULL : $request['start'];
        $request['end'] = $request['end'] == NULL ? NULL : $request['end'];

        $project = Project::create($request->toArray());

        return response($project, 200);
    }

    public function updateProject(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:projects',
            'name' => 'string|max:255',
            'userid' => 'exists:users,id',
            'adminid' => 'exists:users,id',
            'progress' => 'integer',
            'start' => 'date_format:Y/m/d H:i:s|nullable',
            'end' => 'date_format:Y/m/d H:i:s|nullable',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $Project = Project::where('id', $request->id)->first();
        $Project['userid'] = $request['userid'] ? $request['userid'] : $Project['userid'];
        $Project['adminid'] = $request['adminid'] ? $request['adminid'] : $Project['adminid'];
        $Project['name'] = $request['name'] ? $request['name'] : $Project['name'];
        $Project['progress'] = $request['project'] ? $Project['progress'] : $request['progress'];   // tmp value
        $Project['start'] = $request['start'] ? $request['start'] : $Project['start'];
        $Project['end'] = $request['end'] ? $request['end'] : $Project['end'];

        $Project->save();

        return response($Project, 200);
    }

    public function deleteProject(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:projects',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        $project = Project::where('id', $request->id)->first();
        $response["project"] = $project["name"];
        $response["message"] = array("Project Deleted {$project['name']}");

        $project->delete();

        return response($response, 200);
    }
}
