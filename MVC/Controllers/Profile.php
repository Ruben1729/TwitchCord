<?php
	
	class Profile extends Controller{
		
		public function Index(){

			$this->view('Profile/index');

		}

		public function Settings(){

			$this->view('Profile/settings');

		}

		public function Create(){

			$this->view('Profile/create');

		}

		public function POST_Create(){

			$result = uploadImg($_FILES);
			$displayName = $_POST['displayName'];
			$bio = $_POST['bio'];

			if(!empty($result)){
				$data['imgError'] = $result;
			}

			if(empty($displayName)){
				$data['nameError'] = "This field is required";
			}

			$data['displayName'] = $displayName;
			$data['bio'] = $bio;

			$this->view('Profile/create', $data);

		}

	}