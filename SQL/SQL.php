<?php

require_once('QueryBuilder.php');

class SQL{

    private $pdo;
    private $allowedTables;
    private $allowedColumns = ['*' => true];

    public static function GetConnection($file = 'config.ini'){
        try{
            $settings = parse_ini_file("config.ini");
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            //db settings
            $host   = $settings['host'];
            $db     = $settings['db'];
            $engine = $settings['engine'];
            //login
            $user = $settings['user'];
            $pass = $settings['pass'];

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
        return new QueryBuilder($this->pdo);
    }

    public function Modify(){
        return new InsertBuilder($this->pdo);
    }

    // public function IsValidColumn($field){
    //     return array_key_exists($field, $this->allowedColumns);
    // }

    // public function IsValidTable($field){
    //     return array_key_exists($field, $this->allowedTables);
    // }

    // private function GetAllTables(string $SQLType, string $dbname){
    //     $queryString = '';
    //     $queryColumn = '';
    //     switch ($SQLType) {
    //         case 'MySQL':
    //             $queryString = "SELECT table_name FROM information_schema.tables WHERE table_type = 'base table' AND table_schema='$dbname'";
    //             $queryColumn = 'table_name';
    //             break;            
    //         default:
    //             throw new Exception('SQL Engine not implemented');
    //             break;
    //     }
    //     foreach ($this->pdo->query($queryString) as $row) {
    //         $this->allowedTables[$row[$queryColumn]] = true;
    //     }
    // }

    // private function GetAllColumns(string $SQLType, string $dbname){
    //     $queryString = '';
    //     $queryColumn = '';
    //     switch ($SQLType) {
    //         case 'MySQL':
    //             $queryString = "select COLUMN_NAME from information_schema.columns where table_schema = '$dbname' order by table_name,ordinal_position";
    //             $queryColumn = 'COLUMN_NAME';
    //             break;            
    //         default:
    //             throw new Exception('SQL Engine not implemented');
    //             break;
    //     }
    //     foreach ($this->pdo->query($queryString) as $row) {
    //         $this->allowedColumns[$row[$queryColumn]] = true; 
    //     }
    // }
}
