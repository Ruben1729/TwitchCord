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
			if(!empty($displayname))
				header("Location: /Channel/Create?displayname=$displayname");
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