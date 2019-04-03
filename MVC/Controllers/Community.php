<?php

    class Community extends Controller
    {
        public function Index(){
            $this->view('Community/index');
        }

        public function POST_ChannelList(){
            //get the channel name searched for, null for top
            $channel = isset($_POST["channel_name"]) ? $_POST["channel_name"] : null;
            
            $this->view('Community/list');
        }
    }

?>
