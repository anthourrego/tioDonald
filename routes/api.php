<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['guest'])->group(function () {
    Route::get('login/{nroDoc}/{pass}', 'UserController@inicioSesion');
    Route::get('validarToken/{tiempoToken}', 'UserController@validarToken');
});

Route::middleware('token')->group(function () {
    Route::get('mesas', 'MesasController@index');   
    /*Route::get('/', 'Auth\LoginController@mostrarLogin')->name('mostrarLogin');
    Route::post('login', 'Auth\LoginController@login')->name('login');*/

});
