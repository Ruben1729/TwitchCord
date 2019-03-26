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
			<form action="Register" method="post">
				<h1>Create Account</h1>
				<div id="userinput">
					<div id="input-container">
						<label for="uid">Username</label>
						<input type="text" name="uid">
					</div>
					<div id="input-container">
						<label for="email">E-mail</label>
						<input type="text" name="email">
					</div>
					<div id="input-container">
						<label for="pwd">Password</label>
						<input type="password" name="pwd">
					</div>
					<div id="input-container">
						<label for="pwd-repeat">Repeat Password</label>
						<input type="password" name="pwd-repeat">
					</div>
				</div>

				<button type="submit" name="register-btn">Register</button>
				<div>Already have an account? <a href="Login">Login</a></div>
			</form>
		</main>
	</body>
	<footer>
	</footer>
</html>