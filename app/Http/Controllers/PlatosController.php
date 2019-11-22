<?php

namespace App\Http\Controllers;

use App\platos;
use Illuminate\Http\Request;

class PlatosController extends Controller
{
    /**
    * @OA\get(
    *     path="/api/listaUsuarios",
    *     summary="listaUsuarios",
    *     @OA\Response(
    *         response=200,
    *         description="Se actualizan los datos del usuario logeado."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */


    /**
    * @OA\Get(
    *     path="/listaPlatos/{tiempoToken}",
    *     description="LIstar los platos",
    *     operationId="listaPlatos",
    *     @OA\Parameter(
    *         name="tiempoToken",
    *         in="path",
    *         description="Tiempo del token",
    *         required=false,
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
    *         description="Detalles platos."
    *     )
    * )
    */
    public function listaPlatos(){
        $platos = platos::where("estado", 1)->get();

        if (!empty($platos)) {
            $resp = array("success" => true,
                         "mensaje" => $platos);
        }else{
            $resp = array("success" => false,
                          "mensaje" => "No hay datos");
        }
        return $resp;
    }

    /**
    * @OA\Post(
    *     path="/crearPlato",
    *     description="Crear platos",
    *     operationId="crearPlato",
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         description="Nombre del plato",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Parameter(
    *         name="precio",
    *         in="path",
    *         description="Precio del plato",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="idCreador",
    *         in="path",
    *         description="Persona que creo el plato",
    *         required=false,
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
    *         description="Se ha creado el plato."
    *     )
    * )
    */
    public function crearPlato(Request $request){
        $validar = Platos::where('nombre', $request->nombre)->get();
        
        if($validar->isEmpty()){
            $plato = new Platos;
            $plato->nombre = $request->nombre;
            $plato->precio = $request->precio; 
            $plato->estado = 1;
            $plato->idCreador = $request->idCreador; 
            
            if($plato->save()){
                $resp = array("success" => true,
                              "mensaje" => "Se ha creado el plato");
            }else{
                $resp = array("success" => false,
                              "mensaje" => "No se ha creado el plato");
            }
            
        }else{
            $resp = array("success" => false,
                         "mensaje" => "Este nombre ya se encuentra en uso");
        }

        return $resp;
    }

    /**
    * @OA\Put(
    *     path="/actualizarPlato",
    *     description="Actualizar platos",
    *     operationId="actualizarPlato",
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         description="Nombre del plato",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Parameter(
    *         name="precio",
    *         in="path",
    *         description="Precio del plato",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Id del plato",
    *         required=false,
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
    *         description="El plato se ha actualizado."
    *     )
    * )
    */
    public function actualizarPlato(Request $request){
        $plato = Platos::find($request->id);

        if(!empty($plato)){
            $validar = Platos::where('nombre', $request->nombre)->where('id', '!=', $request->id)->get();
            if (count($validar) == 0) {
                $plato{'nombre'} = $request->nombre;
                $plato{'precio'} = $request->precio;
                if ($plato->save()) {
                    $resp = array("success" => true,
                            "mensaje" => "El plato se ha actualizado");
                }else{
                    $resp = array("success" => false,
                            "mensaje" => "El plato no se ha podido actualizar");
                }
            }else{
                $resp = array("success" => false,
                            "mensaje" => "Este nombre ya se encuentra en uso");
            }
        }else{
            $resp = array("success" => false,
                         "mensaje" => "No se ha encontrado el plato");
        }
        return $resp;
    } 

    /**
    * @OA\Put(
    *     path="/dashabilitatPlato",
    *     description="Deshabilitar plato",
    *     operationId="dashabilitatPlato",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Id del plato",
    *         required=false,
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
    *         description="PLato deshabilitado."
    *     )
    * )
    */
    public function dashabilitatPlato(Request $request){
        $plato = Platos::find($request->id);
        
        $plato{'estado'} = 0;

        if ($plato->save()) {
            $resp = array("success" => true,
                         "mensaje" => "Plato deshabilitado");
        }else{
            $resp = array("success" => false,
                         "mensaje" => "Error al deshabilitar el plato");
        }
        return $resp;
    } 

}
