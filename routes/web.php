<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();
Route::post('refresh-csrf',function(){return csrf_token();})->name('refresh-csrf');
Route::get('/logout','Auth\LoginController@logOut')->name('logout');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/empresastbl', 'App\Http\Controllers\HomeController@empresastbl')->name('empresastbl');
Route::get('/carterastbl', 'App\Http\Controllers\HomeController@carterastbl')->name('carterastbl');
Route::get('/evaluadorestbl', 'App\Http\Controllers\HomeController@evaluadorestbl')->name('evaluadorestbl');
Route::get('/audiostbl', 'App\Http\Controllers\HomeController@audiostbl')->name('audiostbl');


Route::get('/escucha','App\Http\Controllers\escuchaController@index')->name('escucha'); 
Route::get('/escuchadata','App\Http\Controllers\escuchaController@trae')->name('escuchadata'); 
Route::get('/grabastatus','App\Http\Controllers\escuchaController@grabastatus')->name('grabastatus'); 
Route::get('/evalcierre', 'App\Http\Controllers\escuchaController@evalcierre')->name('evalcierre');
Route::post('/ajaxagente', 'App\Http\Controllers\escuchaController@ajaxagente')->name('ajaxagente');
Route::post('/ajaxaudio', 'App\Http\Controllers\escuchaController@ajaxaudio')->name('ajaxaudio');
Route::post('/ajaxaudioevalua', 'App\Http\Controllers\escuchaController@ajaxaudioevalua')->name('ajaxaudioevalua');
Route::post('/ajaxaudioevaluagraba', 'App\Http\Controllers\escuchaController@ajaxaudioevaluagraba')->name('ajaxaudioevaluagraba');
Route::get('/ajaxtraeval', 'App\Http\Controllers\escuchaController@ajaxtraeval')->name('ajaxtraeval');
Route::post('/ajaxevaluatrae', 'App\Http\Controllers\escuchaController@ajaxevaluatrae')->name('ajaxevaluatrae');
Route::post('/ejecutacierre', 'App\Http\Controllers\escuchaController@ejecutacierre')->name('ejecutacierre');

Route::post('/ajaxagenteinfo', 'App\Http\Controllers\InformeController@ajaxagenteinfo') ->name ('ajaxagenteinfo');
Route::post('/ajaxbuscarinforme', 'App\Http\Controllers\InformeController@ajaxbuscarinforme') ->name ('ajaxbuscarinforme');
Route::get('/informes', 'App\Http\Controllers\InformeController@informes')->name('informes');

// cargas
Route::get('/cargas', 'App\Http\Controllers\CargasController@mostrarcargas')->name('cargas');
Route::post('/cargacmbcartera', 'App\Http\Controllers\CargasController@cargacmbcartera')->name('cargacmbcartera');
Route::post('/cargacmbpauta', 'App\Http\Controllers\CargasController@cargacmbpauta')->name('cargacmbpauta');
Route::post('/cargacmbagente', 'App\Http\Controllers\CargasController@cargacmbagente')->name('cargacmbagente');

Route::get('/cargaAgente', 'App\Http\Controllers\CargasController@cargaAgente')->name('cargaAgente');
Route::get('/getAgente', 'App\Http\Controllers\CargasController@getAgente')->name('getAgente');

Route::post('/asignaAgente', 'App\Http\Controllers\CargasController@asignaAgente')->name('asignaAgente');

Route::post('/getdataAgente', 'App\Http\Controllers\CargasController@getdataAgente')->name('getdataAgente');
Route::post('/creaAgente', 'App\Http\Controllers\CargasController@creaAgente')->name('creaAgente');
Route::post('/upexcelaudio', 'App\Http\Controllers\CargasController@upexcelaudio')->name('upexcelaudio');
