<?php

Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix')], function () {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['prefix' => config('backpack.base.route_prefix'), 'middleware' => 'admin'], function()
{
	Route::get('chart/{from}/{to}', 'ChartController@summary')->name('chart.summary');
	Route::post('update-info', 'UserController@updateInfo')->name('user.updateInfo');
	Route::get('report/summary/{AssignLocation}/{month}/{year?}', 'Admin\ReportController@pdfSummary')->name('report.pdf.summary');
	Route::get('report/daily/{AssignLocation}/{from}', 'Admin\ReportController@excelDaily')->name('report.excel.daily');
	Route::get('report/refund/{AssignLocation}/{from}', 'Admin\ReportController@excelRefund')->name('report.excel.refund');
	Route::get('report/manifest/{Destination}/{date}', 'Admin\ReportController@pdfManifest')->name('report.pdf.manifest');
	Route::get('report/create', 'Admin\ReportController@create')->name('report.create');
	Route::resource('manifest', 'Admin\ManifestController')->only(['index', 'store']);
	Route::resource('boarding', 'Admin\BoardingController');
	CRUD::resource('user','Admin\UserCrudController');
	CRUD::resource('departure_time','Admin\Departure_timeCrudController');
	CRUD::resource('assign_location','Admin\Assign_locationCrudController');
	CRUD::resource('work_time','Admin\Work_timeCrudController');
	CRUD::resource('destination','Admin\DestinationCrudController');
	CRUD::resource('employee','Admin\EmployeeCrudController');
	CRUD::resource('eod','Admin\EodCrudController');
	CRUD::resource('ticket','Admin\TicketCrudController');
	CRUD::resource('history-manifest','Admin\ManifestCrudController');
	Route::post('settings/assign_location', 'Admin\SettingsController@getWorkTime')->name('settings.get-work-time');
	Route::post('end-of-day', 'EODController@eod')->name('eod.submit');
	Route::post('end-of-day/approve', 'EODController@approve')->name('eod.approve');
	Route::post('end-of-day/pdf', 'Admin\ReportController@pdfEOD')->name('eod.pdf');
});
Route::get('/','pagesController@welcome');