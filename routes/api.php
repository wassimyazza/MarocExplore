<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DirectionController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::apiResource('users',UserController::class)

Route::get("/users",[UserController::class, "index"]);
Route::get("/users/{id}",[UserController::class, "show"]);
Route::post("/users",[AuthController::class, "register"]);
Route::post("/login",[AuthController::class, "login"]);
Route::post('/add-direction',[DirectionController::class, "addDirection"]);
Route::get('/directions',[DirectionController::class, "index"]);

Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::delete("/users/{id}",[UserController::class, "destroy"]);
    Route::put("/users/{id}",[UserController::class, "update"]);
    Route::post("/logout",[AuthController::class, "logout"]);
});
