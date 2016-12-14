<?php

class Auth extends Controller {

    public function login_post() {
        var_dump($this->getPostBody());
    }
}