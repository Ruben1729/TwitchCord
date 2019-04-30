<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';
class ProfileModel extends Model implements iSQLQueryable
{

	public static function DBName()
	{
		return 'Profile';
	}

	public $user_id;
	public $bio;
	public $created_on;
	public $picture_id;

	public function createProfile($user_id, $bio, $created_on, $pic)
	{
		$obj = new Profile();
		$obj->user_id = $user_id;
		$obj->bio = $bio;
		$obj->created_on = $created_on;
		$obj->pic_id = $pic;
		return $obj;
	}
	public function getProfile($uid)
	{
		$SQL = SQL::GetConnection();
		$newProfile = $SQL
			->Search()
			->Model('ProfileModel')
			->Where('user_id', $uid)
			->GetAsObj();
		return $newProfile;
	}
}
