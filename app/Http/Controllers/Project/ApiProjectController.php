<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiProjectController extends Controller
{
    public function getAllProjectsByUserId(Request $request,$userid){
        $project = Project::where('userid',$userid)->get();

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
            $res['errors'] = $is_admin['full_name'] . "is not an admin";
            return response($res, 422);
        }

        $request['progress'] = 0;
        $request['start'] = $request['start'] == NULL ? NULL : $request['start'];
        $request['end'] = $request['end'] == NULL ? NULL : $request['end'];

        $project = Project::create($request->toArray());

        return response($project, 200);
    }

    public function updateProject(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:projects',
            'name' => 'required|string|max:255',
            'userid' => 'required|exists:users,id',
            'adminid' => 'required|exists:users,id',
            'progress' => 'integer',
            'start' => 'date_format:Y/m/d H:i:s',
            'end' => 'date_format:Y/m/d H:i:s',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $is_admin = User::where('id', $request['adminid'])->first();
        if ($is_admin['role'] != 'admin') {
            $res['errors'] = $is_admin['full_name'] . "is not an admin";
            return response($res, 422);
        }

        $Project = Project::where('id', $request->id)->first();
        $Project['userid'] = $request['userid'];
        $Project['adminid'] = $request['adminid'];
        $Project['name'] = $request['name'];
        $Project['progress'] = 0;   // tmp value
        $Project['start'] = $request['start'] == NULL ? $Project['start'] : $request['start'];
        $Project['end'] = $request['end'] == NULL ? $Project['end'] : $request['end'];

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
        $response["message"] = "Project Deleted {$project['name']}";

        $project->delete();

        return response($response, 200);
    }
}
