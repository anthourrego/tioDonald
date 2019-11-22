<?php

namespace App\Http\Controllers;

use App\Mesas;
use Illuminate\Http\Request;

class MesasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mesas = Mesas::with('Piso')->get();
        return $mesas;
    }

    public function index2()
    {
        //
        $mesas = Mesas::with('Pedidos')->get();
        return $mesas;
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
     * @param  \App\Mesas  $mesas
     * @return \Illuminate\Http\Response
     */
    public function show(Mesas $mesas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mesas  $mesas
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesas $mesas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mesas  $mesas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesas $mesas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mesas  $mesas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesas $mesas)
    {
        //
    }

    /**
    * @OA\Get(
    *     path="/mesasPorPiso/{tiempoToken}/{piso}",
    *     description="Mesas por cada piso",
    *     operationId="mesasPorPiso",
    *     @OA\Parameter(
    *         name="tiempoToken",
    *         in="path",
    *         description="Tiempo del token",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="piso",
    *         in="path",
    *         description="Numero de piso",
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
    public function mesasPorPiso($tiempoToken, $piso){
        $mesas = Mesas::where("estado", 1)->where("idPiso", $piso)->get();

        if (!empty($mesas)) {
            $resp = array("success" => true,
                         "mensaje" => $mesas);
        }else{
            $resp = array("success" => false,
                          "mensaje" => "No hay datos");
        }
        return $resp;
    }
}
