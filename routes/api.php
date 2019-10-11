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
Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register');

Route::middleware('auth:api')->group( function() {
    Route::post('/logout', 'AuthController@logout');
    
    Route::get('/user/current-user', function (Request $request) { return $request->user();});

    Route::prefix('report')->group(function (){
        Route::get('/', 'ReportController@index');
        Route::post('/', 'ReportController@create');
        Route::post('delete', 'ReportController@delete');
        Route::get('/{id}', 'ReportController@find');
        Route::post('/{id}', 'ReportController@update');
    });
});
