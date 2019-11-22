<?php

namespace App\Http\Controllers;

use App\PedidosDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PedidosDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PedidosDetalle  $pedidosDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(PedidosDetalle $pedidosDetalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PedidosDetalle  $pedidosDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(PedidosDetalle $pedidosDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PedidosDetalle  $pedidosDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PedidosDetalle $pedidosDetalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PedidosDetalle  $pedidosDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedidosDetalle $pedidosDetalle)
    {
        //
    }

    public function PedidoDetallePlatos($tiempoToken, $idPedido){
        $pedido = DB::table('pedidos_detalles')
            ->join('platos', 'pedidos_detalles.idPlato', '=', 'platos.id')
            ->select('pedidos_detalles.*', 'platos.nombre')
            ->where('idPedido', $idPedido)
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

    public function eliminarPlatoDetalle(Request $request){
        $detalle = PedidosDetalle::find($request->idDetalle);

        if (!empty($detalle)) {
            if ($detalle->delete()) {
                $resp = array("success" => true, "mensaje" => "Se ha eliminado");
            }else{
                $resp = array("success" => false, "mensaje" => "Error al eliminar");
            }
            
        }else{
            $resp = array("success" => false, "mensaje" => "No se encontro el plato");
        }

        return $resp;
    }

    public function crearDetalle(Request $request){
        $detalle = new PedidosDetalle;

        $detalle->idPedido = $request->idPedido;
        $detalle->idPlato = $request->idPlato;
        $detalle->precio = $request->precio;
        $detalle->estado = 0;
        $detalle->idCreador = $request->idCreador;

        if ($detalle->save()) {
            $resp = array("success" => true,
                        "mensaje" => "Se ha agregado");
        }else{
            $resp = array("success" => false,
                         "mensaje" => "No de ha añadido");
        }

        return $resp;
    }
}
