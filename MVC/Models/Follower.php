<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class Follower extends Model implements iSQLQueryable
{

    public static function DBName()
    {
        return 'follower';
    }


    public $user_id;
    public $channel_id;
    public $followed_on = null;
    public $notification = null;
    public $permission_binary = null;

    public function getAllFollowers($channel_id)
    {
        $SQL = SQL::GetConnection();
        return $SQL
            ->Search()
            ->Model('Follower')
            ->Where('channel_id', $channel_id)
            ->JoinUsing('INNER JOIN', 'user', 'user_id')
            ->Where('user_id', $_SESSION[uid], '!=')
            ->GetAll(PDO::FETCH_OBJ);
    }

    public function getAllChannels($id){
        $SQL = SQL::GetConnection();
        return $SQL
            ->Search()
            ->Model('follower')
            ->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path', 'permission_binary'])
            ->JoinUsing('INNER JOIN', 'channel', 'channel_id')
            ->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
            ->Where('user_id', $id)
            ->GetAll(PDO::FETCH_OBJ);
    }
}
