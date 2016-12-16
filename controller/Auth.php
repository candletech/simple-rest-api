<?php

class Auth extends Controller {

    public function login_post() {
        return JWTHelper::encode($this->getPostBody());
    }
}