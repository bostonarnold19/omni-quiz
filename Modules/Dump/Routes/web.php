<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Dump\Http\Controllers'], function () {

    Route::resource('dump', 'DumpController');

});
