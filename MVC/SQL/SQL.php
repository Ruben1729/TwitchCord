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
            $user   = $settings['user'];
            $pass   = $settings['pass'];

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, $options);
            $obj = new SQL($pdo);

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
}

