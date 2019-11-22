<?php

namespace App\Http\Controllers;

use App\Pisos;
use Illuminate\Http\Request;

class PisosController extends Controller
{
    /**
    * @OA\Get(
    *     path="/listaPisos/{tiempoToken}",
    *     description="Listar los pisos",
    *     operationId="listaPisos",
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Datos pisos."
    *     )
    * )
    */
    public function listaPisos(){
        $pisos = Pisos::where("estado", 1)->get();

        if (!empty($pisos)) {
            $resp = array("success" => true,
                         "mensaje" => $pisos);
        }else{
            $resp = array("success" => false,
                          "mensaje" => "No hay datos");
        }
        return $resp;
    }
}
