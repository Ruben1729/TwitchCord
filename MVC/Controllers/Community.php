<?php

    class Community extends Controller
    {
        public function Index(){
            $this->view('Community/index');
        }

        public function Channel(){
            //Get channel/group_chat/user information and transfer it to JSON
            if(isset($_SESSION[username])){
                $currentUser = $this->model('UserModel')->getUserSafe($_SESSION[username]);
                $currentUser = json_encode($currentUser);
            }

            $channels = $this->model('ChannelModel')->getAllChannels();
            $first_channel_id = $channels[0]->channel_id;
            $channels = json_encode($channels);

            $group_chats = $this->model('GroupChat')->getGroupChats($first_channel_id);
            $group_chats = json_encode($group_chats);

            $this->view('Community/channel', ['channels' => $channels, 'user' => $currentUser, 'group_chats' => $group_chats]);
        }

        public function POST_Follow(){
            $follower_data = $_POST['follower_data'];
            //Set fields from JSON data and submit current obj to database
            $this->model('Follower')
            ->Set(json_decode($follower_data, true))
            ->Submit();
        }

        public function ChannelList(){
            $channel_name = $_GET['channel_name'];

            $channels = $this
                ->model('ChannelModel')
                ->getChannels($channel_name);
            
            header('Content-Type: application/json');
            echo json_encode($channels);
        }

        public function POST_ChannelList(){
            $this->view('Community/list');
        }
    }