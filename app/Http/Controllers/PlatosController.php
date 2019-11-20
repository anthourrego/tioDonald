<?php

namespace App\Http\Controllers;

use App\platos;
use Illuminate\Http\Request;

class PlatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = platos::with('pedidos')->get();
        return $pedidos;
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
     * @param  \App\platos  $platos
     * @return \Illuminate\Http\Response
     */
    public function show(platos $platos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\platos  $platos
     * @return \Illuminate\Http\Response
     */
    public function edit(platos $platos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\platos  $platos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, platos $platos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\platos  $platos
     * @return \Illuminate\Http\Response
     */
    public function destroy(platos $platos)
    {
        //
    }

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
    * @OA\put(
    *     path="/api/crearPlato",
    *     summary="crearPlato",
    *     @OA\Response(
    *         response=200,
    *         description="Se va crear el usuario."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
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
    * @OA\put(
    *     path="/api/actualizarPlato",
    *     summary="actualizarPlato",
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
    * @OA\put(
    *     path="/api/dashabilitatPlato",
    *     summary="dashabilitatPlato",
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
