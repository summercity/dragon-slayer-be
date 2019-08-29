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

// Recurring Schedules
Route::middleware('auth:api')->get('/recurring-schedules', 'Api\RecurringSchedulesController@index');
Route::middleware('auth:api')->get('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@show');
Route::middleware('auth:api')->post('/recurring-schedules', 'Api\RecurringSchedulesController@store');
Route::middleware('auth:api')->put('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@update');
Route::middleware('auth:api')->delete('/recurring-schedules/{id}', 'Api\RecurringSchedulesController@destroy');


// Non Recurring Schedules
Route::middleware('auth:api')->get('/non-recurring-schedules', 'Api\NonRecurringSchedulesController@index');
Route::middleware('auth:api')->get('/non-recurring-schedules/{id}', 'Api\NonRecurringSchedulesController@show');
Route::middleware('auth:api')->post('/non-recurring-schedules', 'Api\NonRecurringSchedulesController@store');
Route::middleware('auth:api')->put('/non-recurring-schedules/{id}', 'Api\NonRecurringSchedulesController@update');
Route::middleware('auth:api')->delete('/non-recurring-schedules/{id}', 'Api\NonRecurringSchedulesController@destroy');


// Scheduled
Route::middleware('auth:api')->get('/schedules', 'Api\SchedulesController@generate');
Route::middleware('auth:api')->put('/schedules/status/{id}', 'Api\SchedulesController@updateStatus');
Route::middleware('auth:api')->get('/schedules/generated-dates/today', 'Api\SchedulesController@generatedDate');
Route::middleware('auth:api')->get('/schedules/generated/today', 'Api\SchedulesController@generatedSchedules');
