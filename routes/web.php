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

Route::get('/', "ControladorLocalidades@index");
Route::post('/', "ControladorLocalidades@gestionar_accion");

//Route::get ('visualizar_datos',"ControladorMunicipios@index");
//Route::post('comunidades',"ControladorMunicipios@get_comunidades");
//Route::post('provincias',"ControladorMunicipios@get_provincias");
//Route::post('municipios',"ControladorMunicipios@get_municipios");
//Route::post('calles',"ControladorMunicipios@get_calles");
//Route::post('nucleos',"ControladorMunicipios@get_nucleos");

