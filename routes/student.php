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
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student']
    ], function () {

    //==============================dashboard============================
    Route::get('/student/dashboard', function () {
        return view('pages.students.Dashboard.dashboard');
    });

    Route::group(['namespace' => 'Students\Dashboard'] , function () {
        Route::resource('Student_profile' , 'ProfileController');
        Route::post('student_profile/{id}' , 'ProfileController@update')->name('student.profile.update');
        Route::resource('student_quizz' , 'QuizzController');
        Route::resource('student_online_class' , 'ZommOnlineClassesController');
    }) ;

});
