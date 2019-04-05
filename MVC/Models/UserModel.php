<?php

	include '../MVC/Core/Model.php';
	include '../MVC/SQL/SQL.php';

	class UserModel extends Model{

		public $username;
		public $email;
		public $user_id;
		public $password_hash;

		public function createUser($user_id, $username, $email, $pwd_hash)
		{
			$obj = new UserModel();
			$obj->user_id = $user_id;
			$obj->username = $username;
			$obj->email = $email;
			$obj->password_hash = $pwd_hash;
			return $obj;
		}

		public function insertUser($username, $email, $pwd_hash){

			$obj = new UserModel();
			$obj->user_id = null;
			$obj->username = $username;
			$obj->email = $email;
			$obj->password_hash = $pwd_hash;

			$SQL = SQL::GetConnection();
			$result = $SQL
				->Modify()
				->Submit($obj);

		}

		public function checkEmailUK($email){

			$SQL = SQL::GetConnection();
			$newUser = $SQL 
				-> Search()
				-> Model('UserModel')
				-> Where("email", $email)
				-> GetAsObj();

			return $newUser;

		}

		public function getUser($username){

			$SQL = SQL::GetConnection();
			$newUser = $SQL 
				-> Search()
				-> Model('UserModel')
				-> Where("username", $username)
				-> GetAsObj();

			return $newUser;

		}

		public function getProfile($username){
			$SQL = SQL::GetConnection();
			$newUser = $SQL 
				-> Search()
				-> Model('UserModel')
				-> JoinUsing('INNER JOIN', 'ProfileModel', 'user_id')
				-> Where("username", $username)
				-> GetAsObj();

			return $newUser;
		}

		public function getUserId(){

			return $this->user_id;

		}

		public function getEmail(){

			return $this->email;

		}

		public function getUsername(){

			return $this->username;

		}

		public function getPwdHash(){

			return $this->password_hash;

		}

		public function setPwdHash($pwd){

			//REMEMBER TO HASH IT FIRST
			$this->password_hash = $pwd;
			//update db too

		}

		public function setUsername($username)
		{

			$this->username = $username;
			//UPDATE DB TOO

		}

	}

?>