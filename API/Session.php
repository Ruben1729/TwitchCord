<?php

    class Session extends API{

        public function getSession(){
            session_start();
            $data = new stdClass();
            $data->user_id = isset($_SESSION['uid']) ? $_SESSION('uid'): NULL;
            $data->username = isset($_SESSION['username']) ? $_SESSION('username'): NULL;
            $this->SendJSON($data);
        }

    }