<?php

    class Main extends Controller
    {
        public function Index(){
        	//$_SESSION[] == null -> SEND TO LOGIN
            $this->view('Main/index');
        }

    }

?>