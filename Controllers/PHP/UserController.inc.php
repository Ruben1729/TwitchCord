<?php
	
	include 

	class UserController{

		function register($username, $password, $password_repeat, $email, $phone)
		{

			$userModel = new UserModel($username, $email, $phone);

		}

		function login($username, $password)
		{

			

		}



	}

?>