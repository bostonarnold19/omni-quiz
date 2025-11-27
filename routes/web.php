<?php
use App\Http\Controllers\Auth\ChangePasswordController;

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
    Route::resource('mock-exam-result', 'Student\MockExamResultController');
    Route::resource('student-profile', 'Student\StudentProfileController');
    Route::resource('omni-questionnaire', 'Student\QuestionnaireController');

    Route::resource('group-question', 'Admin\GroupQuestionController');
    Route::resource('question', 'Admin\QuestionController');

    Route::resource('questionnaire-code', 'Admin\QuestionnaireCodeController');

    Route::resource('exam-mode', 'Student\ExamModeController');
    Route::resource('study-mode', 'Student\StudyModeController');


    Route::post('/study-mode-history/{questionId}/update', [
        'uses' => 'Student\StudyModeController@update',
    ]);

    Route::post('/study-mode-history/delete', [
        'uses' => 'Student\StudyModeController@destroy',
    ]);

    Route::match(['get', 'post'], '/import', 'HomeController@import')->name('import');


    Route::middleware(['auth'])->group(function () {
        Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('new-password.change');
        Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])->name('new-password.update');
    });


});

Route::post('/device', [
    'uses' => 'HomeController@device',
]);
Auth::routes();
