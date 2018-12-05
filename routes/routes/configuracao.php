<?php

    Route::group(['prefix' => 'configuracao'], function () {

        Route::get('/', 'ConfiguracaoController@index');

        Route::post('/store', 'ConfiguracaoController@store');

    });