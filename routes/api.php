<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {

        // Tasks
        Route::apiResource('tasks', TasksController::class);

        Route::post('logout', [AuthController::class, 'logout']);
    }
);
