<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\Helpers\JwtLogin;
use Illuminate\Http\JsonResponse;


/**
* @OA\Info(title="Proyecto Android Laravel", version="1.0")
*
* @OA\Server(url="http://127.0.0.1:8000/api")
*/

class UserController extends Controller
{
    /**
    * @OA\Get(
    *     path="/login/{nroDoc}/{pass}",
    *     description="Iniciar sesión",
    *     operationId="inicioSesion",
    *     @OA\Parameter(
    *         name="nroDoc",
    *         in="path",
    *         description="Numero de documento",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Parameter(
    *         name="pass",
    *         in="path",
    *         description="Contraseña inicio de sesion",
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
    *         description="Token del usuario."
    *     )
    * )
    */
    public function inicioSesion($nroDoc, $pass){
        $usuario = User::where(array(
           'nroDocumento' => $nroDoc,
            'password' => $pass
        ))->first();
        if (is_object($usuario)){
            $jwt = new JwtLogin();
            $token = $jwt->generarToken($usuario->id, $usuario->nroDocumento, $usuario->password);
            $validarToken = $jwt->verificarToken($token, true);
            return array(
                    'success' => true,
                    'token' => $token,
                    'tokenTiempo' => $validarToken,
                    'usuario' => $usuario
            );            
        }else {
            return array(
                'success' => false,
                'msg' => 'Datos incorrectos'
            );
        }
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::with('Permisos')->get();
        return $usuarios;
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
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function show(Pisos $pisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pisos $pisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pisos $pisos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pisos $pisos)
    {
        //
    }

    /**
    * @OA\Post(
    *     path="/crearUsuario",
    *     description="Iniciar sesión",
    *     operationId="crearUsuario",
    *     @OA\Parameter(
    *         name="nroDoc",
    *         in="path",
    *         description="Numero de documento",
    *         required=false,
    *         @OA\Schema(
    *             type="String",
    *         ),
    *         style="form"
    *     ),
    *     @OA\Parameter(
    *         name="nombres",
    *         in="path",
    *         description="Nombres del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="apellidos",
    *         in="path",
    *         description="Apellidos del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="telefonos",
    *         in="path",
    *         description="Telefono del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="idCreador",
    *         in="path",
    *         description="Creador",
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
    *         description="Se ha creado el usuario."
    *     )
    * )
    */
    public function crearUsuario(Request $request){
        $validar = User::where('nroDocumento', $request->nroDoc)->get();
        
        if($validar->isEmpty()){
            $usuario = new User;
            $usuario->nroDocumento = $request->nroDoc;
            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->telefono = $request->telefono;
            $usuario->password = $request->nroDoc;
            $usuario->estado = 1;
            $usuario->idCreador = $request->idCreador; 
            
            if($usuario->save()){
                $resp = array("success" => true,
                              "mensaje" => "Se ha creado el usuario");
            }else{
                $resp = array("success" => false,
                              "mensaje" => "No se ha creado el usuario");
            }
            
        }else{
            $resp = array("success" => false,
                         "mensaje" => "El número de documento ya se encuentra registrado");
        }

        return $resp;
    }

    /**
    * @OA\Put(
    *     path="/actualizarDatos",
    *     description="Iniciar sesión",
    *     operationId="actualizarDatos",
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         description="Nombres del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="apellidos",
    *         in="path",
    *         description="Apellidos del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="telefono",
    *         in="path",
    *         description="Telefono del usuario",
    *         required=false,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="id Usuario",
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
    *         description="Usuario actualizado correctamente."
    *     )
    * )
    */

    public function actualizarDatos(Request $request){
        $usuario = User::find($request->id);

        if(!is_null($usuario)){
            $usuario{'nombres'} = $request->nombre;
            $usuario{'apellidos'} = $request->apellidos;
            $usuario{'telefono'} = $request->telefono; 
            $usuario->save();
            $resp = array("success" => true,
                        "mensaje" => "Usuario actualizado correctamente");
        }else{
            $resp = array("success" => false,
                         "mensaje" => "No se ha encontrado el usuario");
        }

        return $resp;
    } 

    /**
    * @OA\Get(
    *     path="listaUsuarios/{tiempoToken}",
    *     description="Iniciar sesión",
    *     operationId="actualizarDatos",
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
    *         description="Datos usuarios."
    *     )
    * )
    */

    public function listaUsuarios(Request $request){
        $usuarios = User::where("estado", 1)->get();

        if (!empty($usuarios)) {
            $resp = array("success" => true,
                         "mensaje" => $usuarios);
        }else{
            $resp = array("success" => false,
                          "mensaje" => "No hay datos");
        }
        return $resp;
    } 

    /**
    * @OA\Put(
    *     path="/deshabilitarUsuario",
    *     description="Deshabilitar usuarios",
    *     operationId="deshabilitarUsuario",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Id del usuario",
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
    *         description="Usuario deshabilitado."
    *     )
    * )
    */

    public function deshabilitarUsuario(Request $request){
        $usuario = User::find($request->id);
        
        $usuario{'estado'} = 0;

        if ($usuario->save()) {
            $resp = array("success" => true,
                         "mensaje" => "Usuario deshabilitado");
        }else{
            $resp = array("success" => false,
                         "mensaje" => "Error al deshabilitar el usuario");
        }
        return $resp;
    } 

    public function validarToken(Request $request, $tiempoToken){
        $token = $request->header('Authorization', null);
        $tiempoToken = (int)$tiempoToken;
        
        if ($token != null){
            if(time() < $tiempoToken){
                $jwt = new JwtLogin();
                $tokenValido = $jwt->verificarToken($token);
                if ($tokenValido == true ){
                    return array(
                        'success' => true,
                        'mensaje' => 'Token valido',
                    );
                }else{
                    return array(
                        'success' => false,
                        'mensaje' => 'Token inválido',
                    );
                }
            }else{
                return array(
                    'success' => false,
                    'mensaje' => 'Sesión expirada',
                );
            }
            
        }else{
            return array(
                'success' => false,
                'mensaje' => 'Falta el token de autorización',
            );
        }
    }
}
