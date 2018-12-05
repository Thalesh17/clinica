<?php

Route::group(['prefix' => 'paciente'], function () {

    Route::get('/', 'PacienteController@index');

    Route::get('/create', 'PacienteController@create');

    Route::get('/historico', 'PacienteController@historicoPaciente');

    Route::get('/export/excel', 'PacienteController@exportarExcel');

    Route::post('/store', 'PacienteController@store');

    Route::get('/show/{id}', 'PacienteController@show');

    Route::get('/edit/{paciente}', 'PacienteController@edit');

    Route::post('/destroy', 'PacienteController@destroy');
});