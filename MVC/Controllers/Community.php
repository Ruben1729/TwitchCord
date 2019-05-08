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
        $SQL = SQL::GetConnection();
        $channels = $SQL
            ->Search()
            ->Model('follower')
            ->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path', 'permission_binary'])
            ->JoinUsing('INNER JOIN', 'channel', 'channel_id')
            ->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
            ->Where('user_id', $_SESSION[uid])
            ->GetAll(PDO::FETCH_OBJ);

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

        $SQL = SQL::GetConnection();
        $query = "SELECT channel_id, channel_name, description, created_on, path, (SELECT (CASE
                                                                                                WHEN a.channel_id = b.channel_id THEN 1
                                                                                                ELSE 0
                                                                                            END)
                                                                                    FROM follower a
                                                                                    WHERE user_id = ?) as \"isFollowed\"
                    FROM channel b
               LEFT JOIN picture USING (picture_id)
               LEFT JOIN banned USING (channel_id)
                   WHERE channel_name LIKE ?
                     AND b.owner_id != ?
                     AND banned_on IS NULL";
        $PDO = $SQL->PDO();
        $stmt = $PDO->prepare($query);
        $stmt->execute([$user_id, "%$channel_name%", $user_id]);
        $channels = $stmt->fetchAll(PDO::FETCH_OBJ);
        $this->send($channels);
    }

    public function POST_ChannelList()
    {
        $this->view('Community/list');
    }
}
