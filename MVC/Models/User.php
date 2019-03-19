<?php

	include 'Model.php';

	class User extends Model{

		protected $username;
		protected $email;
		protected $user_id;
		protected $pwd_hash;

		public static function createUser($user_id, $username, $email, $pwd_hash)
		{
			$this->user_id = $user_id;
			$this->username = $username;
			$this->email = $email;
			$this->pwd_hash = $pwd_hash;
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