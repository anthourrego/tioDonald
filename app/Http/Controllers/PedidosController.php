<?php

namespace App\Http\Controllers;

use App\Pedidos;
use App\PedidosDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platos = Pedidos::with('platos', 'usuario')->where('idCreador', 2)->get();
        return $platos;
    }

    public function index2()
    {
        $platos = Pedidos::with('Mesa')->get();
        return $platos;
    }

    public function index3()
    {
        $platos = Pedidos::with('platos', 'usuario')->where('idCreador', 2)->get();
        return $platos;
    }

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
