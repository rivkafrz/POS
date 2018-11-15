<?php

Route::group(['prefix' => 'app', 'middleware' => 'admin'], function()
{
	Route::resource('boarding', 'Admin\BoardingController');
	CRUD::resource('user','Admin\UserCrudController');
	CRUD::resource('departure_time','Admin\Departure_timeCrudController');
	// CRUD::resource('order','Admin\OrderCrudController');
	CRUD::resource('assign_location','Admin\Assign_locationCrudController');
	CRUD::resource('work_time','Admin\Work_timeCrudController');
	CRUD::resource('destination','Admin\DestinationCrudController');
	CRUD::resource('employee','Admin\EmployeeCrudController');
	Route::post('settings/assign_location', 'Admin\SettingsController@getWorkTime')->name('settings.get-work-time');
	Route::post('end-of-day', 'EODController@eod')->name('eod.submit');
});
Route::get('/','pagesController@welcome');