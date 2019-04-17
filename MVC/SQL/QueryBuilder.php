
<?php
require_once('Builder.php');

class QueryBuilder extends Builder
{

    //SQL items
    private $fields = ['*'];
    private $selectedModel;
    private $joinUsing = [];
    private $where = [];
    private $distinct = false;

    //Classes
    private $PDO;
    private $SQL;

    public function __construct($PDO, $SQL)
    {
        $this->PDO = $PDO;
        $this->SQL = $SQL;
    }

    public function Model($modelName)
    {
        $this->selectedModel = $modelName;
        return $this;
    }

    public function Distinct()
    {
        $this->distinct = true;
        return $this;
    }

    public function Fields(array $items)
    {
        $this->fields = $items;
        return $this;
    }

    public function JoinUsing($joinType, $modelName, $field)
    {
        array_push($this->joinUsing, $joinType, $modelName, $field);
        return $this;
    }

    // public function JoinOn($type, $modelID, $field, $field2){
    //     $modelName = Model::GetModelName($modelID);
    //     array_push($this->join, $type, $modelName, $field, $field2);
    //     return $this;
    // }

    public function Where($field, $comparision, $operator = '<=>', $joiner = 'AND')
    {
        array_push($this->where, $field, $comparision, $operator, $joiner);
        return $this;
    }

    public function GetAll($PDO_TYPE = PDO::FETCH_ASSOC)
    {
        return $this->Execute()->fetchAll($PDO_TYPE);
    }

    public function Get($PDO_TYPE = PDO::FETCH_OBJ)
    {
        return $this->Execute()->fetch($PDO_TYPE);
    }

    public function GetAsObj($model = null)
    {
        if ($model == null)
            $model = $this->selectedModel;
        return $this->Execute()->fetchObject($model);
    }

    private function Execute()
    {
        $query = $this->BuildString();
        $stmt = $this->PDO->prepare($query);
        //Bind values
        $this->BindValues(':where', $this->where, $stmt);
        $stmt->execute();
        return $stmt;
    }

    private function BuildString()
    {
        $query = $this->BuildSelect();
        //Add table
        $query .= " FROM {$this->selectedModel} ";
        if (!empty($this->joinUsing))
            $query .= $this->BuildJoinUsing();
        if (!empty($this->where))
            $query .= $this->BuildStatement('WHERE', ':where', $this->where);
        return $query;
    }

    private function BuildJoinUsing()
    {
        $query = '';
        //incrementing by 4 because there are four fields (join type, joining model, )
        for ($i = 0; $i < count($this->joinUsing); $i += 3) {
            $joinType = $this->joinUsing[$i];
            $joinModel = $this->joinUsing[$i + 1];
            $field = $this->joinUsing[$i + 2];

            $query .= "$joinType $joinModel USING ($field) ";
        }
        return $query;
    }

    //Fields should never be user-inputed
    private function BuildSelect()
    {
        //Optional Distinct
        return 'SELECT ' . ($this->distinct ? 'DISTINCT' : '') . implode(',', $this->fields);
    }

    //Potential to be used by another statement like 'HAVING'
    private function BuildStatement($type, $placeholder, $array)
    {
        $query = "$type ";
        //incrementing by 3 because there are two conditions and operator to add into the statement
        for ($i = 0; $i < count($array); $i += 4) {
            $operator = $array[$i + 2];
            $joiner = $array[$i + 3];
            //Insert field
            $field = strtolower($array[$i]);

            //insert comparision to EX: WHERE <=> :placeholder
            $query .= "$field $operator $placeholder" . ($i + 1) . ' ';

            if ($i < count($array) - 4)
                $query .= "$joiner ";
        }
        return $query;
    }

    private function BindValues($placeholder, $array, &$stmt)
    {
        for ($i = 0; $i < count($this->where); $i += 4) {
            //First variable inside array is the field (WHERE)
            $stmt->bindValue($placeholder . ($i + 1), $array[$i + 1], $this->GetPDOType($array[$i + 1]));
        }
    }
}
