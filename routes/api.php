<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Project\ApiProjectController;
use App\Http\Controllers\Report\ApiReportController;
use App\Http\Controllers\Schedule\ApiScheduleController;
use App\Http\Controllers\User\ApiUserController;
use App\Models\User;
use Facade\FlareClient\Api;
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
    //secure
    Route::get('/user/{id}', [ApiUserController::class, 'getOneUser']);
    // not done yet
    Route::put('/user', [ApiUserController::class, 'updateUser']);
    
    //secure
    Route::get('/project/{id}', [ApiProjectController::class, 'getOneProjectById']);
    //secure
    Route::get('/project/user/{userid}', [ApiProjectController::class, 'getAllProjectsByUserId']);

    //secure
    Route::get('/report/project/{projectid}', [ApiReportController::class, 'getAllReportsByProjectId']);

    //secure
    Route::get('/report/{id}', [ApiReportController::class, 'getOneReportById']);

    //not check
    Route::get('/schedule/user/{id}', [ApiScheduleController::class, 'getOneScheduleByUserId']);

});

Route::group(['middleware' => ['auth:sanctum', 'is_admin']], function() {
    Route::get('/user', [ApiUserController::class, 'getAllUser']);
    
    Route::get('/project/admin/{adminid}', [ApiProjectController::class, 'getAllProjectsByAdminId']);
    Route::post('/project', [ApiProjectController::class, 'addProject']);
    Route::put('/project', [ApiProjectController::class, 'updateProject']);
    Route::delete('/project', [ApiProjectController::class, 'deleteProject']);
    Route::get('/project', [ApiProjectController::class, 'getAllProjects']);

    Route::post('/report', [ApiReportController::class, 'addReport']);
    Route::put('/report', [ApiReportController::class, 'updateReport']);
    Route::delete('/report', [ApiReportController::class, 'deleteReport']);

    Route::get('/schedule', [ApiScheduleController::class, 'getAllSchedule']);
    Route::post('/schedule', [ApiScheduleController::class, 'addSchedule']);
    Route::get('/schedule/admin/{id}', [ApiScheduleController::class, 'getOneScheduleByAdminId']);
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login',[ApiAuthController::class, 'login']);
    Route::post('/register',[ApiAuthController::class, 'register']);
    Route::get('/admin', [ApiUserController::class, 'getAdmin']);
});