<?php 

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

    class GroupChat extends Model{
        public $group_chat_id;
        public $name;
        public $channel_id;
        public $role_id;

        public function getGroupChats($channel_id){
            $SQL = SQL::GetConnection();
            $group_chats = $SQL
                ->Search()
                ->Model('groupchat')
                ->Where('channel_id', $channel_id)
                ->GetAll(PDO::FETCH_OBJ);

                return $group_chats;
        }
    }