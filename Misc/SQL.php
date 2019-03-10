<?php
class SQL extends PDO{

    public function __construct($file = 'config.ini'){
        try{
            $settings = parse_ini_file("config.ini");
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            ];

            //db settings
            $host = $settings['host'];
            $db   = $settings['db'];
            //login
            $user = $settings['user'];
            $pass = $settings['pass'];

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            parent::__construct($dsn, $user, $pass, $options);
        }catch(PDOException $e){
            throw new PDOException($e -> getMessage(), (int)$e -> getCode());
        }
    }

    public function Query(){
        return new QueryBuilder($this);
    }

}

class QueryBuilder{

    private $table;
    private $select = [];
    private $where = [];
    private $having;
    private $groupby;

    private $PDO;

    public function __construct($_PDO){
        $this->PDO = $_PDO;
    }

    //Please don't pass in two arrays
    public function Where($field, $comparision){
        $this->where->array_push([$field, $comparision]);
        return $this;
    }

    public function Select($field){
        $this->select->array_push($field);
        return $this;
    }

    public function SelectAll(){
        $this->select[] = '*';
        return $this;
    }

    public function Table($tablename){
        if(!is_null($this->table))
            throw new Exception('You can only reference one table in a QueryBuilder');

        $this->table = $tablename;
        return $this;
    }

    public function Execute(){
        //Fields of the SQL statement
        $fromField = " FROM {$this->table}";
        $selectField = $this->buildSelect(count($this->select));
        $whereField = $this->buildWhere(count($this->where));

        $final = $selectField . $fromField . $whereField;

        $stmt = $this->PDO->prepare($final);
        $this->bindValues(':select', $this->select, $stmt);
        $this->bindValues(':where', $this->where, $stmt);

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //Building the string for the prepared statement
    private function buildSelect($count){
        //No values provided, assume all records
        if($count <= 0)
            throw new Exception('Empty select statement');

        $selectField = 'SELECT :select1';
        for ($i=2; $i <= $count; $i++) { 
            $selectField .= ",:select{$i}";
        }

        return $selectField;
    }

    //Assume for now the Where's count is always event
    private function buildWhere($count){
        if($count == 0)
            return '';
        elseif ($count == 2) {
            return  ':where1 IS :where2'; 
        }

        $whereField = '';
        for ($i=1; $i <= $count ; $i += 2) { 
            if($i != $count)
                $whereField .= 'AND';
            $whereField .= ":where{$i} IS :where{$i}";
        }
    }

    //Binding for prepared statement
    private function bindValues($type, $values, &$stmt){
        for ($i=1; $i <= count($values); $i++) { 
            $stmt->bindParam($type.$i, $values[$i - 1]);
        }
    }
}
//Testing, Delete when done
$SQL = new SQL();
$result = $SQL -> query('SELECT * FROM test');
print_r($result);
?>