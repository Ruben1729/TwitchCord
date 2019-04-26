<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class ChannelModel extends Model implements iSQLQueryable
{
	public static function DBName()
	{
		return 'Channel';
	}

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
}
