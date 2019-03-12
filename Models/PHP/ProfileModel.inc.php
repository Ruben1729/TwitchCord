<?php
	
	include 'ModelBase.php';

	class Profile extends Model{

		private $user_id;
		private $displayname;
		private $phone;
		private $pic_id;
		private $created_on;

		function __construct($user_id, $displayname, $phone, $pic_id, $created_on)
		{
			//Record DB Information
			$this->setDBName()('Profile');
			$this->setDBfields(
				['user_id' 		=> $this->user_id, 
				 'displayname' 	=> $this->displayname, 
				 'phone' 		=> $this->phone, 
				 'picture_id'   => $this->pic_id, 
				 'created_on' 	=> $this->created_on]);

			//Init
			$this->user_id = $user_id;
			$this->displayname = $displayname;
			$this->phone = $phone;
			$this->pic_id = $pic_id;
			$this->created_on = $created_on;

		}

		/* getters and setters */

		public function getUserId(){

			return $this->user_id;

		}

		public function getDisplayName(){

			return $this->displayname;

		}

		public function getPhone(){

			return $this->phone;

		}

		public function getPicId(){

			return $this->pic_id;

		}

		public function getCreatedOn(){

			return $this->created_on;

		}

		public function setPicId($pic_id){

			$this->pic_id = $pic_id;
			//update db too

		}

		public function setPhone($phone){

			$this->phone = $phone;
			//update db too

		}

		public function setDisplayName($displayname)
		{

			$this->displayname = $displayname;
			//update db too

		}

	}