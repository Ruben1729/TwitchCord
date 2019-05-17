<?php
	class Picture extends Controller{
		public function Gallery(){
			$data['pics'] = $this->model('picturemodel')->getAllPictures($_SESSION['uid']);

			$this->view('Picture/Gallery', $data);
		}

		public function POST_Gallery(){
			$this->view('Picture/Gallery');
		}

		public function POST_ChangeChanPic(){
			$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
			if(!empty($userChannel)){
				$userChannel->picture_id = $_POST['picID'];
				$userChannel->Submit();
			}
		}

		public function POST_ChangeProfPic(){
			$userProfile = $this->model('ProfileModel')->getProfile($_SESSION['uid']);
			if(!empty($userProfile)){
				$userProfile->picture_id = $_POST['picID'];
				$userProfile->Submit();
			}
		}
	}