<?php

class Model{

    public function getDBName() {
        return get_class($this);
    }

    public function getDBFields() {
        return get_object_vars($this);
    }

    public function getNumOfFields() {
        return count($this->getDBFields());
    }

    function setDBName($table){
        $this->tableName = $table;
    }

    function setDBfields(array $array){
        $this->dbFields = $array;
    }

    //Constants for DB Queries
    const USER = 1;
    const PROFILE = 2;
}