<?php

class App {

    protected $controller = 'Home';
    protected $method = 'index';
    protected $request = 'get';
    protected $params = array();

    public function __construct() {
        header('Content-Type: application/json');

        $data = array();

        $url = $this->parseUrl();

        if(isset($url[0])) {
            $url[0] = ucfirst(strtolower($url[0]));
        }

        if(isset($url[1])) {
            $url[1] = strtolower($url[1]);
        }

        if(file_exists('controller/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once 'controller/' . $this->controller . '.php';

        $this->controller = new $this->controller;
        $this->request = strtolower($_SERVER['REQUEST_METHOD']);
        $this->method .= "_" .$this->request;

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1] . "_" .$this->request)) {
                $this->method = $url[1] . "_" .$this->request;
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : array();

        if(is_subclass_of($this->controller, 'AuthorizedController')) {
            $auth = call_user_func_array([$this->controller, 'isAuthorized'], $this->params);
            if($auth !== true) {
                $data["msg"] = $auth;
            }
        }

        if(count($data) == 0) {
            $data = (call_user_func_array([$this->controller, $this->method], $this->params));
        }

        die(json_encode((object)$data));
    }

    public function parseUrl() {
        return explode('/', filter_var(trim($_SERVER['PATH_INFO'], '/')), FILTER_SANITIZE_URL);
    }
}