<?php 
    $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : null;
?>
<link rel="stylesheet" href="/CSS/NavBar.css">
<div id="navigation">
    <ul class="navbar">
        <li class="nav-item left"><a href="/Main/Index">TwitchCord</a></li>
        <?php if($uid != null){?>
            <li class="nav-item right"><a href="/User/Logout">Logout</a></li>
            <li class="nav-item right"><a href="/Profile">Profile</a></li>
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