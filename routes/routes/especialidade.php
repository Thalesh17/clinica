<?php

Route::group(['prefix' => 'especialidade'], function () {

    Route::get('/', 'EspecialidadeController@index');

    Route::get('/create', 'EspecialidadeController@create');

    Route::get('/edit/{especialidade}', 'EspecialidadeController@edit');

    Route::post('/store', 'EspecialidadeController@store');

    Route::post('/delete', 'EspecialidadeController@delete');
});