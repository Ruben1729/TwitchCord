<?php

	class User extends Controller{

		public function Login(){
			$this->view('User/login'); 
		}

		public function POST_Login($username = null, $password = null){

			$this->view('User/login');

		}

	}

?>