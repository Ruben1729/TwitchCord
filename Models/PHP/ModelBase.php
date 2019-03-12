<?php

class Model{

    private $tableName;
    private $dbFields; 
    
    public function getDBName() : string {
        return $this->tableName;
    }

    public function getDBFields() : array {
        return $this->dbFields;
    }

    public function getAmountOfFields() : int {
        return count($this->dbFields);
    }

    private function setDBName(string $table){
        $this->tableName = $table;
    }

    private function setDBfields(array $array){
        $this->dbFields = $array;
    }

}