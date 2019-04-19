<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class Group_Chat extends Model
{
    public $group_chat_id;
    public $name;
    public $channel_id;
    public $role_id;

    public function getGroupChats($channel_id)
    {
        $SQL = SQL::GetConnection();
        $group_chats = $SQL
            ->Search()
            ->Model('group_chat')
            ->Where('channel_id', $channel_id)
            ->GetAll(PDO::FETCH_OBJ);

        return $group_chats;
    }
}
