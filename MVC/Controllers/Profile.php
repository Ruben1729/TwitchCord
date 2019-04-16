<?php
	
	class Profile extends Controller{
		
		public function Index(){

			$this->view('Profile/index');

		}

		public function Settings(){

			$this->view('Profile/Settings');

		}

		public function POST_Settings(){
			$this->view('Profile/Settings');
		}

		public function Create(){

			$this->view('Profile/create');

		}

		public function POST_Create(){

			$displayName = $_POST['displayName'];
			$bio = $_POST['bio'];

			print_r($_FILE);

			if(empty($displayName)){
				$data['nameError'] = "This field is required";
			}

			$data['displayName'] = $displayName;
			$data['bio'] = $bio;

			$this->view('Profile/create', $data);

		}

	}