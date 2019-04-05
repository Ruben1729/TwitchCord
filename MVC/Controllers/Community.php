<?php

    class Community extends Controller
    {
        public function Index(){
            //get the channel name searched for, null for top
            $channel = isset($_POST["channel_name"]) ? $_POST["channel_name"] : 'No Channel'; 
            $currentUser = null;
            if(isset($_SESSION[username])){
                $currentUser = $this->model('UserModel')->getProfile($_SESSION[username]);
            }
            var_dump($currentUser);
            $data['channel_name'] = $channel;
            $data['user'] = json_encode($currentUser);

            $this->view('Community/index', $data);
        }

        public function ChannelList(){
            $this->view('Community/list');
        }

        public function POST_ChannelList(){
            $this->view('Community/list');
        }
    }