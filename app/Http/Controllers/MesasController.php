<?php

namespace App\Http\Controllers;

use App\Mesas;
use Illuminate\Http\Request;

class MesasController extends Controller
{
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
