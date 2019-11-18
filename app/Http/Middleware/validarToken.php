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
                        'mensaje' => 'Token inválido'
                    ),401);
                }
            }else{
                return new JsonResponse(array(
                    'success' => false,
                    'mensaje' => 'Sesión expirada'
                ),401);
            }
            
        }else{
            return new JsonResponse(array(
                'success' => false,
                'mensaje' => 'Falta el token de autorización'
            ),401);
        }
    }
}
