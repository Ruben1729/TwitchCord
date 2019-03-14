<?php

    class Builder{

        public function GetPDOType($value){
            switch(gettype($value)){
                case 'boolean':
                    return PDO::PARAM_BOOL;
                case 'integer':
                    return PDO::PARAM_INT;
                case 'double':
                    return PDO::PARAM_INT;
                case 'string':
                    return PDO::PARAM_STR;
                default:
                    return PDO::PARAM_STR;
            }
        }
    }