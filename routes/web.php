<?php

Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix')], function () {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'app', 'middleware' => 'admin'], function()
{
	Route::resource('boarding', 'Admin\BoardingController');
	CRUD::resource('user','Admin\UserCrudController');
	CRUD::resource('departure_time','Admin\Departure_timeCrudController');
	CRUD::resource('assign_location','Admin\Assign_locationCrudController');
	CRUD::resource('work_time','Admin\Work_timeCrudController');
	CRUD::resource('destination','Admin\DestinationCrudController');
	CRUD::resource('employee','Admin\EmployeeCrudController');
	CRUD::resource('eod','Admin\EodCrudController');
	Route::post('settings/assign_location', 'Admin\SettingsController@getWorkTime')->name('settings.get-work-time');
	Route::post('end-of-day', 'EODController@eod')->name('eod.submit');
	Route::post('end-of-day/approve', 'EODController@approve')->name('eod.approve');
});
Route::get('/','pagesController@welcome');