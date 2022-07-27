<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Teacher;
use App\Models\Student;
/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {

        $ids = Teacher::findorfail(auth()->user()->id)->Sections()->pluck('section_id');
        $data['count_section'] = $ids->count();

        $data['student_count'] = Student::whereIn('section_id' , $ids)->count();

        return view('pages.Teachers.dashboard.dashboard' , $data);
    });

    Route::group(['namespace' => 'Teachers\Dashboard'], function () {
        //==============================students============================
    Route::get('student','StudentController@index')->name('student.index');
    Route::get('sections','StudentController@sections')->name('sections');
    Route::post('attendance','StudentController@attendance')->name('attendance');
    Route::post('edit_attendance','StudentController@editAttendance')->name('attendance.edit');
    Route::resource('teacher_quizzes' , 'QuizzController');
    Route::resource('teacher_questions' , 'QuestionController');
    Route::get('attendance_report','StudentController@attendanceReport')->name('attendence.report');
    Route::post('attendance_report','StudentController@attendanceSearch')->name('attendance.search');
    Route::resource('zoom_online_classes' , 'ZoomOnlineClassesController');
    Route::resource('profile' , 'ProfileController');
    Route::post('profile/{id}' , 'ProfileController@update')->name('profile_update');

    });

});
