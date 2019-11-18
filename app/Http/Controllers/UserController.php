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
    public function inicioSesion(Request $request){
        $usuario = User::where(array(
           'nroDocumento' => $request->nroDoc,
            'password' => $request->pass
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

    public function validarToken(Request $request){
        $token = $request->header('Authorization', null);
        $tiempoToken = (int)$request->tiempoToken;
        
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
