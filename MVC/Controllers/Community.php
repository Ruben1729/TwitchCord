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
        //Retrieve user's information
        $info->user = $this->model('UserModel')->getProfile($_SESSION[username]);
        //Get the channels for the current user
        $SQL = SQL::GetConnection();
        $info->channels = $SQL
            ->Search()
            ->Model('follower')
            ->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path'])
            ->JoinUsing('INNER JOIN', 'channel', 'channel_id')
            ->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
            ->Where('user_id', $info->user->user_id)
            ->GetAll(PDO::FETCH_OBJ);

        echo json_encode($info);
    }

    public function GetUsersFromChannel($channel_id)
    {
        $SQL = SQL::GetConnection();
        $users = $SQL
            ->Search()
            ->Fields(['user_id', 'username', 'path', '0 as "isActive"'])
            ->Model('UserModel')
            ->JoinUsing('INNER JOIN', 'follower', 'user_id')
            ->JoinUsing('LEFT JOIN', 'profile', 'user_id')
            ->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
            ->Where('channel_id', $channel_id)
            ->GetAll();

        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function GetGroupChats($channel_id)
    {
        $groups = $this->model('Group_Chat')->getGroupChats($channel_id);
        header('Content-Type: application/json');
        echo json_encode($groups);
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
        $user_id = isset($_SESSION[uid]) ? $_SESSION[uid] : -1;

        $SQL = SQL::GetConnection();
        $channels = $SQL
            ->Search()
            ->Model('ChannelModel')
            ->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path'])
            ->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
            ->Where("channel_name", "%$channel_name%", 'LIKE')
            ->Where('channel.owner_id', $user_id, '!=')
            ->GetAll(PDO::FETCH_OBJ);

        //Add property if channel is followed, assuming logged in
        if ($user_id != -1) {
            $followed = $SQL
                ->Search()
                ->Model('Follower')
                ->Fields(['channel_id', '1'])
                ->Where('user_id', $user_id)
                ->GetAll(PDO::FETCH_KEY_PAIR);

            //Stop if no one has been followed
            if ($followed) {
                // Check if key exists
                foreach ($channels as $channel) {
                    if ($followed[$channel->channel_id]) {
                        $channel->isFollowed = true;
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($channels);
    }

    public function POST_ChannelList()
    {
        $this->view('Community/list');
    }
}
