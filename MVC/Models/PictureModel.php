<?php

	include_once '../MVC/Core/Model.php';
	include_once '../MVC/SQL/SQL.php';

	class PictureModel extends Model{

		public $path;
		public $picture_id;

		public function getAllPictures($owner){
			$SQL = SQL::GetConnection();
			$allPics = $SQL 
				-> Search()
				-> Model('PictureModel')
				-> Where('owner_id', $owner)
				-> GetAll();

			return $allPics;
		}

		public function getPicture($id){
			$SQL = SQL::GetConnection();
			$picture = $SQL 
				-> Search()
				-> Model('PictureModel')
				-> Where('picture_id', $id)
				-> GetAsObj();

			return $picture;
		}

		public function getPictureByPath($path){
			$SQL = SQL::GetConnection();
			$picture = $SQL 
				-> Search()
				-> Model('PictureModel')
				-> Where('path', $path)
				-> GetAsObj();

			return $picture;
		}

	}