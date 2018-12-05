<?php

Route::group(['prefix' => 'medico'], function () {

    Route::get('/', 'MedicoController@index');

    Route::get('/create', 'MedicoController@create');

    Route::get('/show/{id}', 'MedicoController@show');

    Route::get('/export/excel', 'MedicoController@exportarExcel');

    Route::get('/calendario', 'MedicoController@showCalendario');

    Route::get('/getCalendario', 'MedicoController@getCalendario');

    Route::post('/store', 'MedicoController@store');

    Route::get('/edit/{medico}', 'MedicoController@edit');

    Route::post('/delete', 'MedicoController@delete');
});