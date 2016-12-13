<?php

class App {

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = array();

    public function __construct() {
        $url = $this->parseUrl();
        $url[0] = ucfirst($url[0]);

        if(file_exists('controller/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once 'controller/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : array();

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        return explode('/', filter_var(trim($_SERVER['PATH_INFO'], '/')), FILTER_SANITIZE_URL);
    }
}