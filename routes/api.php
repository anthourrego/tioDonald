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
    

    //Controlador de usuario
    Route::put('actualizarDatos', 'UserController@actualizarDatos');
    
    Route::get('listaUsuarios/{tiempoToken}', 'UserController@listaUsuarios');
    Route::put('deshabilitarUsuario', 'UserController@deshabilitarUsuario');

    //Controlador de platos
    Route::get('listaPlatos/{tiempoToken}', 'PlatosController@listaPlatos');
    Route::post('crearPlato', 'PlatosController@crearPlato');
    Route::put('actualizarPlato', 'PlatosController@actualizarPlato');
    Route::put('dashabilitatPlato', 'PlatosController@dashabilitatPlato');

    //Controlador de pisos
    Route::get('listaPisos/{tiempoToken}', 'PisosController@listaPisos');
    /*Route::get('/', 'Auth\LoginController@mostrarLogin')->name('mostrarLogin');
    Route::post('login', 'Auth\LoginController@login')->name('login');*/

});
