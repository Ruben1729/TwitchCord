<?php
class Channel extends Controller
{

	public function Dashboard()
	{
		verifyLoggedIn();

		$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
		if (empty($userChannel)) {
			$data['auth'] = false;
		} else {
			$data['auth'] = true;
			$data['description'] = $userChannel->description;
			$id = $userChannel->picture_id;

			//Get followers
			$followers = $this->model('Follower')->getAllFollowers($userChannel->channel_id);
			$data['followers'] = $followers;

			$pictureModel = $this->model('PictureModel')->getPicture($id);
			if ($pictureModel) {
				$data['path'] = $pictureModel->path;
			} else {
				$data['auth'] = true;
				$data['description'] = $userChannel->description;
				$id = $userChannel->picture_id;

				$pictureModel = $this->model('PictureModel')->getPicture($id);
				if ($pictureModel) {
					$data['path'] = $pictureModel->path;
				} else {
					$data['path'] = "/Pictures/default.png";
				}
			}
		}
		$this->view('Channel/Dashboard', $data);
	}

	public function POST_Dashboard()
	{
		verifyLoggedIn();

		$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);

		if (empty($userChannel)) {
			$data['auth'] = false;
		} else {
			$data['auth'] = true;

			$userChannel->description = $_POST['desc'];

			$result = uploadImg($_FILES);

			if (strpos($result, 'ERROR') === 0) {
				$data['picture_error'] = $result;
			} else {

				$newPic = $this->model('PictureModel')
					->Set(['picture_id' => null, 'path' => $result, 'owner_id' => $_SESSION['uid']])
					->Submit();

				$channelPic = $this->model('PictureModel')->getPictureByPath($result);
				$userChannel->picture_id = $channelPic->picture_id;
			}

			$userChannel->Submit();
			$id = $userChannel->picture_id;
			$pictureModel = $this->model('PictureModel')->getPicture($id);
			$data['path'] = $pictureModel->path;
			$data['description'] = $_POST['desc'];
		}

		$this->view('Channel/Dashboard', $data);
	}

	public function Link()
	{
		$displayname = getToken($_GET['code']);
		if (!empty($displayname)) {
			$owner_permission = 1 << 3;
			$channel_id =
				$this->model('ChannelModel')
				->Set(['channel_name' => $displayname, 'description' => "", 'owner_id' => $_SESSION['uid']])
				->Submit();
			echo $channel_id;
			//Set yourself as a follower, for displaying purposes
			$SQL = SQL::GetConnection();
			$SQL->Query(
				'INSERT INTO follower (user_id, channel_id, permission_binary) VALUES (?, ?, ?)',
				[$_SESSION[uid], $channel_id, $owner_permission]
			);
			header("Location: /Channel/Create");
		} else {
			header("Location: /Channel/Create");
		}
		$this->view('Channel/link');
	}

	public function Create()
	{
		verifyLoggedIn();

		$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
		if (empty($userChannel))
			$data['auth'] = false;
		else
			$data['auth'] = true;

		$this->view('Channel/create', $data);
	}

	public function POST_Create()
	{
		verifyLoggedIn();

		$desc = $_POST['desc'];
		$result = uploadImg($_FILES);

		$newChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
		$newChannel->description = $desc;

		if (strpos($result, 'ERROR') === 0) {
			echo $result;
		} else {
			$newPic = $this->model('PictureModel')
				->Set(['picture_id' => null, 'path' => $result, 'owner_id' => $_SESSION['uid']])
				->Submit();

			$channelPic = $this->model('PictureModel')->getPictureByPath($result);

			$newChannel->picture_id = $channelPic->picture_id;
			$newChannel->Submit();
		}
		header('Location: /Main/Index');
	}
}
