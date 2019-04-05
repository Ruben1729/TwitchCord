
<?php
require_once('Builder.php');

    class QueryBuilder extends Builder {

        //SQL items
        private $selectedModel;
        private $join = []; // JOIN works like this EX: (selected model) a (JOIN TYPE) (Other Model) b ON a.(field) = b.(field) 
        private $where = [];

        //Classes
        private $PDO;
        private $SQL;

        //constants
        private $FIELD = 0;
        private $COMPARISION = 1;

        public function __construct($PDO, $SQL){
            $this->PDO = $PDO;
            $this->SQL = $SQL;
        }

        public function Model($modelName){
            $this->selectedModel = $modelName;
            return $this;
        }

        public function JoinUsing($joinType, $modelName, $field){
            //Duplicate with is to replicate ON functionality since Using is Syntactic sugar
            array_push($this->join, $joinType, $modelName, $field, $field);
            return $this;
        }

        public function JoinOn($type, $modelID, $field, $field2){
            $modelName = Model::GetModelName($modelID);
            array_push($this->join, $type, $modelName, $field, $field2);
            return $this;
        }

        public function Where($field, $comparision){
            array_push($this->where, $field, $comparision);
            return $this;
        }

        public function Get(){
            return $this->Execute()->fetchAll();
        }

        public function GetAsObj(){
            return $this->Execute()->fetchObject($this->selectedModel);
        }

        private function Execute(){
            $query = $this->BuildString();
            print $query;
            $stmt = $this->PDO->prepare($query);
            //Bind values
            $this->BindValues(':where', $this->where, $stmt);
            $stmt->execute();
            return $stmt;
        }

        private function BuildString(){
            $query = "SELECT * FROM {$this->selectedModel} ";
            if(!empty($this->join))
                $query .= $this->BuildJoin();
            if(!empty($this->where))
                $query .= $this->BuildStatement('WHERE', ':where', '<=>', 'AND', $this->where);
            return $query;
        }

        private function BuildJoin(){
            $query = 'a ';
            $alias = 'a';
            //incrementing by 4 because there are four fields (join type, joining model, )
            for ($i=0; $i < count($this->join); $i+= 4) { 
                $joinType = $this->join[$i];
                $joinModel = $this->join[$i + 1];
                $field1 = strtolower($this->join[$i + 2]);
                $field2 = strtolower($this->join[$i + 3]);
                $currentAlias = ++$alias;

                $query .= "$joinType $joinModel $currentAlias ON a.$field1 = $currentAlias.$field2 ";
            }
            return $query;
        }

        private function BuildStatement($type, $placeholder, $operator, $joiner, $array){
            $query = "$type ";
            //incrementing by 2 because there are two conditions to add into the statement
            for($i= 0; $i < count($array); $i+= 2){
                //Insert field
                $field = strtolower($array[$i]);
                $query .= " $field ";
                
                //insert comparision to EX: WHERE <=> :placeholder
                $query .= " $operator  $placeholder" . ($i + 1) . ' ';
                
                if($i < count($array) - 2)
                    $query .= " $joiner ";
            }
            return $query;
        }

        private function BindValues($placeholder, $array, &$stmt){
            for($i= 0; $i < count($this->where) / 2; $i++){
                //First variable inside array is the field (WHERE)
                $stmt->bindValue($placeholder . ($i + 1), $array[$i + 1], $this->GetPDOType($array[$i + 1]));
            }
        }
}
