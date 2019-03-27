<?php 
	
	if(array_key_exists('userError', $data))
		$uidError = $data['userError'];

	if(array_key_exists('passwordError', $data))
		$pwdError = $data['passwordError'];

	if(array_key_exists('uid', $data))
		$username = $data['uid'];

?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="description" content="Header for the main page after the user has logged in.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<link rel="stylesheet" href="/CSS/UserAccessForm.css">

		<title>TwitchCord</title>
	</head>
	<body>
		<main <?php if(array_key_exists('reload', $data)) echo "class=\"mainError\""?> id="main-form">
			<form id="login-form" action="Login" method="post">
				<h1>Welcome Back!</h1>
				<div id="userinput">
					<div id="input-container">
						<div <?php if(!empty($uidError)) echo "id=\"error\""?> ><label for="uid">Username</label> <?php if(!empty($uidError)) echo " - <span id=\"err\">$uidError</span>" ?></div>
						<input <?php if(!empty($uidError)) echo "id=\"inerror\""; if(!empty($username)) echo "value=\"$username\"" ?>  type="text" name="uid">
					</div>
					<div id="input-container">

						<div <?php if(!empty($pwdError)) echo "id=\"error\""?> ><label for="pwd">Password</label> <?php if(!empty($pwdError))echo " - <span id=\"err\">$pwdError</span>"?></div>
						<input <?php if(!empty($pwdError)) echo "id=\"inerror\"" ?> type="password" name="pwd">

						<a id="forgot-pwd">Forgot your password?</a>
					</div>
					
				</div>


				<button type="submit" name="login-btn">Login</button>

				<div>Don't have an account yet? <a href="Register">Register!</a></div>
			</form>
			
		</main>

		<script>
			window.addEventListener("load", function() {

				var reload = <?php 
				if(!array_key_exists('reload', $data))
					echo "true";
				else
					echo "false";
				?>;

				if(reload){

					var elem = document.querySelector("#main-form");
					elem.style.top = '50%';
					elem.style.transition = '0.5s';
					elem.style.opacity = '1';

				}

			})
		</script>

	</body>
	<footer>
	</footer>
</html>