<?php

Route::group(['prefix' => 'permissao'], function () {

    Route::get('/', 'PermissaoController@index');

    Route::get('/create', 'PermissaoController@create');

    Route::post('/store', 'PermissaoController@store');

    Route::get('/edit/{permissao}', 'PermissaoController@edit');

    Route::get('/get-permissoes/{permissao}', 'PermissaoController@getPermissoes');

    Route::post('/destroy', 'PermissaoController@destroy');
});