<?php

namespace App\Http\Controllers;

use App\Pedidos;
use App\PedidosDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PedidosController extends Controller
{

    /**
    * @OA\Get(
    *     path="/listaPedidos/{tiempoToken}",
    *     description="Lista de pedidos",
    *     operationId="listaPedidos",
    *     @OA\Parameter(
    *         name="tiempoToken",
    *         in="path",
    *         description="Tiempo del token",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Id del pedido."
    *     )
    * )
    */
    public function listaPedidos(){

        $pedido = DB::table('pedidos')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.id')
            ->join('pisos', 'mesas.idPiso', '=', 'pisos.id')
            ->join('users', 'pedidos.idCreador', '=', 'users.id')
            ->select('pedidos.*', 'mesas.nroMesa', 'pisos.nroPiso', 'users.nombres', 'users.apellidos')
            ->where('pedidos.estado', 1)
            ->get();

        if (!$pedido->isEmpty()) {
            $resp = array("success" => true,
                        "mensaje" => $pedido);
        }else{
            $resp = array("success" => false,
                        "mensaje" => "No se encontraron datos");
        }
        return $resp;
    }

    /**
    * @OA\Put(
    *     path="/pagarPedido",
    *     description="Pagar pedido",
    *     operationId="pagarPedido",
    *     @OA\Parameter(
    *         name="idPedido",
    *         in="path",
    *         description="Id del pedido",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuario deshabilitado."
    *     )
    * )
    */

    public function pagarPedido(Request $request){
        $pago = Pedidos::find($request->idPedido);
        
        $pago{'estado'} = 0;

        if ($pago->save()) {
            $resp = array("success" => true,
                         "mensaje" => "Pago completado");
        }else{
            $resp = array("success" => false,
                         "mensaje" => "Error al realizar el pago");
        }
        return $resp;
    }

    
    /**
    * @OA\Delete(
    *     path="/eliminarPedido",
    *     description="Eiminar pedido",
    *     operationId="eliminarPedido",
    *     @OA\Parameter(
    *         name="idPedido",
    *         in="path",
    *         description="id del pedido",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Se ha eliminado el pedido."
    *     )
    * )
    */

    public function eliminarPedido(Request $request){
        $pedido = Pedidos::find($request->idPedido);
        $pedidosDetalle = PedidosDetalle::where('idPedido', $request->idPedido)->get();

        if(!empty($pedido)){
            if(!empty($pedidosDetalle)){
                PedidosDetalle::where('idPedido', $request->idPedido)->delete();
            }

            if($pedido->delete()){
                $resp = array("success" => true,
                                 "mensaje" => "Se ha eliminado el pedido");
            }else{
                $resp = array("success" => false,
                                 "mensaje" => "No se ha eliminado");
            }

        }else{
            $resp = array("success" => false,
                    "mensaje" => "Este nro de pedido no existe");
        }
        
        return $resp;

    }


    /**
    * @OA\Post(
    *     path="/crearPedido",
    *     description="Crear pedido",
    *     operationId="crearPedido",
    *     @OA\Parameter(
    *         name="idMesa",
    *         in="path",
    *         description="Id mesa",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Parameter(
    *         name="idCreador",
    *         in="path",
    *         description="Id creador pedido",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Id del pedido."
    *     )
    * )
    */
    public function crearPedido(Request $request){
        $pedido = new Pedidos;
        $pedido->idMesa = $request->idMesa;
        $pedido->estado = 1;
        $pedido->idCreador = $request->idCreador;

        if($pedido->save()){
            $resp = array("success" => true,
                            "mensaje" => $pedido->id);
        }else{
            $resp = array("success" => false,
                            "mensaje" => "No se ha creado el usuario");
        }

        return $resp;
    }
}
