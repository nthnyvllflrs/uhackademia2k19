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
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

Route::middleware('auth:api')->group( function() {
    Route::post('/logout', 'AuthController@logout');
    
    Route::get('/user/current-user', function (Request $request) { return $request->user();});
});


Route::get('/barangays', 'BarangayController@index');
Route::post('/barangays', 'BarangayController@store');
Route::get('/barangays/{barangay}', 'BarangayController@show');
Route::put('/barangays/{barangay}', 'BarangayController@update');
Route::delete('/barangays/{barangay}', 'BarangayController@destroy');

Route::get('/residents', 'ResidentController@index');
Route::post('/residents', 'ResidentController@store');
Route::get('/residents/{resident}', 'ResidentController@show');
Route::put('/residents/{resident}', 'ResidentController@update');
Route::delete('/residents/{resident}', 'ResidentController@destroy');