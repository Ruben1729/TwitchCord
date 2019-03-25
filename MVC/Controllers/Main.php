<?php

    class Main extends Controller
    {
        public function Index(){
            //$_SESSION[] == null -> SEND TO LOGIN
            $_SESSION['test'] = 'test';
            $this->view('Main/index');
        }

    }

?>