<?php

class AuthorizedController extends Controller {

    private function verifyAuthorization() {
        $token = apache_request_headers()['Authorization'];

        if(!JWTHelper::decode($token)) {
            throw new InvalidJwtException;
        }
    }

    public function isAuthorized() {
        try {
            $this->verifyAuthorization();
        } catch (Exception $e) {
            return "JWT Inválido";
        }

        return true;
    }
}