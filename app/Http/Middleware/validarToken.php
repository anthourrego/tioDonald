<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use App\Helpers\JwtLogin;
use Illuminate\Http\JsonResponse;

class validarToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization', null);
        $tiempoToken = (int)$request->tiempoToken;
        
        if ($token != null){
            if(time() < $tiempoToken){
                $jwt = new JwtLogin();
                $tokenValido = $jwt->verificarToken($token);
                if ($tokenValido == true ){
                    return $next($request);
                }else{
                    return new JsonResponse(array(
                        'success' => false,
                        'token' => true,
                        'mensaje' => 'Token inválido'
                    ),200);
                }
            }else{
                return new JsonResponse(array(
                    'success' => false,
                    'token' => true,
                    'mensaje' => 'Sesión expirada'
                ),200);
            }
            
        }else{
            return new JsonResponse(array(
                'success' => false,
                'token' => true,
                'mensaje' => 'Falta el token de autorización'
            ),200);
        }
    }
}
