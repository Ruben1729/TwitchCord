<?php
	
	include '../MVC/Core/Model.php';
	include '../MVC/SQL/SQL.php';

	class ChannelModel extends Model{

		private $channel_name;
		private $description;
		private $created_on;
		private $picture_id;
		private $owner_id;

		public function getSimilarChannels($name)
		{

			$SQL = SQL::GetConnection();
			$newChan = $SQL 
				-> Search()
				-> Model('ChannelModel')
				-> Where("channel_name", $name, 'LIKE')
				-> Get();
			return $newChan;
		}

		public function setName($name){

			$this->channel_name = $name;

		}

		public function getName(){

			return $this->channel_name;

		}

		public function setDescription($desc)
		{

			$this->description = $desc;

		}

		public function getDescription(){

			return $this->description;

		}

		public function getCreatedOn(){

			return $this->created_on;

		}

		public function setPicID($id)
		{

			$this->picture_id = $id;

		}

		public function getPicID(){

			return $this->picture_id;

		}

		public function getOwnerID(){

			return $this->owner_id;

		}

	}