<?php

require_once('QueryBuilder.php');
require_once('InsertBuilder.php');

/*// //Example Usage
require_once('../Models/PHP/UserModel.inc.php');
$SQL = SQL::GetConnection();
$Model = new User('1', 'test2', 'test@email.com', 'myPassHash');
$result =
    $SQL
    ->Modify()
    ->Submit($Model);
    // ->GetAs('UserModel');

// See the output of the query
var_dump($result);*/

class SQL{

    private $pdo;
    private $allowedTables = [];
    private $allowedColumns = ['*' => true];

    //Static class for connection setup
    public static function GetConnection($file = '../MVC/config.ini'){
        try{
            $settings = parse_ini_file($file);
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            //db settings
            $host   = $settings['host'];
            $db     = $settings['db'];
            //login
            $user = $settings['user'];
            $pass = $settings['pass'];

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, $options);
            $obj = new SQL($pdo);
            //Store information about the DB for checking
            $obj->GetAllColumns($db);
            $obj->GetAllTables($db);
            return $obj;
        }catch(PDOException $e){
            throw new PDOException($e -> getMessage(), (int)$e -> getCode());
        }
    }

    private function __construct($PDO){
        $this->pdo = $PDO;
    }

    public function Search(){
        return new QueryBuilder($this->pdo, $this);
    }

    public function Modify(){
        return new InsertBuilder($this->pdo);
    }

     public function IsValidColumn($field){
         return array_key_exists($field, $this->allowedColumns);
     }

    public function IsValidTable($field){
        return array_key_exists($field, $this->allowedTables);
    }

    function GetAllColumns($dbname){
        $queryString = "select COLUMN_NAME from information_schema.columns where table_schema = '$dbname' order by table_name,ordinal_position";
        $queryColumn = 'COLUMN_NAME';

        foreach ($this->pdo->query($queryString) as $row) {
            $this->allowedColumns[$row[$queryColumn]] = true;
        }
    }

    function GetAllTables(string $dbname){
        $queryString = "SELECT table_name FROM information_schema.tables WHERE table_type = 'base table' AND table_schema='$dbname'";
        $queryColumn = 'table_name';

        foreach ($this->pdo->query($queryString) as $row) {
            $this->allowedTables[$row[$queryColumn]] = true;
        }
    }


}

