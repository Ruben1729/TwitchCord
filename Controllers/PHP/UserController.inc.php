<?php
	
	include '../../Models/php/UserModel.inc.php'; 

	class UserController{

		function register($username, $password, $password_repeat, $email)
		{

			$error = array();

			if(empty($username) || empty($password) || empty($password_repeat) || empty($email))
			{

				echo "Error"//FIELD IS EMPTY SEND BACK TO REGISTER

			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{

				echo "EMAIL ERROR";//BAD FORMAT FOR THE EMAIL

			}

			if(!ctype_alnum($username))
			{

				echo "USERNAME ERROR";//BAD FORMAT FOR USERNAME

			}

			if($password != $password_repeat)
			{

				echo "PWD ERROR";//PWDs DONT MATCH

			}

			if(empty($error))
			{

				//REGISTER SUCCESSFULLY

				$uModel = new UserModel($username, $email, password_hash($password, PASSWORD_BCRYPT));
				//ENTER INTO DB

				//SEND BACK TO LOGIN

			}

		}

		function login($username, $password)
		{

			if(empty($username) || empty($password))
			{

				echo "Error";//ERROR SEND BACK TO LOGIN WITH EMPTY FIELDS

			}

			//GET THE USER USING THE USERNAME
			$user = new UserModel();

			if($user === null)
			{



			}
			
			if(password_verify($password, $user->pwd_hash))
			{

				//SEND TO MAIN PAGE

			}

		}



	}

?>