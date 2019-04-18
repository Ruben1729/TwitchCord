<?php

class Community extends Controller
{
    public function Index()
    {
        $this->view('Community/index');
    }

    public function Channel()
    {
        $this->view('Community/channel');
    }

    //Bad name, but get User, channel and group chats
    public function GetInformation()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION[username])) {
            echo json_encode('{error: "No user is logged in"}');
            return;
        }

        //Setup generic object to hold information
        $info = new stdClass();
        //Retrieve information
        $info->user = $this->model('UserModel')->getProfile($_SESSION[username]);
        //Get the channels for the current user
        $info->channels = $this->model('ChannelModel')->getUsersChannels($info->user->user_id);
        //get the group_chat information for the first channel
        $first_channel = isset($info->channels[0]->channel_id) ? $info->channels[0]->channel_id : null;
        $info->group_chats = $this->model('GroupChat')->getGroupChats($first_channel);

        echo json_encode($info);
    }

    public function POST_Follow()
    {
        $follower_data = $_POST['follower_data'];
        //Set fields from JSON data and submit current obj to database
        $this->model('Follower')
            ->Set(json_decode($follower_data, true))
            ->Submit();
    }

    public function ChannelList()
    {
        $channel_name = $_GET['channel_name'];
        $channel_name =
            $channels = $this
            ->model('ChannelModel')
            ->SearchChannels($channel_name);

        header('Content-Type: application/json');
        echo json_encode($channels);
    }

    public function POST_ChannelList()
    {
        $this->view('Community/list');
    }
}
