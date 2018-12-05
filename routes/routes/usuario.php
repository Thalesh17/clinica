<?php

Route::group(['prefix' => 'usuario'], function () {

    Route::get('/', 'UsuarioController@index');

    Route::get('/create', 'UsuarioController@create');

    Route::post('/store', 'UsuarioController@store');

    Route::get('/edit/{usuario}', 'UsuarioController@edit');

    Route::get('/get-funcoes/{funcao}', 'UsuarioController@getFuncoes');

    Route::post('/destroy', 'UsuarioController@destroy');

    Route::get('/profile', 'UsuarioController@profile');

    Route::post('/profile/change', 'UsuarioController@changeProfile');
});