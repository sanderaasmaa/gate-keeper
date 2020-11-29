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

Route::namespace('App\\Http\\Controllers\\')->group(function () {
    Route::get('services', 'ServiceController@list');
    Route::post('services/create', 'ServiceController@create');

    Route::get('customer/{customerId}/access/{serviceId}', 'ServiceController@canAccess');
    Route::patch('customer/{customerId}/access/{serviceId}', 'ServiceController@access');

    Route::post('service/{serviceId}/passes/create', 'ServicePassController@create');

    Route::post('assign', 'CustomerServicePassController@assign');

    Route::get('customers', 'CustomerController@list');
});
