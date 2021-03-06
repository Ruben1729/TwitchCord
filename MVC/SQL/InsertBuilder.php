<?php

require_once('Builder.php');

class InsertBuilder extends Builder
{

    private $pdo;

    public function __construct($PDO)
    {
        $this->pdo = $PDO;
    }

    public function Submit(Model $model)
    {
        $fields = $model->getDBFields();
        //Setup query string
        $properties = implode(',', array_keys($fields));
        $placeholders = '';
        //create placeholder strings (?, ?, ?)
        $count = $model->getNumOfFields();
        for ($i = 0; $i <  $count; $i++) {
            $placeholders .= '?';
            if ($i < $count - 1)
                $placeholders .= ',';
        }
        $tableName = $model->DBName();
        $query = "REPLACE INTO $tableName ($properties) VALUES ($placeholders)";
        //prepare and Bind values
        $stmt = $this->pdo->prepare($query);
        $this->BindValues(array_values($fields), $stmt);
        $status = $stmt->execute();
        $last_id = $this->pdo->lastInsertId();
        //Return the last inserted ID
        return $last_id;
    }

    private function BindValues(array $values, PDOStatement &$stmt)
    {
        for ($i = 1; $i <= count($values); $i++) {
            $value = $values[$i - 1];
            $stmt->bindValue($i, $value, $this->GetPDOType($value));
        }
    }
}
