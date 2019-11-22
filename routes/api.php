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
    Route::post('crearUsuario', 'UserController@crearUsuario');
    Route::get('listaUsuarios/{tiempoToken}', 'UserController@listaUsuarios');
    Route::put('deshabilitarUsuario', 'UserController@deshabilitarUsuario');

    //Controlador de platos
    Route::get('listaPlatos/{tiempoToken}', 'PlatosController@listaPlatos');
    Route::post('crearPlato', 'PlatosController@crearPlato');
    Route::put('actualizarPlato', 'PlatosController@actualizarPlato');
    Route::put('dashabilitatPlato', 'PlatosController@dashabilitatPlato');

    //Controlador de pisos
    Route::get('listaPisos/{tiempoToken}', 'PisosController@listaPisos');

    //Controlador de mesas
    Route::get('mesasPorPiso/{tiempoToken}/{piso}', 'MesasController@mesasPorPiso');

    //Controlador de pedido
    Route::post('crearPedido', 'PedidosController@crearPedido');
    Route::get('listaPedidos/{tiempoToken}', 'PedidosController@listaPedidos');
    Route::delete('eliminarPedido', 'PedidosController@eliminarPedido');
    Route::put('pagarPedido', 'PedidosController@pagarPedido');

    //Controlador de PedidosDetalle
    Route::post('crearDetalle', 'PedidosDetalleController@crearDetalle');
    Route::get('PedidoDetallePlatos/{tiempoToken}/{idPedido}', 'PedidosDetalleController@PedidoDetallePlatos');
    Route::delete('eliminarPlatoDetalle', 'PedidosDetalleController@eliminarPlatoDetalle');
    /*Route::get('/', 'Auth\LoginController@mostrarLogin')->name('mostrarLogin');
    Route::post('login', 'Auth\LoginController@login')->name('login');*/

});
