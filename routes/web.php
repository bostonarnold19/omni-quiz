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

    Route::post('/question/group/create', [
        'uses' => 'QuestionController@questionCreate',
        'as' => 'question.group.create',
    ]);

    Route::post('/question/create', [
        'uses' => 'QuestionController@addQuestion',
        'as' => 'question.create',
    ]);

    Route::post('/question/option/create', [
        'uses' => 'QuestionController@addQuestionOption',
        'as' => 'question.option.create',
    ]);

    Route::post('/add/user/question', [
        'uses' => 'QuestionController@addUserQuestion',
        'as' => 'add.user.question',
    ]);

    Route::patch('/question/group/update', [
        'uses' => 'QuestionController@questionUpdate',
        'as' => 'question.group.update',
    ]);

    Route::patch('/question/Update', [
        'uses' => 'QuestionController@updateQuestion',
        'as' => 'question.update',
    ]);

    Route::patch('/question/option/Update', [
        'uses' => 'QuestionController@updateQuestionOption',
        'as' => 'question.option.update',
    ]);

    Route::delete('/question/group/delete', [
        'uses' => 'QuestionController@questionDelete',
        'as' => 'question.group.delete',
    ]);

    Route::delete('/question/delete', [
        'uses' => 'QuestionController@deleteQuestion',
        'as' => 'question.delete',
    ]);

    Route::delete('/question/option/delete', [
        'uses' => 'QuestionController@deleteQuestionOption',
        'as' => 'question.option.delete',
    ]);

});

Auth::routes();
