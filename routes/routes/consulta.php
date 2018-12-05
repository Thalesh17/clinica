<?php

Route::group(['prefix' => 'consulta'], function () {

    Route::get('/', 'ConsultaController@index');

    Route::get('/create', 'ConsultaController@create');

    Route::get('/edit/{consulta}', 'ConsultaController@edit');

    Route::get('/informativo/user', 'ConsultaController@informativo');

    Route::get('/informativo/atendente', 'ConsultaController@informativoAtendente');

    Route::get('/export/excel', 'ConsultaController@exportarExcel');

    Route::get('/informativo', 'ConsultaController@informativoIndex');

    Route::get('/atendimento', 'ConsultaController@atendimento');

    Route::post('/deleteCday', 'ConsultaController@sendEmailConsulta');
    Route::post('/compareceu/{compareceu}', 'ConsultaController@compareceu');

    Route::get('/historico', 'ConsultaController@historicoMedico');

    Route::get('/get-medico', 'ConsultaController@getMedico');

    Route::get('/usuario', 'ConsultaController@consultasPaciente');

    Route::get('/getDates/{medico}', 'ConsultaController@getDate');

    Route::get('/getHorario/{data}/{medico}', 'ConsultaController@getHorario');

    Route::post('/store', 'ConsultaController@store');

    Route::post('/delete', 'ConsultaController@delete');
});