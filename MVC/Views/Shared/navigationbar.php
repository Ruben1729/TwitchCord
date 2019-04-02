<?php 
    $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : null;
?>
<link rel="stylesheet" href="/CSS/NavBar.css">
<div id="navigation">
    <ul>
        <li class="left"><a href="/Main/Index">TwitchCord</a></li>
        <?php if($uid == null) :?>
        	<li class="right"><a href="/User/Register">Register</a></li>
        	<li class="right"><a href="/User/Login">Login</a></li>
    	<?php endif;?>
    </ul>
</div>

<script>
    window.addEventListener("load", function() {
        var elem = document.querySelector("#navigation");

        elem.style.transition = '0.5s';
        elem.style.opacity = '1';
    })
</script>