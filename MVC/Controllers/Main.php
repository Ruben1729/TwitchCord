<?php

class Main extends Controller
{
    public function Index(){
      $data['friend_list'] = null;

      if(ISSET($_SESSION['uid']))
        $data['friend_list'] = $this->model('RelationModel')->getAllFriends($_SESSION['uid']);

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
