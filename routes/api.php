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
    Route::get('manifest/{AL}/{DT}/{Des}/show', 'Admin\ManifestController@show')->name('passenger.show');
    Route::get('passenger/{seat}/check', 'Admin\ManifestController@passengerCheck')->name('passenger.check');
    Route::get('ticket/{AssignLocation}/{Destination}/{DepartureTime}/manifest', 'Admin\BoardingController@manifest')->name('tickets.manifest');
    Route::get('tickets/{code}', 'Admin\BoardingController@tickets')->name('tickets.customer');
    Route::get('customer/{phone}', 'Admin\BoardingController@customer')->name('customer.customer');
    Route::get('ticket/{code}', 'Admin\BoardingController@show')->name('ticket.show');
    Route::get('seats/{to}/{time}', 'Admin\BoardingController@seats')->name('seats.show');
    Route::get('manifest/{time}/{AssLoc}/{to}/{departure}', 'Admin\ManifestController@manifest')->name('manifest.api.index');
});
