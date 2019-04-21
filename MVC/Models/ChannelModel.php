<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class ChannelModel extends Model
{

	public $channel_id;
	public $channel_name;
	public $description;
	public $created_on;
	public $picture_id;
	public $owner_id;

	public function getChannelByName($name)
	{
		$SQL = SQL::GetConnection();
		$channel = $SQL
			->Search()
			->Model('ChannelModel')
			->Where('channel_name', $name, '=')
			->GetAsObj();
		return $channel;
	}


	public function getChannelById($uid)
	{
		$SQL = SQL::GetConnection();
		$newChannel = $SQL
			->Search()
			->Model('ChannelModel')
			->Where('owner_id', $uid)
			->GetAsObj();

		return $newChannel;
	}

	public function getUsersChannels($user_id)
	{
		$SQL = SQL::GetConnection();
		$channel = $SQL
			->Search()
			->Model('follower')
			->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path'])
			->JoinUsing('INNER JOIN', 'ChannelModel', 'channel_id')
			->JoinUsing('LEFT JOIN', 'picturemodel', 'picture_id')
			->Where('user_id', $user_id)
			->GetAll(PDO::FETCH_OBJ);
		return $channel;
	}
}
