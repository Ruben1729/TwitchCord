
<?php

class QueryBuilder{

    private $table;
    private $select = [];
    private $where = [];
    private $having = [];
    private $groupby = [];

    private $PDO;

    public function __construct($PDO){
        $this->PDO = $PDO;

    }

    
    // //Hardcoded to only work with MySQL
    // public function Where($comparision){
    //     $this->where[] = $comparision;
    //     return $this;
    // }

    // public function Select(array $field){
    //     $this->select = $field;
    //     return $this;
    // }

    // public function SelectAll(){
    //     $this->select[] = '*';
    //     return $this;
    // }

    // public function From($tablename){
    //     if(!is_null($this->table))
    //         throw new Exception('You can only reference one table in a QueryBuilder');

    //     $this->table = $tablename;
    //     return $this;
    // }

    // public function Execute(){
    //     //Verify that supplied table is inside the database
    //     $fromField = 'FROM ';
    //     if($this->SQLObj->IsValidTable($this->table)){
    //         $fromField .= $this->table . ' ';
    //     }else{
    //         throw new Exception("Table isn't inside database");
    //     }
    //     //Build Select and Where statements
    //     $selectField = $this->buildSelect(count($this->select));
    //     $whereField = $this->buildWhere(count($this->where));
    //     //Feed query string to PDO 
    //     $final = $selectField . $fromField . $whereField;
    //     //Bind any value set
    //     $stmt = $this->PDO->prepare($final);
    //     $this->bindWhere($this->where, $stmt);

    //     $stmt->execute();
    //     //Return PDOStatement so that the user can manipulate it as they need
    //     return $stmt;
    // }

    // //Building the string for the prepared statement
    // private function buildSelect($count){
    //     //No values provided, assume all records
    //     if($count <= 0)
    //         throw new Exception('Empty select statement');
        
    //     foreach($this->select as &$field){
    //         if(!$this->SQLObj->IsValidColumn($field))
    //             throw new Exception("field is not in database");
    //     }
    //     return 'SELECT ' . implode(',', $this->select);
    // }

    // //Assume for now the Where's count is always event
    // private function buildWhere($count){
    //     if($count == 0)
    //         return '';

    //     $whereField = 'WHERE ';
    //     for ($i=1; $i <= $count ; $i += 2) { 
    //         $first = $i;
    //         $second = $i + 1;
    //         $whereField .= ':where' . $first . ' <=> ' . ':where' . $second;
    //     }

    //     return $whereField;
    // }

    // //Binding for prepared statement
    // private function bindWhere($values, &$stmt){
    //     for ($i=1; $i <= count($values); $i++) {
    //         $statement = $values[$i - 1];
    //         $second = $i + 1;
    //         $stmt->bindParam(':where'.$i, $statement[0], $statement[1]);
    //         $stmt->bindParam(':where'.$second, $statement[0], $statement[1]);
    //     }
    // }
}
