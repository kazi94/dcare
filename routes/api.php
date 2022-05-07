<?php

use Illuminate\Http\Request;

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

Route::middleware('api')->namespace('Api')->group(function () {
    Route::get('patients/get-between-dates/{start?}/{end?}', 'PatientController@getBetweenTwoDates');
    Route::apiResource('patients', 'PatientController');
    // Route::apiResource('prescriptions', 'PrescriptionController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
