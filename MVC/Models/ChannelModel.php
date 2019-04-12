<?php
	
	include '../MVC/Core/Model.php';
	include '../MVC/SQL/SQL.php';

	class ChannelModel extends Model{

		public $channel_id;
		public $channel_name;
		public $description;
		public $created_on;
		public $picture_id;
		public $owner_id;

		public function insertChannel($channel_name, $description, $picture_id, $owner_id){
			$newChan = new ChannelModel();
			$newChan->channel_id = null;
			$newChan->channel_name = $channel_name;
			$newChan->description = $description;
			$newChan->created_on = null;
			$newChan->picture_id = $picture_id;
			$newChan->owner_id = $owner_id;

			$SQL = SQL::GetConnection();
			$result = $SQL
				->Modify()
				->Submit($newChan);

		}

		public function getChannelById($uid){
			$SQL = SQL::GetConnection();
			$newChannel = $SQL 
				-> Search()
				-> Model('ChannelModel')
				-> Where("owner_id", $uid)
				-> GetAsObj();

			return $newChannel;
		}

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