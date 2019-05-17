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

	//Optional $user_id field, -1 assumes no user
	public function getChannels($channel_name, $user_id = -1)
	{
		$SQL = SQL::GetConnection();
		$query = "SELECT channel_id, channel_name, description, created_on, path, (SELECT (CASE
                                                                                                WHEN a.channel_id = b.channel_id THEN 1
                                                                                                ELSE 0
                                                                                            END)
                                                                                    FROM follower a
                                                                                    WHERE user_id = ?) as \"isFollowed\"
                    FROM channel b
               LEFT JOIN picture USING (picture_id)
               LEFT JOIN banned USING (channel_id)
                   WHERE channel_name LIKE ?
                     AND b.owner_id != ?
                     AND banned_on IS NULL";
		$PDO = $SQL->PDO();
		$stmt = $PDO->prepare($query);
		//I could be wrong, but named parameters for multiple fields don't work correctly
		$stmt->execute([$user_id, "%$channel_name%", $user_id]);
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}
