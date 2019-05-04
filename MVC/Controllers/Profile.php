<?php
	
	class Profile extends Controller{

		public function Index(){
			$this->view('Profile/index');
		}

		public function Settings(){
			verifyLoggedIn();

			$userProfile = $this->model('ProfileModel')->getProfile($_SESSION['uid']);

			if(empty($userProfile)){
				$data['path'] = NULL;
				$data['bio'] = "";
			}else{

				$id = $userProfile->picture_id;

				if($id !== null)
					$data['path'] = $this->model('PictureModel')->getPicture($id)->path;
				else
					$data['path'] = NULL;

				$data['bio'] = $userProfile->bio;
			}

			$this->view('Profile/Settings', $data);
		}

		public function POST_Settings(){
			verifyLoggedIn();

			$userProfile = $this->model('ProfileModel')->getProfile($_SESSION['uid']);
			$result = uploadImg($_FILES);

			$bio = empty($_POST['bio']) ? "" : $_POST['bio'];

			if (strpos($result, 'ERROR') === 0) {
				$data['picture_error'] = $result;
				$pic = $this->model('PictureModel')->createEmptyPic();
			} else {
			 	$newPic = $this->model('PictureModel')
			 	 			   ->Set(['picture_id' => NULL, 'path' => $result, 'owner_id' => $_SESSION['uid']])
			 	 			   ->Submit();

			 	$pic = $this->model('PictureModel')->getPictureByPath($result);
			}

			if (empty($userProfile)) {
				$this->model('ProfileModel')
					 ->Set(['user_id' => $_SESSION['uid'], 'bio' => $bio, 'created_on' => NULL,'picture_id' => $pic->picture_id])
					 ->Submit();
				$userProfile = $this->model('ProfileModel')->getProfile($_SESSION['uid']);
			} else {
				$userProfile->bio = $bio;
				if (strpos($result, 'ERROR') !== 0)
					$userProfile->picture_id = $pic->picture_id;
				$userProfile->Submit();
			}
			

			$id = $userProfile->picture_id;
			$pictureModel = $this->model('PictureModel')->getPicture($id);
			$data['path'] = empty($pictureModel) ? null : $pictureModel->path;
			$data['bio'] = $userProfile->bio;

			$this->view('Profile/Settings', $data);
		}
	}