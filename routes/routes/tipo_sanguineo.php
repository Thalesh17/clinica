<?php

Route::group(['prefix' => 'tipo-sanguineo'], function () {

    Route::get('/', 'TipoSanguineoController@index');

    Route::get('/create', 'TipoSanguineoController@create');

    Route::post('/store', 'TipoSanguineoController@store');

    Route::get('/edit/{tipoSanguineo}', 'TipoSanguineoController@edit');

    Route::post('/delete', 'TipoSanguineoController@delete');
});