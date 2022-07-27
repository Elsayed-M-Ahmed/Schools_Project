<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Grades\ClassroomController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\QuestionController;
// use App\Http\Controllers\Students\SettingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth::routes();

Route::get('/', 'HomeController@index')->name('selection');


Route::group(['namespace' => 'Auth'], function () {

Route::get('/login/{type}','LoginController@loginForm')->middleware('guest')->name('login.show');

Route::post('/login','LoginController@login')->name('login');

Route::get('/logout/{type}', 'LoginController@logout')->name('logout');

});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'auth' ]
    ], function(){
        
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

        

        Route::group(['namespace' => 'Grades'] , function() {
            Route::resource('/grade', 'GradeController');
        });

        Route::group(['namespace' => 'Classrooms'] , function() {
            Route::resource('/Classrooms', 'ClassroomController');
            Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');
            Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
        });


        
        Route::group(['namespace' => 'Sections'] , function() {
            Route::resource('/Sections', 'SectionController');
            Route::get('/classes/{id}', 'SectionController@getclasses');

        });


        route::view('add_parent' , 'livewire.show_form')->name('add_parent');

        Route::group(['namespace' => 'Teachers'], function () {
            Route::resource('/Teachers', 'TeacherController');
        });

        Route::group(['namespace' => 'Students'], function () {
            Route::resource('Students', 'StudentsController');
            Route::resource('Graduated', 'GraduatedController');
            Route::resource('Fees', 'FeesController');
            Route::resource('receipt_students', 'ReceiptStudentsController');
            Route::resource('ProcessingFee', 'ProcessingFeeController');
            Route::resource('Payment_students', 'PaymentController');
            Route::resource('Attendance', 'AttendanceController');
            Route::resource('Promotion', 'PromotionController');
            Route::resource('online_classes', 'OnlineClasseController');
            Route::resource('library', 'LibraryController');
            Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');

            Route::post('/Upload_attachment', 'StudentsController@Upload_attachment')->name('Upload_attachment');
            Route::get('Download_attachment/{studentsname}/{filename}/{student_id}', 'StudentsController@Download_attachment')->name('Download_attachment');
            Route::post('/Delete_attachment', 'StudentsController@Delete_attachment')->name('Delete_attachment');
            
           
        });

        Route::group(['namespace' => 'Fees'], function () {
            Route::resource('Fees', 'FeesController');
            Route::resource('Fees_Invoices', 'FeeInvoicesController');
        });

        Route::group(['namespace' => 'Subjects'], function () {
            Route::resource('subjects', 'SubjectController');
        });

        Route::group(['namespace' => 'Exams'], function () {
            Route::resource('Exams', 'ExamController');
        });

        Route::group(['namespace' => 'Quizzes'], function () {
            Route::resource('Quizzes', 'QuizzesController');
        });

        Route::group(['namespace' => 'questions'], function () {
            Route::resource('questions', 'QuestionController');
            // Route::get('/questions/index/{id}', [QuestionController::class, 'index'])->name('index');
            Route::get('/get_questions/{id}', 'QuestionController@get_questions')->name('get_questions');
        });

        Route::group(['namespace' => 'Setting'], function () {
            Route::resource('settings', 'SettingController');
        });

        
    });



