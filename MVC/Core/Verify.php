<?php

	function verifyLoggedIn(){
		if(!isset($_SESSION['uid']))
			header('Location: /User/Login');
	}

	function verifyProfile(){

	}