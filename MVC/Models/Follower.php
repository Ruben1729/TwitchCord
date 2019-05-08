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
}
