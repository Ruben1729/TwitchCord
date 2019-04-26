<?php

interface iSQLQueryable
{
    public static function DBName();
}

class Model
{
    public function getDBFields()
    {
        //Hoping that the object contains the same properties as the columns in the database
        return get_object_vars($this);
    }

    public function getNumOfFields()
    {
        return count($this->getDBFields());
    }

    public function Set($data)
    {
        foreach ($data as $key => $value) $this->{$key} = $value;
        return $this;
    }

    public function Submit()
    {
        $SQL = SQL::GetConnection();
        $SQL
            ->Modify()
            ->Submit($this);
    }
}
