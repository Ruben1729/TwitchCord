<?php
include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class UserModel extends Model
{

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

	public function getUser($username)
	{

		$SQL = SQL::GetConnection();
		$newUser = $SQL
			->Search()
			->Model('UserModel')
			->Where("username", $username)
			->GetAsObj();
		return $newUser;
	}

	//Includes UserModel + Profile + Picture's Path
	public function getProfile($username)
	{
		$SQL = SQL::GetConnection();
		$newUser = $SQL
			->Search()
			->Fields(['user_id', 'username', 'bio', 'created_on', 'path'])
			->Model('UserModel')
			->JoinUsing('LEFT JOIN', 'ProfileModel', 'user_id')
			->JoinUsing('LEFT JOIN', 'picturemodel', 'picture_id')
			->Where("username", $username)
			->Get();
		return $newUser;
	}
}
