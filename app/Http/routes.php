<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect('/login');
    } else {
        return redirect('/app');
    }
});

Route::auth();

//Route::get('/home', 'HomeController@index');

Route::get('/app', 'TerminalController@index');
Route::get('app/{path?}', 'TerminalController@index')->where('path', '.+');

Route::group(['namespace' => 'Api', 'prefix' => 'api'], function () {
    Route::resource('employees', 'EmployeeController');
    Route::post('employees/{employee}/register', 'EmployeeController@register');
    Route::resource('jobs', 'JobController');
    Route::resource('locations', 'LocationController');

    // Terminal Routes
    Route::post('terminal/clock', 'TerminalController@clock');
    Route::get('terminal/timecards', 'TerminalController@timecards');
    Route::get('terminal/clocked-in', 'TerminalController@clockedInEmployees');
    Route::get('terminal/shifts', 'TerminalController@ongoingShifts');
    Route::post('terminal/shifts/{id}/end', 'TerminalController@endShift');
});
