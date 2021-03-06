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

Route::group(['middleware' => 'auth:api'],function(){

    Route::get('/user', function (Request $request) {
        return $request->user()->first_name . ' ' . $request->user()->last_name  . ' ' . $request->user()->email ;
//        return auth()->guard('api')->user();
        return $request->user();
    });
    Route::post('/shipping', [
        'uses' => 'ShippingController@calcPrice',
        'as' => 'calcPrice',
    ]);
});
