<?php
	
	include 'ModelBase.php';

	class UserModel extends Model{

		private $username;
		private $email;
		private $user_id;
		private $pwd_hash;

		function __construct($username, $email, $pwd_hash)
		{
			//Record DB Information
			$this->setDBName()('User');
			$this->setDBfields(
				['username' 	=> $this->username, 
				 'email' 		=> $this->email,
				 'pwd_hash'		=> $this->pwd_hash]);

			//Init
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