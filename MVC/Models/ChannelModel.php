<?php

	include_once '../MVC/Core/Model.php';
	include_once '../MVC/SQL/SQL.php';

	class ChannelModel extends Model{

		public $channel_name;
		public $description;
		public $created_on;
		public $picture_id;
		public $owner_id;

		public function getSimilarChannels($name)
		{

			$SQL = SQL::GetConnection();
			$newChan = $SQL 
				-> Search()
				-> Model('ChannelModel')
				-> Where("channel_name", $name, 'LIKE')
				-> Get();
			return $newChan;
		}

		public function getChannel($name){
			$SQL = SQL::GetConnection();
			$channel = $SQL
				->Search()
				->Model('ChannelModel')
				->Where('channel_name', $name, '=')
				->GetAsObj();
			return $channel;
		}

		public function getChannels($user_id){
			$SQL = SQL::GetConnection();
			$channel = $SQL
				->Search()
				->Model('follower')
				->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'picture_id', 'owner_id'])
				->JoinUsing('INNER JOIN', 'UserModel', 'user_id')
				->JoinUsing('INNER JOIN', 'ChannelModel', 'channel_id')
				->Where('user_id', $user_id)
				->GetAll(PDO::FETCH_OBJ);
		}

	}