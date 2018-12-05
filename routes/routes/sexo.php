<?php

Route::group(['prefix' => 'sexo'], function () {

    Route::get('/', 'SexoController@index');

    Route::get('/create', 'SexoController@create');

    Route::post('/store', 'SexoController@store');

    Route::get('/edit/{sexo}', 'SexoController@edit');

    Route::post('/delete', 'SexoController@delete');
});