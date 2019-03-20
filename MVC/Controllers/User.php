<?php

	class User extends Controller{

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

			}

			$this->view('User/login');

		}

	}

?>