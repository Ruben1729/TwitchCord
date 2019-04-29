<?php
include 'Verify.php';

class Controller
{
    public function model($model)
    {
        require_once '../MVC/Models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once '../MVC/Views/' . $view . '.php';
    }

    public function send($data, $header = 'Content-Type: application/json')
    {
        header($header);
        echo json_encode($data);
    }
}
