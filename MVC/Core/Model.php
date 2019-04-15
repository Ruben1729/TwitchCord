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

    public function Set($data){
        foreach ($data as $key => $value) $this->{$key} = $value;
        return $this;
    }

    public function Submit(){
        $SQL = SQL::GetConnection();
        $SQL
        ->Modify()
        ->Submit($this);
    }
}