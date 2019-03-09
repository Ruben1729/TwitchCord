<?php
	
	class UserModel{

		private $username;
		private $email;
		private $phone;
		private $pic_id;
		private $displayname;

		function __construct($username, $email, $phone)
		{

			$this->username = $username;
			$this->email = $email;
			$this->phone = $phone;

		}

		function checkPwd($password, $password_repeat)
		{

			if(empty($password) || empty($password_repeat))
			{

				return 'empty';

			}
			else if($password != $password_repeat)
			{

				return 'notmatch';

			}
			else
			{

				password_hash($password, PASSWORD_BCRYPT);

			}

		}

		function checkUser($username = $this->username)
		{

			if(empty($username))
			{

				return 'empty';

			}
			else
			{

				return preg_match("/^[a-zA-Z0-9]*$/", $username);

			}

		}

		function checkEmail($email = $this->email){

			if(empty($email))
			{

				return 'empty';

			}
			else
			{

				return filter_var($email, FILTER_VALIDATE_EMAIL);

			}

		}

	}

?>