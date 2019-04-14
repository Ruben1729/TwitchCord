<?php

    class Community extends Controller
    {
        public function Index(){
            $this->view('Community/index');
        }

        public function Channel($channel){
            //TODO: Check if channel and user exists 
            $channel = null;
            if(isset($_POST["channel_name"])){
                $channel = $this->model('ChannelModel')->getChannel($_POST['channel_name']);
            }
            $currentUser = null;
            if(isset($_SESSION[username])){
                $currentUser = $this->model('UserModel')->getUserSafe($_SESSION[username]);
            }

            $data['channel'] = $channel;
            $data['user'] = $currentUser;

            $this->view('Community/channel', $data);
        }

        public function ChannelList($username){
            $channels = $this
            ->model('ChannelModel')
            ->getChannels($username);
            
            header('Content-Type: application/json');
            echo json_encode($channels);
        }

        public function POST_ChannelList(){
            $this->view('Community/list');
        }
    }