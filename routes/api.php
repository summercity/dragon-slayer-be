<?php
// header('Access-Control-Allow-Origin: *');
// header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('/logout', 'Api\AuthController@logout');

// Schedules
Route::middleware('auth:api')->get('/recurring-schedules', 'Api\RecurringSchedulesController@index');
Route::middleware('auth:api')->get('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@show');
Route::middleware('auth:api')->post('/recurring-schedules', 'Api\RecurringSchedulesController@store');
Route::middleware('auth:api')->put('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@update');
Route::middleware('auth:api')->delete('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@destroy');
