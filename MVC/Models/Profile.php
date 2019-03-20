<?php
	
	include '../Core/Model.php';

	class Profile extends Model{

		private $user_id;
		private $displayname;
		private $phone;
		private $pic_id;
		private $created_on;

		public static function createProfile($user_id, $displayname, $phone, $pic_id, $created_on)
		{
			$obj = new Profile();
			$obj->user_id = $user_id;
			$obj->displayname = $displayname;
			$obj->phone = $phone;
			$obj->pic_id = $pic_id;
			$obj->created_on = $created_on;
			return $obj;
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