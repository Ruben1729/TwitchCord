<?php

    class API {

        public function SendJSON($data){
            header('Content-type: application/json');
            echo json_encode($data);
        }

    }