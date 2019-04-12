<?php
	
	class Channel extends Controller{

		public function Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function POST_Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function Link(){
			$displayname = getToken($_GET['code']);
			if(!empty($displayname)){
				$newChannel = $this->model('ChannelModel')->insertChannel($displayname, "", null, $_SESSION['uid']);
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

			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$pic = $_POST['pic'];

			$this->view('Channel/create');

		}

	}