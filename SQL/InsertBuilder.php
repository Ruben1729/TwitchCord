<?php

    class InsertBuilder extends Builder{

        private $pdo;

        public function __construct($PDO)
        {
            $this->pdo = $PDO;
        }

        public function Insert(Model $model){
            $fields = $model->getDBFields();
            //Setup query string
            $properties = implode(',', array_keys($fields));
            $placeholders = str_repeat(' ?, ', count($model->getAmountOfFields()));
            $tableName = $model->getDBName();
            $query = "INSERT INTO $tableName ($properties) VALUES ($placeholders)";
            //prepare and Bind values
            $stmt = $this->pdo->prepare($query);
            $this->BindValues(array_values($fields), $stmt);
            //Return execute's status (bool)
            return $stmt->execute();
        }

        private function BindValues(array $values, PDOStatement &$stmt){
            for($i = 1; $i <= count($values); $i++){
                $value = $values[$i - 1];
                $stmt->bindValue($i, $value, $this->GetPDOType($value));
            }
        }

        public function Update(){
            
        }
    }