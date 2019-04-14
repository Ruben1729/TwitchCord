<?php 
    $uid = isset($_SESSION[uid]) ? $_SESSION[uid] : null;
?>
<link rel="stylesheet" href="/CSS/NavBar.css">
<div id="navigation">
    <ul class="navbar">
        <li class="nav-item left"><a href="/Main/Index">TwitchCord</a></li>
        <?php if($uid != null){?>
            <div class="dropdown right">
                <div class="dropProfile">
                    <img class="left" src="/Pictures/default.png">
                    <h3 class="left"><?= $_SESSION[username] ?></h3>
                </div>
                <div class="dropdown-content">
                    <a href="/User/Logout">Logout</a>
                    <a href="/Profile/Settings">Profile</a>
                    <a href="/Channel/Dashboard">Channel</a>
                    <a href="/Community/Index">Community</a>
                </div>
            </div>
        <?php }else{?>
            <li class="nav-item right"><a href="/User/Register">Register</a></li>
        	<li class="nav-item right"><a href="/User/Login">Login</a></li>
        <?php } ?>
    </ul>
</div>