<?php

    class App{

        protected $controller = 'Main';
        protected $method = 'Index';
        protected $params = [];
        
        public function __construct()
        {
            $url = $this->parseUrl();

            if(file_exists('../MVC/Controllers/' . $url[0] . '.php')){
                $this->controller = $url[0];
                unset($url[0]);
            }

            require_once '../MVC/Controllers/' . $this->controller . '.php';
            
            $this->controller = new $this->controller;
            
            if(isset($url[1]) && method_exists($this->controller, $url[1])){
                $type = $_SERVER['REQUEST_METHOD'] == 'GET' ?   '' : $_SERVER['REQUEST_METHOD'] . '_';
                $this->method = $type.$url[1];
                unset($url[1]);
            }

            //if the url is empty, the array values will be null
            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->controller, $this->method], $this->params);
        }

        public function parseUrl(){
            if(isset($_GET['url'])){
                return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
        }
    }