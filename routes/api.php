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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'api'], function() {
    Route::get('tickets/{code}', 'Admin\BoardingController@tickets')->name('tickets.customer');
    Route::get('customer/{phone}', 'Admin\BoardingController@customer')->name('customer.customer');
    Route::get('ticket/{code}', 'Admin\BoardingController@show')->name('ticket.show');
    Route::get('seats/{from}/{to}/{time}', 'Admin\BoardingController@seats')->name('seats.show');
});
