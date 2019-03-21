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

				echo 'I just pooped again';

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

			if(empty($username) || empty($password))//strlen() for length
			{

				//error its not the correct size
				echo "I just pooped";

			}
			else
			{

				if(!ctype_alnum($username)){

					echo "non alphanumeric";

				}

				$loginUser = $this->model('UserModel')->getUser($username);

				if(!empty($loginUser))
				{
					echo "user doesn't exist";

				}
				else
				{

					if(password_verify($password, $loginUser->password_hash))
					{

						echo "we in the safe room";
						//RETURN TO SAFE PLACE

					}

				}

			}

			$this->view('User/login');

		}

	}

?>