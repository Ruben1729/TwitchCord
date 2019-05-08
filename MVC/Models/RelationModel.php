<?php
include_once '../MVC/Core/Model.php';
include_once '../MVC/SQL/SQL.php';

class RelationModel extends Model implements iSQLQueryable
{

	public static function DBName()
	{
		return 'Relation';
	}

	public $user_id;
	public $user_id_1;
	public $status_id;

  public function checkIfFriends($uid, $fid){

    $SQL = SQL::GetConnection();
        $result = $SQL->Query(
            "SELECT *
            FROM Relation
            WHERE (user_id_1 = ? AND user_id = ?)
            OR (user_id = ? AND user_id_1 = ?)", [$uid, $fid, $uid, $fid]);
        return $result;
  }

  public function getAllRelations($id) {
    $SQL = SQL::GetConnection();
    $result = $SQL->Query(
        "SELECT * FROM Relation
         WHERE user_id = ? OR user_id_1 = ?", [$id, $id]);
    return $result;
  }

	public function getAllFriends($id){

		$SQL = SQL::GetConnection();
        $result = $SQL->Query(
            "SELECT user_id, username, path, status_id
            FROM 
            (
                          SELECT user_id, status_id
                          FROM relation
                          WHERE user_id_1 = ?
            
                          UNION 
            
                          SELECT user_id_1, status_id
                          FROM relation
                          WHERE user_id = ?
            )a
            INNER JOIN user USING (user_id)
            LEFT JOIN profile USING (user_id)
            LEFT JOIN picture USING (picture_id)", [$id, $id]);
        return $result;
	}
}