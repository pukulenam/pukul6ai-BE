<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Project\ApiProjectController;
use App\Http\Controllers\User\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', function (Request $req) { return $req->user(); });
    Route::put('/user', [ApiUserController::class, 'updateUser']);
    
    Route::get('/project/{userid}', [ApiProjectController::class, 'getAllProjectsByUserId']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin']], function() {
    Route::post('/project', [ApiProjectController::class, 'addProject']);
    Route::put('/project', [ApiProjectController::class, 'updateProject']);
    Route::delete('/project', [ApiProjectController::class, 'deleteProject']);
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login',[ApiAuthController::class, 'login']);
    Route::post('/register',[ApiAuthController::class, 'register']);
    Route::get('/admin', [ApiUserController::class, 'getAdmin']);
});