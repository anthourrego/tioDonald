<?php

namespace App\Http\Controllers;

use App\Pedidos;
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
     * @param  \App\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show(Pedidos $pedidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedidos $pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedidos $pedidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedidos $pedidos)
    {
        //
    }

    public function listaPedidos(){

        $pedido = DB::table('pedidos')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.id')
            ->join('pisos', 'mesas.idPiso', '=', 'pisos.id')
            ->select('pedidos.*', 'mesas.nroMesa', 'pisos.nroPiso')
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
