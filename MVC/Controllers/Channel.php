<?php

	class Channel extends Controller{

		public function Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function POST_Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function Create(){
			if(sizeof($_GET) > 1){
				print_r($_GET);
			}
			$this->view('Channel/create');
		}

		public function POST_Create(){

			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$pic = $_POST['pic'];

			print_r($_POST);

			$this->view('Channel/create');

		}

	}