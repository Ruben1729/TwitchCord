<?php

    require_once "../MVC/Core/API.php";

    class APIError extends API{

        public function default(){
            $data = ['Error' => 'Bad endpoint requested'];
            $this->SendJson($data);
        }
    }