<?php

	class Channel extends Controller{

		public function Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function POST_Dashboard(){

			$this->view('Channel/Dashboard');

		}

		public function RegisterChannel(){

			$this->view('Channel/RegisterChannel');

		}

		public function POST_RegisterChannel(){

			$this->view('Channel/RegisterChannel');

		}

	}