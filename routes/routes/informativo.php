<?php

Route::group(['prefix' => 'informativo'], function () {

    Route::get('/getDayConsultas', 'InformativoController@getDayConsultas');
    Route::get('/getYearConsultas', 'InformativoController@getYearConsultas');

});