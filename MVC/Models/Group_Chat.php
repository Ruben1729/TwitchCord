<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class Group_Chat extends Model implements iSQLQueryable
{
    public static function DBName()
    {
        return 'group_chat';
    }

    public $group_chat_id;
    public $name;
    public $channel_id;
    public $chat_type;

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
