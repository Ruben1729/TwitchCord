<?php

class User extends Controller
{

	public function Register()
	{

		$this->view('User/register');
	}

	public function Logout()
	{
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		//redirect back to homepage when logging out
		header('Location: /Main/Index');
	}

	public function POST_Register()
	{

		$username = $_POST['uid'];
		$password = $_POST['pwd'];
		$password_repeat = $_POST['pwd-repeat'];
		$email = $_POST['email'];

		if (empty($username)) {
			$data['userError'] = "This field must not be empty.";
		} else if (!ctype_alnum($username)) {
			$data['userError'] = "Username must only contain alphanumeric characters";
		}

		if (empty($email)) {
			$data['emailError'] = "This field must not be empty.";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$data['emailError'] = "Invalid Email.";
		}

		if (empty($password)) {
			$data['passwordError'] = "This field must not be empty.";
		}

		if (empty($password_repeat)) {
			$data['passwordRepeatError'] = "This field must not be empty.";
		}

		if (!empty($password) && !empty($password_repeat) && $password !== $password_repeat) {
			$data['passwordRepeatError'] = "Passwords must match.";
			$data['passwordError'] = "Passwords must match.";
		}


		if (empty($data)) {
			$newUser = $this->model('UserModel')->getUser($username);
			$emailInUse = $this->model('UserModel')->checkEmailUK($email);

			if (!empty($newUser))
				$data['userError'] = "Username is already taken.";
			else if (!empty($emailInUse))
				$data['emailError'] = "Email is already in use.";
			else {
				$hash_pwd = password_hash($password, PASSWORD_BCRYPT);
				$this->model('UserModel')
					->Set(['username' => $username, 'email' => $email, 'password_hash' => $hash_pwd])
					->Submit();
				header('Location: Login');
			}
		}

		$data['uid'] = $username;
		$data['email'] = $email;
		$data['reload'] = False;

		$this->view('User/register', $data);
	}

	public function Login()
	{
		$this->view('User/login');
	}

	public function POST_Login()
	{

		$username = $_POST['uid'];
		$password = $_POST['pwd'];

		$data = [];

		if (empty($username))
			$data['userError'] = "This field must not be empty.";
		else if (!ctype_alnum($username))
			$data['userError'] = "Username must only contain alphanumeric characters";

		if (empty($password))
			$data['passwordError'] = "This field must not be empty.";

		if (empty($data)) {

			$loginUser = $this->model('UserModel')->getUser($username);

			if (empty($loginUser)) {

				$data['loginError'] = "User doesn't exist.";
			} else {

				if (password_verify($password, $loginUser->password_hash)) {

					$_SESSION[uid] = $loginUser->user_id;
					$_SESSION[username] = $loginUser->username;
					$_SESSION["picture_path"] = $loginUser->path;

					header('Location: /Main/Index');
				} else {

					$data['passwordError'] = "Wrong password.";
				}
			}
		}

		$data['uid'] = $username;
		$data['reload'] = False;

		$this->view('User/login', $data);
	}

	public function GetCurrentUser()
	{
		$newUser = $this->model('UserModel')->GetUserDetails($_SESSION[uid]);
		$this->send($newUser);
	}
}
