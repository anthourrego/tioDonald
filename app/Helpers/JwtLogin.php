<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\UnexpectedValueException;
use App\User;

class JwtLogin
{
    private $llaveSecreta = "qBN9nZ3BaQ";
    private $algoritmo = "HS256";

    public function generarToken($id, $name, $pass){
        $payload = array(
            'sub' => $id,
            //Usuario activo
            'usuario' => $name,
            'password' => $pass,
            //Tiempo de creacion del token
            'iat' => time(),
            //Tiempo de expiracion del token
            //'exp' => time() + ( 7 * 24 * 60 * 6 )
            'exp' => time() + ( 10 * 60 * 6 )
        );
        return JWT::encode($payload,$this->llaveSecreta, $this->algoritmo);
    }

    public function verificarToken($token, $decodificado = false){
        $auth = false;
        $payload = null;
        try{
            $payload = JWT::decode($token, $this->llaveSecreta, array($this->algoritmo));
            $auth = true;
        }catch (Exception $e){
            $auth = false;
        }catch (SignatureInvalidException $ex){
            $auth = false;
        }catch (UnexpectedValueException $ex){
            $auth = false;
        }
        if ($decodificado){
            return $payload;
        }else{
            return $auth;
        }
    }

}
