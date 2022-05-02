<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiUserController extends Controller
{
    public function getAdmin() {
        $user = User::where('role', 'admin')->get();
        return $user;
    }

    public function getAllUser(Request $req) {
        $user = User::all();
        return response($user, 200);
    }

    public function updateUser(Request $req) {
        $validator = Validator::make($req->all(), [
            'id' => 'required|integer|exists:users,id',
            'username' => 'required|string|max:255', Rule::unique('users')->ignore($req['id']),
            'email' => 'required|string|email|max:255',Rule::unique('users')->ignore($req->id),
        ]);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], 422);
        }

        $user = User::where('id', $req['id'])->first();

        $user['full_name']=$req['full_name'] == NULL ? $user['full_name'] : $req['full_name'];
        $user['username']=$req['username'];
        $user['email']=$req['email'];
        $user['image']=$req['image'] == NULL ? $user['image'] : $req['image'];
    
        $user->save();

        return response($user, 200);
    }
}