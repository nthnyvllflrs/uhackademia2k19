<?php

use Illuminate\Http\Request;
use App\User;
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
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::middleware('auth:api')->group( function() {
    Route::post('/logout', 'AuthController@logout');
    
    Route::get('/user/current-user', function (Request $request) { return $request->user();});

    Route::get('/barangays', 'BarangayController@index');
    Route::post('/barangays', 'BarangayController@store');
    Route::get('/barangays/names', 'BarangayController@barangay_names');
    Route::get('/barangays/{barangay}', 'BarangayController@show');
    Route::put('/barangays/{barangay}', 'BarangayController@update');
    Route::delete('/barangays/{barangay}', 'BarangayController@destroy');

    Route::get('/residents', 'ResidentController@index');
    Route::post('/residents', 'ResidentController@store');
    Route::get('/residents/{resident}', 'ResidentController@show');
    Route::put('/residents/{resident}', 'ResidentController@update');
    Route::delete('/residents/{resident}', 'ResidentController@destroy');

    Route::get('/reports', 'ReportController@index');
    Route::post('/reports', 'ReportController@store');
    Route::get('/reports/{report}', 'ReportController@show');
    Route::put('/reports/{report}', 'ReportController@update');
    Route::delete('/reports/{report}', 'ReportController@destroy');

    Route::get('/collectors', 'CollectorController@index');
    Route::post('/collectors', 'CollectorController@store');
    Route::get('/collectors/{collector}', 'CollectorController@show');
    Route::put('/collectors/{collector}', 'CollectorController@update');
    Route::delete('/collectors/{collector}', 'CollectorController@destroy');
    
    Route::get('/collector-schedule', 'CollectorScheduleController@index');
    Route::post('/collector-schedule', 'CollectorScheduleController@store');
    Route::get('/collector-schedule/{collector_schedule}', 'CollectorScheduleController@show');
    Route::put('/collector-schedule/{collector_schedule}', 'CollectorScheduleController@update');
    Route::delete('/collector-schedule/{collector_schedule}', 'CollectorScheduleController@destroy');
});

Route::get('for-testing-purpose', function (Request $request) {
    return User::all();
});

Route::post('/android/reports', 'ReportController@store');
Route::post('/android/residents', 'ResidentController@store');
Route::get('/android/barangays', 'BarangayController@index');

// Route::post('/android/register_resident', 'ResidentController@register_resident');
// Route::post('/android/login_resident', 'ResidentController@login_resident');
// Route::post('/android/send_report', 'ReportController@send_report');