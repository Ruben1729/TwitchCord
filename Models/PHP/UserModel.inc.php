<?php
	
	class UserModel extends Model{

		private $username;
		private $email;
		private $phone;
		private $pic_id;
		private $displayname;

		function __construct($username, $email, $phone)
		{
			//Record DB Information (This model looks more like Profile)
			$this->setDBName()('User');
			$this->setDBfields(
				['username' 	=> $this->username, 
				 'email' 		=> $this->email, 
				 'phone' 		=> $this->phone, 
				 'picture_id'   => $this->pic_id, 
				 'display_name' => $this->displayname]);

			//Init
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

		function checkUser()
		{
			$username = $this->username;

			if(empty($username))
			{

				return 'empty';

			}
			else
			{

				return preg_match("/^[a-zA-Z0-9]*$/", $username);

			}

		}

		function checkEmail(){

			$email = $this->email;

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