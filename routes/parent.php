<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent']
    ], function () { 

        Route::get('/parent/dashboard', function () {
            return view('pages.Parents.Dashboard.dashboard');
        });

        Route::group(['namespace' => 'Parent\Dashboard'] , function () { 
            Route::resource('parent' , 'ParentController');
            Route::post('attendance.Search' , 'ParentController@attendanceSearch')->name('attendance.search');
            Route::post('parent_profile_confirm/{id}' , 'ParentController@edit')->name('parent_profile_confirm');
            Route::post('parent_profile_update/{id}' , 'ParentController@update')->name('parent_profile_update');
            Route::get('sons_exams_results' , 'ParentController@sons_exams_results')->name('sons_exams_results');
        });


    });