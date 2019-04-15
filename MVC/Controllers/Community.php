<?php

    class Community extends Controller
    {
        public function Index(){
            $this->view('Community/index');
        }

        public function Channel($channelRequested = null){
            //Get user information
            if(isset($_SESSION[username])){
                $currentUser = $this->model('UserModel')->getUserSafe($_SESSION[username]);
            }
            //Get the user's channels
            $this->view('Community/channel', ['channels' => $channels, 'user' => $currentUser]);
        }

        public function POST_Follow(){
            $follower_data = $_POST['follower_data'];
            //Set fields from JSON data and submit current obj to database
            $this->model('Follower')
            ->Set(json_decode($follower_data, true))
            ->Submit();
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