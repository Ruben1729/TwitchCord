<?php
	
	class Channel extends Controller{
		public function Dashboard(){
			$data = [];
			$newChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
			if(!empty($newChannel))
				$data['description'] = $newChannel->description;

			$this->view('Channel/Dashboard', $data);
		}

		public function POST_Dashboard(){
			$this->view('Channel/Dashboard');
		}

		public function Link(){
			$displayname = getToken($_GET['code']);
			if(!empty($displayname)){
				$this->model('ChannelModel')
					 ->Set(['channel_id' => null, 'channel_name' => $displayname, 'description' => "", 'created_on' => null, 'picture_id' => null, 'owner_id' => $_SESSION['uid']])
					 ->Submit();
				header("Location: /Channel/Create");
			} else {
				header("Location: /Channel/Create");
			}
			$this->view('Channel/link');
		}

		public function Create(){
			$this->view('Channel/create');
		}

		public function POST_Create(){
			$desc = $_POST['desc'];

			$result = uploadImg($_FILES);

			$newChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
			$newChannel->description = $desc;

			if(strpos($result, 'ERROR') === 0){
				echo $result;
			} else {
				$newPic = $this->model('PictureModel')
				 			   ->Set(['picture_id' => null, 'path' => $result])
				 			   ->Submit();

				$channelPic = $this->model('PictureModel')->getPictureByPath($result);

				$newChannel->picture_id = $channelPic->picture_id;
				$newChannel->Submit();
			}
			header('Location: /Main/Index');
		}
	}