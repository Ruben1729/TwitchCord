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

	public function SearchChannels($name)
	{
		$user_id = isset($_SESSION[uid]) ? $_SESSION[uid] : -1;

		$SQL = SQL::GetConnection();
		$channels = $SQL
			->Search()
			->Model('ChannelModel')
			->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path', 'owner_id'])
			->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
			->Where("channel_name", "%$name%", 'LIKE')
			->GetAll(PDO::FETCH_OBJ);

		//Add property if channel is followed, assuming logged in
		if ($user_id != -1) {
			$followed = $SQL
				->Search()
				->Model('Follower')
				->Fields(['channel_id', '1'])
				->Where('user_id', $user_id)
				->GetAll(PDO::FETCH_KEY_PAIR);

			// Check if key exists
			foreach ($channels as $channel) {
				if ($followed[$channel->channel_id]) {
					$channel->isFollowed = true;
				}
			}
		}

		return $channels;
	}

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
			->Fields(['channel_id', 'channel_name', 'description', 'created_on', 'path', 'owner_id'])
			->JoinUsing('INNER JOIN', 'ChannelModel', 'channel_id')
			->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
			->Where('user_id', $user_id)
			->GetAll(PDO::FETCH_OBJ);
		return $channel;
	}
}
