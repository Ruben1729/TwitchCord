<?php
include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class UserModel extends Model implements iSQLQueryable
{

	public static function DBName()
	{
		return 'User';
	}

	public $username;
	public $email;
	public $user_id;
	public $password_hash;

	public function checkEmailUK($email)
	{

		$SQL = SQL::GetConnection();
		$newUser = $SQL
			->Search()
			->Model('UserModel')
			->Where("email", $email)
			->GetAsObj();

		return $newUser;
	}

	public function getUserUID($uid)
	{
		$SQL = SQL::GetConnection();
		$newUser = $SQL
			->Search()
			->Model('UserModel')
			->Where("user_id", $uid)
			->GetAsObj();
		return $newUser;
	}

	public function getUser($username)
	{
		$SQL = SQL::GetConnection();
		$newUser = $SQL
			->Search()
			->Model('UserModel')
			->Where("username", $username)
			->JoinUsing('LEFT JOIN', 'profile', 'user_id')
			->JoinUsing('LEFT JOIN', 'picture', 'picture_id')
			->Get();
		return $newUser;
	}
}
