<?php
class SQL{

    public static function GetConnection(){
        try{
            $settings = parse_ini_file("config.ini");
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $host = $settings['host'];
            $db   = $settings['db'];
            $user = $settings['user'];
            $pass = $settings['pass'];

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            return new PDO($dsn, $user, $pass, $options);
        }catch(PDOException $e){
            throw new PDOException($e -> getMessage(), (int)$e -> getCode());
        }
    }

}
?>