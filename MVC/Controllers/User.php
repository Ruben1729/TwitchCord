<?php

	class User extends Controller{

		public function Register(){

			$this->view('User/register');

		}

		/*public function POST_Register(){

			$username = $_POST['uid'];
			$password = $_POST['pwd'];
			$password_repeat = $POST['pwd-repeat'];
			$email = $_POST['email']

			if($username === null || $password === null || $password_repeat === null || $email === null)
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

					$hash_pwd = password_hash($password, PASSWORD_BCRYPT);

				}

			}

			$newUser = $this->model('UserModel')->createUser($username, $email, $hash_pwd);


			$this->view('User/register');

		}*/

		public function Login(){
			$this->view('User/login'); 
		}

		public function POST_Login(){

			$username = $_POST['uid'];
			$password = $_POST['pwd'];

			if($username === null || $password === null)
			{

				echo "I just pooped";

			}
			else
			{

				$loginUser = $this->model('UserModel')->getUser($username);
				
				print_r($loginUser);

				if($loginUser !== null)
				{

					if(password_verify($password, $loginUser->getPwdHash()))
					{

						//RETURN TO SAFE PLACE

					}

				}

			}

			$this->view('User/login');

		}

	}

?>