<?php 
    $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : null;
?>
<link rel="stylesheet" href="/CSS/NavBar.css">
<div id="navigation">
    <ul class="navbar">
        <li class="nav-item left"><a href="/Main/Index">TwitchCord</a></li>
        <?php if($uid != null){?>
            <li class="nav-item right"><a href="/User/Logout">Logout</a></li>
<<<<<<< HEAD
            <li class="nav-item right"><a href="/Profile">Profile</a></li>
            <li class="nav-item right"><a href="/Community/Index">Community</a></li>
=======
            <li class="nav-item right"><a href="/Profile/Settings">Profile</a></li>
            <li class="nav-item right"><a href="/Channel/Dashboard">Channel</a></li>
>>>>>>> cebe2ae784199c2324b0c58883030519e199fe45
        <?php }else{?>
            <li class="nav-item right"><a href="/User/Register">Register</a></li>
        	<li class="nav-item right"><a href="/User/Login">Login</a></li>
        <?php } ?>
    </ul>
</div>

<!-- I think it looks ugly for the navbar to flash in -->
<!-- <script>
    window.addEventListener("load", function() {
        var elem = document.querySelector("#navigation");

        elem.style.transition = '0.5s';
        elem.style.opacity = '1';
    })
</script> -->