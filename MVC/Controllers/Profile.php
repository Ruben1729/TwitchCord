<?php

class Profile extends Controller
{

	public function Index()
	{
		$this->view('Profile/index');
	}

	public function Settings()
	{
		verifyLoggedIn();

		$userProfile = $this->model('ProfileModel')->getProfile($_SESSION['uid']);

		if (empty($userProfile)) {
			$data['path'] = NULL;
			$data['bio'] = "";
		} else {

			$id = $userProfile->picture_id;

			if ($id !== null)
				$data['path'] = $this->model('PictureModel')->getPicture($id)->path;
			else
				$data['path'] = NULL;

			$data['bio'] = $userProfile->bio;
		}

		$this->view('Profile/Settings', $data);
	}

	public function POST_Settings()
	{
		verifyLoggedIn();

		$userProfile = $this->Model('ProfileModel')->getProfile($_SESSION['uid']);
		$result = uploadImg($_FILES);
		$bio = empty($_POST['bio']) ? "" : $_POST['bio'];

		if (strpos($result, 'ERROR') === 0) {
			$data['picture_error'] = $result;
			$pic = NULL;
		} else {
			$newPic = $this->Model('PictureModel')
				->Set(['picture_id' => NULL, 'path' => $result, 'owner_id' => $_SESSION['uid']])
				->Submit();

			$pic = $this->Model('PictureModel')->getPictureByPath($result);
		}

		if (empty($userProfile)) {

			$this->Model('ProfileModel')
				->Set(['user_id' => $_SESSION['uid'], 'bio' => $bio, 'created_on' => NULL, 'picture_id' => $pic->picture_id])
				->Submit();
		} else {

			$userProfile->bio = $bio;
			if (strpos($result, 'ERROR') !== 0)
				$userProfile->picture_id = $pic->picture_id;
			$userProfile->Submit();
		}


		$id = $userProfile->picture_id;
		$pictureModel = $this->model('PictureModel')->getPicture($id);
		$data['path'] = $pictureModel->path;
		$data['bio'] = $userProfile->bio;

		$this->view('Profile/Settings', $data);
	}

	public function Create()
	{
		$this->view('Profile/create');
	}

	public function POST_Create()
	{
		$displayName = $_POST['displayName'];
		$bio = $_POST['bio'];

		print_r($_FILE);

		if (empty($displayName)) {
			$data['nameError'] = "This field is required";
		}

		$data['displayName'] = $displayName;
		$data['bio'] = $bio;

		$this->view('Profile/create', $data);
	}
}
