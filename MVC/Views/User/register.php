<?php
	
	if(array_key_exists('userError', $data))
		$uidError = $data['userError'];

	if(array_key_exists('emailError', $data))
		$mailError = $data['emailError'];

	if(array_key_exists('passwordError', $data))
		$pwdError = $data['passwordError'];

	if(array_key_exists('passwordRepeatError', $data))
		$pwdRepeatError = $data['passwordRepeatError'];

	if(array_key_exists('uid', $data))
		$username = $data['uid'];

	if(array_key_exists('email', $data))
		$email = $data['email'];

?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="description" content="Header for the main page after the user has logged in.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<link rel="stylesheet" href="/CSS/Form.css">
		<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<title>TwitchCord</title>
	</head>
	<body>
		
		<video playsinline autoplay muted loop id="bgvid">
		    <source src="/Clips/allclips.mp4" type="video/mp4">
		</video>

		<main <?php if(array_key_exists('reload', $data)) echo "class=\"mainError\""?>class="main-form">
			<form class="register-form" action="Register" method="post">
				<a id="homePage" href="/Main/Index"><i class="fa fa-home"></i></a>
				<h1>Create Account</h1>
				<div class="userinput">

					<div class="input-container">
						<div <?php if(!empty($uidError)) echo "class=\"error\""?> ><label for="uid">Username *</label> <?php if(!empty($uidError)) echo " - <span class=\"spanError\">$uidError</span>" ?></div>
						<input <?php if(!empty($uidError)) echo "class=\"inerror\""; if(!empty($username)) echo "value=\"$username\"" ?> type="text" name="uid">
					</div>

					<div class="input-container">
						<div <?php if(!empty($mailError)) echo "class=\"error\""?> ><label for="email">E-mail *</label> <?php if(!empty($mailError)) echo " - <span class=\"spanError\">$mailError</span>" ?></div>
						<input <?php if(!empty($mailError)) echo "class=\"inerror\""; if(!empty($email)) echo "value=\"$email\"" ?> type="text" name="email">
					</div>

					<div class="input-container">
						<div <?php if(!empty($pwdError)) echo "class=\"error\""?> ><label for="pwd">Password *</label> <?php if(!empty($pwdError)) echo " - <span class=\"spanError\">$pwdError</span>" ?></div>
						<input <?php if(!empty($pwdError)) echo "class=\"inerror\""?> type="password" name="pwd">
					</div>

					<div class="input-container">
						<div <?php if(!empty($pwdRepeatError)) echo "class=\"error\""?> ><label for="pwd-repeat">Re-enter Password *</label> <?php if(!empty($pwdRepeatError)) echo " - <span class=\"spanError\">$pwdRepeatError</span>" ?></div>
						<input <?php if(!empty($pwdRepeatError)) echo "class=\"inerror\""?> type="password" name="pwd-repeat">
					</div>

				</div>

				<button type="submit" name="register-btn">Register</button>
				<div>Already have an account? <a href="Login">Login</a></div>
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

				if(reload)
				{

					var elem = document.querySelector(".main-form");
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