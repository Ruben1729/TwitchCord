
<?php
require_once('Builder.php');

class QueryBuilder extends Builder
{

    //SQL items
    private $fields = ['*'];
    private $table;
    private $joinUsing = [];
    private $where = [];
    private $distinct = false;

    //Classes
    private $PDO;
    private $SQL;

    //PHP Model
    private $modelName;

    public function __construct($PDO, $SQL)
    {
        $this->PDO = $PDO;
        $this->SQL = $SQL;
    }

    /**
     * Select a model to use as table
     *
     * @param [mixed] $modelName the name of the model object
     * @return QueryBuilder to chain function calls
     */
    public function Model($modelName)
    {
        //This is kind of a big hack.
        //Check that the object (from the string provided) contains the proper interface
        require_once '../MVC/Models/' . $modelName . '.php';

        if (!(new $modelName() instanceof iSQLQueryable))
            throw new Exception("Provided model doesn't contain method to get Database table equivalent, did you mean to use 'Table'?");

        //Get the proper Database name from the model
        $this->table = $modelName::DBName();

        //Store model for later
        $this->modelName = $modelName;
        return $this;
    }

    /**
     * Select the table used for SQL
     *
     * @param [mixed] $table name of the table
     * @return QueryBuilder to chain function calls
     */
    public function Table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * SQL results returned will be executed as if there is the 'DISTINCT' keyword
     *
     * @return QueryBuilder to chain function calls
     */
    public function Distinct()
    {
        $this->distinct = true;
        return $this;
    }

    /**
     * Fields to be returned from SQL Query
     *
     * @param array $fields
     * @return QueryBuilder to chain function calls
     */
    public function Fields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Join two tables using a common field
     *
     * @param [type] $joinType
     * @param [type] $modelName
     * @param [type] $field
     * @return void
     */
    public function JoinUsing($joinType, $table, $field)
    {
        array_push($this->joinUsing, $joinType, $table, $field);
        return $this;
    }

    // public function JoinOn($type, $modelID, $field, $field2){
    //     $modelName = Model::GetModelName($modelID);
    //     array_push($this->join, $type, $modelName, $field, $field2);
    //     return $this;
    // }


    /**
     * Filter results based on comparision
     *
     * @param [type] $field field to compare
     * @param [type] $variable variable provided to compare
     * @param string $operator comparison operator
     * @param string $type type of comparision (AND, OR) 
     * @return void
     */
    public function Where($field, $variable, $operator = '<=>', $type = 'AND')
    {
        array_push($this->where, $field, $variable, $operator, $type);
        return $this;
    }

    /**
     * Return all results as PDO fetch type.
     * Defaults to PDO::FETCH_ASSOC 
     * Possible arguments: @link https://php.net/manual/en/pdostatement.fetch.php
     *
     * @param [type] $PDO_TYPE
     * @return void
     */
    public function GetAll($PDO_TYPE = PDO::FETCH_ASSOC)
    {
        return $this->Execute()->fetchAll($PDO_TYPE);
    }

    /**
     * Get a single record from results
     * Defaults to PDO::FETCH_OBJ 
     * Possible arguments: @link https://php.net/manual/en/pdostatement.fetch.php
     * 
     * @param [type] $PDO_TYPE
     * @return void
     */
    public function Get($PDO_TYPE = PDO::FETCH_OBJ)
    {
        return $this->Execute()->fetch($PDO_TYPE);
    }

    /**
     * Return first record as a model (php object)
     * Due to fetchObject injecting variables before invoking the constructor, this function has the same effect
     * 
     * if no model is specified, it will try to return as the model set earlier or stdClass
     * @param [type] $model name of model to use
     * @return Model
     */
    public function GetAsObj($model = null)
    {
        if ($model == null && $this->modelName)
            $model = $this->modelName;
        else
            $model = 'stdClass';
        return $this->Execute()->fetchObject($model);
    }

    private function Execute()
    {
        $query = $this->BuildString();
        $stmt = $this->PDO->prepare($query);
        //Bind values
        $this->BindValues(':where', $this->where, $stmt);
        $stmt->execute();
        //Return $stmt for 'Get' Functions
        return $stmt;
    }

    private function BuildString()
    {
        $query = $this->BuildSelect();
        //Add table
        $query .= " FROM {$this->table} ";
        //Add other statements if available
        if (!empty($this->joinUsing))
            $query .= $this->BuildJoinUsing();
        if (!empty($this->where))
            $query .= $this->BuildStatement('WHERE', ':where', $this->where);
        return $query;
    }

    private function BuildJoinUsing()
    {
        $query = '';
        //incrementing by 3 because there are 3 fields (join type, joining model, field)
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
        //incrementing by 4 because there are two conditions, an operator and a  to add into the statement
        for ($i = 0; $i < count($array); $i += 4) {
            $operator = $array[$i + 2];
            $type = $array[$i + 3];
            //Insert field
            $field = strtolower($array[$i]);

            //insert comparision to EX: WHERE <=> :placeholder
            $query .= "$field $operator $placeholder" . ($i + 1) . ' ';

            if ($i < count($array) - 4)
                $query .= "$type ";
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
