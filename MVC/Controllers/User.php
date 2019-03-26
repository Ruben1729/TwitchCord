<?php

	class User extends Controller{

		public function Register(){

			$this->view('User/register');

		}

		public function POST_Register(){

			$username = $_POST['uid'];
			$password = $_POST['pwd'];
			$password_repeat = $_POST['pwd-repeat'];
			$email = $_POST['email'];

			if(empty($username) || empty($password) || empty($password_repeat) || empty($email))
			{

				echo 'I just pooped myself again';

			}
			else
			{

				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{

					echo 'bad email';

				}
				else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){

					echo 'bad username';

				}
				else if($password != $password_repeat)
				{

					echo 'bad pwd';

				}
				else
				{

					$newUser = $this->model('UserModel')->getUser($username);

					if(empty($newUser)){

						$hash_pwd = password_hash($password, PASSWORD_BCRYPT);
						$newUser = $this->model('UserModel')->insertUser($username, $email, $hash_pwd);

					}else
					{

						echo "user exists";

					}

					

				}

			}

			$this->view('User/register');

		}

		public function Login(){
			$this->view('User/login'); 
		}

		public function POST_Login(){

			$username = $_POST['uid'];
			$password = $_POST['pwd'];

			$data = [];

			$data['uid'] = $username;

			if(empty($username))
				$data['userError'] = "This field must not be empty.";
			else if(!ctype_alnum($username))
				$data['userError'] = "Username must only contain alphanumeric characters";

			if(empty($password))
				$data['passwordError'] = "This field must not be empty.";

			if(empty($data))
			{

				$loginUser = $this->model('UserModel')->getUser($username);

				if(empty($loginUser))
				{
					$data['loginError'] = "User doesn't exist.";

				}
				else
				{

					if(password_verify($password, $loginUser->password_hash))
					{

						echo "we in the safe room";
						//RETURN TO SAFE PLACE

					}
					else
					{

						$data['passwordError'] = "Wrong password.";

					}

				}

			}

			$this->view('User/login', $data);

		}

	}

?>