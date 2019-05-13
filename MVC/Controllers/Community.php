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

    public function GetUserChannels()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION[uid])) {
            echo json_encode('{error: "No user is logged in"}');
            return;
        }

        //Get the channels for the current user
        $channels = $this->model('Follower')->GetAllChannels($_SESSION[uid]);

        $this->send($channels);
    }

    public function GetGroupChats($channel_id)
    {
        //Setup generic object to hold information
        $info = new stdClass();

        $info->groups = $this->model('Group_Chat')->getGroupChats($channel_id);
        header('Content-Type: application/json');
        echo json_encode($info);
    }

    public function GetUsersFromChannel($channel_id)
    {
        $this->model('UserModel')->getChannels($channel_id);
        $this->send($users);
    }

    public function POST_Follow()
    {
        $follower_data = json_decode($_POST['follower_data']);
        //Set fields from JSON data and submit current obj to database
        $SQL = SQL::GetConnection();
        $SQL->Query(
            'INSERT INTO follower (user_id, channel_id) VALUES (?, ?)',
            [$follower_data->user_id, $follower_data->channel_id]
        );
    }

    public function POST_Unfollow()
    {
        $info = json_decode($_POST['info']);
        $SQL = SQL::GetConnection();
        $SQL->Query(
            'DELETE FROM follower WHERE user_id = :user_id AND channel_id = :channel_id',
            [':user_id' => $info->user_id, ':channel_id' => $info->channel_id]
        );
    }

    public function ChannelList()
    {
        $channel_name = $_GET['channel_name'];
        $user_id = isset($_SESSION[uid]) ? $_SESSION[uid] : -1;

        $this->model('ChannelModel')->getChannels($channel_name, $user_id);
        $this->send($channels);
    }

    public function POST_ChannelList()
    {
        $this->view('Community/list');
    }
}
