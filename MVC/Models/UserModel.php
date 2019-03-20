<?php

	include '../MVC/Core/Model.php';
	include '../MVC/SQL/SQL.php';

	class UserModel extends Model{

		protected $username;
		protected $email;
		protected $user_id;
		protected $pwd_hash;

		public function createUser($user_id, $username, $email, $pwd_hash)
		{
			$obj = new UserModel();
			$obj->user_id = $user_id;
			$obj->username = $username;
			$obj->email = $email;
			$obj->pwd_hash = $pwd_hash;
			return $obj;
		}

		public function getUser($username){

			$SQL = SQL::GetConnection();
			$newUser = $SQL 
				-> Search()
				-> Model('UserModel')
				-> Where("username", $username)
				-> GetAs('User');

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

			return $this->pwd_hash;

		}

		public function setPwdHash($pwd){

			//REMEMBER TO HASH IT FIRST
			$this->pwd_hash = $pwd;
			//update db too

		}

		public function setUsername($username)
		{

			$this->username = $username;
			//UPDATE DB TOO

		}

	}

?>