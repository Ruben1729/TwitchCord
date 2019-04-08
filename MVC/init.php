<?php
	
	session_start();

    //better to use constants for session, incase we change our mind
    const username = "username";
    const uid = "uid";

    require_once 'Core/App.php';
    require_once 'Core/Controller.php';
    require_once 'Core/Helper.php';
?>