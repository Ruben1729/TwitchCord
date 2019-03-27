<!DOCTYPE html>
<html lang="en">

<?php 
    session_start();
    $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : null;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">TwitchCord</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php if($uid != null){?>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">

        </ul>
    </div>
    <?php }else{ ?>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="btn btn-light" href="#">Login</a>
        </li>
        <li class="nav-item">
            <a class="btn btn-dark" href="#">Register</a>
        </li>
    </ul>
    </div>
    <?php } ?>
</nav>