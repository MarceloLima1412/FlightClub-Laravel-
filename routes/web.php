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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'verify' => true]);

//Route::get('/password/reset', 'Auth\PasswordController@postEmail');

Route::group(['middleware' => ['auth', 'verified','ativo']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/password','UserController@alterarSenha')->name('password.change');
    Route::patch('/password','UserController@guardarSenha')->name('update.password');

    //---SOCIOS---//
    Route::patch('/socios/{socio}/quota', 'UserController@quota')->name('socios.quota');
    Route::patch('/socios/reset_quotas', 'UserController@reset_quotas')->name('socios.reset_quotas');
    Route::patch('/socios/{socio}/ativo', 'UserController@ativar')->name('socios.ativar');
    Route::patch('/socios/desativar_sem_quotas', 'UserController@desativa_sem_quotas')->name('socios.desativa_sem_quotas');

    Route::patch('/socios/{socio}/send_reactivate_mail','UserController@send_reactivate_email')->name('socios.send');

    Route::get('/pilotos/{piloto}/certificado', 'UserController@mostraCertificado')->name('socios.mostraCertificado');
    Route::get('/pilotos/{piloto}/licenca', 'UserController@mostraLicenca')->name('socios.mostraLicenca');

    Route::resource('socios', 'UserController')->except('show');





    Route::resource('aeronaves', 'AeronaveController', ['parameters'=>['aeronaves'=>'aeronave']])->except('show');
    Route::patch('/movimentos/{movimento}/confirmar','MovimentoController@confirmar')->name('movimentos.confirmar');
    Route::get('/movimentos/estatisticas','MovimentoController@estatisticas')->name('movimentos.estatisticas');
    Route::get('/pendentes','MovimentoController@pendentes')->name('movimentos.pendentes');
    Route::resource('movimentos','MovimentoController')->except('show');
 
    Route::get('/aeronaves/{aeronave}/pilotos','AeronaveController@pilotosAut')->name('aeronaves.pilotosAut');
    Route::get('/aeronaves/{aeronave}/pilotosNA','AeronaveController@pilotosNAut')->name('aeronaves.pilotosNAut');
    Route::post('/aeronaves/{aeronave}/pilotos/{piloto}','AeronaveController@addPiloto')->name('aeronaves.addPiloto');
    Route::delete('/aeronaves/{aeronave}/pilotos/{piloto}','AeronaveController@removePiloto')->name('aeronaves.removePiloto');
    Route::get('/tiposlicencas', 'TipoLicencaController@index')->name('tiposlicencas.index');
    Route::get('/tiposlicencasadd','TipoLicencaController@create')->name('tiposlicencas.create');
    Route::post('tiposlicencasstore', 'TipoLicencaController@store')->name('tiposlicencas.store');

  /*  Route::get('/aeronaves/{aeronave}/pilotos','AeronaveController@addPilotos')->name('aeronaves_pilotos');
    Route::get('/aeronaves/{aeronave}/pilotos','AeronaveController@removePilotos')->name('aeronaves_pilotos');*/

/*Route::get('aeronave', 'AeronaveController@index')->name('aeronave.index');
Route::get('aeronave/create', 'AeronaveController@create')->name('aeronave.create');
Route::post('aeronave', 'AeronaveController@store')->name('aeronave.store');
Route::get('aeronave/{aeronave}/edit', 'AeronaveController@edit')->name('aeronave.edit');
Route::put('aeronave/{aeronave}', 'AeronaveController@update')->name('aeronave.update');
Route::delete('aeronave/{aeronave}', 'AeronaveController@destroy')->name('aeronave.destroy');
*/
}
);