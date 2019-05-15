<?php
ini_set('html_errors', false);
session_start();

//better to use constants for session, incase we change our mind
const username = "username";
const uid = "uid";

require_once 'Core/App.php';
require_once 'Core/Controller.php';
require_once 'Core/Helper.php';
include_once 'SQL/SQL.php';
