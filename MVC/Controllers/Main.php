<?php

    class Main extends Controller
    {
        public function Index(){
            $data = [];
            $top_streamers = null;
            $data["top_streamers"] = $top_streamers;
            $this->view('Main/index', $data);
        }

    }

?>