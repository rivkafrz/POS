<?php

Route::group(['prefix' => 'app', 'middleware' => 'admin'], function()
{
	CRUD::resource('user','Admin\UserCrudController');
	CRUD::resource('departure_time','Admin\Departure_timeCrudController');
	CRUD::resource('order','Admin\OrderCrudController');
	CRUD::resource('assign_location','Admin\Assign_locationCrudController');
	CRUD::resource('work_time','Admin\work_timeCrudController');
	CRUD::resource('destination','Admin\destinationCrudController');
	CRUD::resource('employee','Admin\employeeCrudController');
	Route::post('settings/assign_location', 'Admin\SettingsController@getWorkTime')->name('settings.get-work-time');
});
Route::get('/','pagesController@welcome');
