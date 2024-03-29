<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'login']);

//Question Route
Route::prefix('question')->group(function () {
    Route::get('/', [QuestionController::class,'getData']);
    Route::post('/', [QuestionController::class,'store']);
    Route::get('/{id}', [QuestionController::class,'edit']);
    Route::put('/{id}', [QuestionController::class,'update']);
    Route::delete('/{id}', [QuestionController::class,'delete']);
    Route::get('/quick-info/dashboardQuickInfo', [QuestionController::class,'DashboardQuickInfo']);
});
//Question Route

//Student Route
Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class,'getData']);
    Route::post('/', [StudentController::class,'store']);
    Route::get('/{id}', [StudentController::class,'edit']);
    Route::put('/{id}', [StudentController::class,'update']);
    Route::delete('/{id}', [StudentController::class,'delete']);
});
//Student Route
