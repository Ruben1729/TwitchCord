<?php

    class APIError extends API{

        public function defaultError(){
            $data = ['Error' => 'Bad endpoint requested'];
            $this->SendJson($data);
        }
    }