<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('employees', 'App\Http\Controllers\EmployeeController');
Route::delete('employees/salary/{emp_no}/{from_date}', 'App\Http\Controllers\EmployeeController@deleteSalary');
Route::delete('employees/titles/{emp_no}/{from_date}/{title}', 'App\Http\Controllers\EmployeeController@deleteTitles');
