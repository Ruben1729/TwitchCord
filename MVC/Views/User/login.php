<?php 

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
		<main>
			<form id="login-form" action="Login" method="post">
				<h1>Welcome Back!</h1>
				<div id="userinput">
					<div id="input-container">
						<div <?php if(!empty($uidError)) echo "id=\"error\""?> ><label for="uid">Username</label> <?php if(!empty($uidError)) echo " - $uidError" ?></div>
						<input <?php if(!empty($uidError)) echo "id=\"inerror\""?> type="text" name="uid">
					</div>
					<div id="input-container">

						<div <?php if(!empty($pwdError)) echo "id=\"error\""?> ><label for="pwd">Password</label> <?php if(!empty($pwdError))echo " - $pwdError"?></div>
						<input <?php if(!empty($pwdError)) echo "id=\"inerror\"" ?> type="password" name="pwd">

						<a id="forgot-pwd">Forgot your password?</a>
					</div>
					
				</div>


				<button type="submit" name="login-btn">Login</button>

				<div>Don't have an account yet? <a href="Register">Register!</a></div>
			</form>
			
		</main>
	</body>
	<footer>
	</footer>
</html>