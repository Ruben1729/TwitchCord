<?php
	
	class Relation extends Controller{
		public function Add(){
			echo "this works beep boop";
		}
		public function POST_Add(){
			verifyLoggedIn();
			echo $_POST['userData'];
			echo $this->model('RelationModel')
					->Set(['user_id' => $_SESSION['uid'], 'user_id_1' => $_POST['userData'], 'status_id' => 1])
					->Submit();
		}
		public function AddFriend(){
			echo "this works beep boop";
		}
		public function POST_AddFriend(){
			verifyLoggedIn();
			echo $_POST['userData'];
			$query = "UPDATE relation 
					SET status_id = 2 
					WHERE user_id = ? AND user_id_1 = ?";
			$SQL = SQL::GetConnection();
			$allUserData = $SQL->Query($query, [$_SESSION['uid'], $_POST['userData']]);
			header("Location: /Main/index");
		}
		public function SearchUser(){
			verifyLoggedIn();
			$findUser = $_GET['username'];
			$uid = $_SESSION[uid];

			$query = "SELECT user.username, user.user_id, picture.path 
						FROM user 
						LEFT JOIN profile 
						ON user.user_id = profile.user_id 
						LEFT JOIN picture 
						ON picture.picture_id = profile.picture_id
						WHERE user.user_id != ?";

			$SQL = SQL::GetConnection();
			$allUserData = $SQL->Query($query, [$uid]);

			$userList = [];

			foreach($allUserData as $user){
				if(strpos($user['username'], $findUser) !== false){
					array_push($userList, $user);
				}
			}

			for($x = 0; $x < count($userList); $x ++) {
				$relationList = $this->model('RelationModel')->checkIfFriends($_SESSION['uid'], $userList[$x]['user_id']);
				if(!empty($relationList)){
					$userList[$x]['isAdded'] = true;
				} else {
					$userList[$x]['isAdded'] = false;
				}
			}

	        header('Content-Type: application/json');
	        echo json_encode($userList);
		}

		public function POST_SearchUser(){
			verifyLoggedIn();
			$this->view('Relation/SearchUser');
		}
	}