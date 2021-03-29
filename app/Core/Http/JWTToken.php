<?php

namespace App\Core\Http;
use Firebase\JWT\JWT;

class JWTToken
{
    public static function createUserToken($userData){


        $issuer_claim = "MVCAPP";
        $audience_claim = "USER";
        $issuedat_claim = time();
        $notbefore_claim = $issuedat_claim + 10;
        $expire_claim = $issuedat_claim + 60*60;
        $payload = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => [
                "id" => $userData->id,
                "name" => $userData->name
            ]
        );

        try {
            $jwt = JWT::encode($payload, config("JWT_KEY"));
            return $jwt;
        }catch(\Exception $e){
             echo $e;
        }
    }

    public static function validateToken($token){
        try {
           JWT::decode($token, config("JWT_KEY"),array('HS256'));
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}