<?php

class Main extends Controller
{
    public function Index(){
      $data['friend_list'] = null;
      $relation_list = null;

      if(ISSET($_SESSION['uid'])){
        $relation_list = $this->model('RelationModel')->getAllFriends($_SESSION['uid']);
        $friend_list = [];
        $request_list = [];

        foreach($relation_list as $person) {
          if($person['status_id'] == 1){
            if(!empty($this->model('RelationModel')->getRelation($person['user_id'], $_SESSION['uid'])))
              array_push($request_list, $person);
          } else if ($person['status_id'] == 2){
            array_push($friend_list, $person);
          }
        }
      }
      $data['friend_list'] = null;
      $data['request_list'] = null;
      if(!empty($friend_list)){
        $data['friend_list'] = $friend_list;
      }
      if(!empty($request_list)){
        $data['request_list'] = $request_list;
      }
    
      $this->view('Main/index', $data);
    }

    public function Test()
    {
        $SQL = SQL::GetConnection();
        $result = $SQL->Query(
            "SELECT user_id, username, path
            FROM 
            (
                          SELECT user_id
                          FROM relation
                          WHERE user_id_1 = ?
            
                          UNION 
            
                          SELECT user_id_1
                          FROM relation
                          WHERE user_id = ?
            )a
            INNER JOIN user USING (user_id)
            LEFT JOIN profile USING (user_id)
            LEFT JOIN picture USING (picture_id)",
            [1, 1]
        );
        var_dump($result);
    }
}
