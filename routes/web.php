<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('user/create', 'PacienteController@cadastrarPaciente');
Route::post('user/createPaciente', 'PacienteController@storeUserPaciente');

Route::get('/', function (){
    return view('welcome');
});

Route::get('/chat', 'ChatController@index')->middleware('auth')->name('chat.index');
Route::get('/chat/{id}', 'ChatController@show')->middleware('auth')->name('chat.show');
Route::get('/chat/getChat/{id}', 'ChatController@getChat')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

//    Route::get('/', function (){
//       return view('layouts.default');
//    });

    Route::get('/tabelas-sistema', function(){
        return view('pages.tabelas-sistema.index');
    });

    require_once 'routes/configuracao.php';
    require_once 'routes/informativo.php';
    require_once 'routes/funcao.php';
    require_once 'routes/permissao.php';
    require_once 'routes/usuario.php';
    require_once 'routes/paciente.php';
    require_once 'routes/medico.php';
    require_once 'routes/sexo.php';
    require_once 'routes/especialidade.php';
    require_once 'routes/consulta.php';
    require_once 'routes/tipo_sanguineo.php';
});
