<?php
	
	class Profile{
		
		public function Index(){

			$this->view('Profile/index');

		}

		public function Settings(){

			$this->view('Profile/Settings');

		}

	}