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
* @OA\Server(url="http://192.168.0.9:8000")
*/

class UserController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/login",
    *     summary="Inicar sesion",
    *     @OA\Response(
    *         response=200,
    *         description="Iniciar sesion."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
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
    * @OA\put(
    *     path="/api/crearUsuario",
    *     summary="crearUsuario",
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
    * @OA\put(
    *     path="/api/actualizarDatos",
    *     summary="actualizarDatos",
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
    * @OA\put(
    *     path="/api/dehabilitarUsuario",
    *     summary="dehabilitarUsuario",
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
