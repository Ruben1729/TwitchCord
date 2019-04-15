<?php

	include_once '../MVC/Core/Model.php';
	include_once '../MVC/SQL/SQL.php';

	class Follower extends Model{
        
        public $user_id;
        public $channel_id;
        public $followed_on;
        public $notification;
        public $role_id;
        
    }
