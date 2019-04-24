<?php

include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class Profile extends Model
{
	public $profile_id;
	public $user_id;
	public $pic_id;
	public $created_on;
}
