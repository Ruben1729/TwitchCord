<?php
	
	class Profile extends Controller{
		
		public function Index(){

			$this->view('Profile/index');

		}

		public function Settings(){

			$this->view('Profile/settings');

		}

	}