<?php

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

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [
        'uses' => 'HomeController@index',
        'as' => 'dashboard',
    ]);

    Route::get('/codes', [
        'uses' => 'Student\QuestionnaireController@index',
        'as' => 'codes',
    ]);

    Route::resource('result', 'Student\ResultController');
    Route::resource('student-profile', 'Student\StudentProfileController');
    Route::resource('omni-questionnaire', 'Student\QuestionnaireController');

    Route::resource('group-question', 'Admin\GroupQuestionController');
    Route::resource('question', 'Admin\QuestionController');

    Route::resource('questionnaire-code', 'Admin\QuestionnaireCodeController');

    Route::resource('exam-mode', 'Student\ExamModeController');
    Route::resource('study-mode', 'Student\StudyModeController');

    Route::match(['get', 'post'], '/import', 'HomeController@import')->name('import');

});

Auth::routes();
