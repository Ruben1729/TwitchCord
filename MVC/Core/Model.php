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
}