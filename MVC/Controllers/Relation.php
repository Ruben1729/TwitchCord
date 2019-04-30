<?php
	
	class Relation extends Controller{

		public function SearchUser(){
			verifyLoggedIn();
			$this->view('Relation/SearchUser');
		}

		public function POST_SearchUser(){
			verifyLoggedIn();
			$this->view('Relation/SearchUser');
		}

		public function POST_FriendList(){
			verifyLoggedIn();
		}

	}