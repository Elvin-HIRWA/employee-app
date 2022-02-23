<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UsersController;
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


Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::get('/employee/{id}',[EmployeeController::class, 'show']);

Route::post('/employee',[EmployeeController::class, 'store'])->middleware("auth:sanctum");
Route::get('/employee/search/{name}',[EmployeeController::class, 'search']);
Route::put('/employee/{id}',[EmployeeController::class, 'update']);
Route::delete('/employee/{id}',[EmployeeController::class, 'destroy']);
Route::post('/logout',[UsersController::class, 'logout'])->middleware("auth:sanctum");

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
