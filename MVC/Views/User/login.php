<?php
	require "welcome_page.header.php";
?>
	<body>
		<main>
			<form action="../../Controllers/PHP/usercontroller.php" method="post">
				<input type="text" name="uid" placeholder="Username">
				<input type="password" name="pwd" placeholder="Password">
				<div>Forgot your password?</div>

				<button type="submit" name="login-btn">Login</button>
			</form>
			<div>Don't have an account yet? <a href="register.php">Register!</a></div>
		</main>
	</body>
<?php
	require "welcome_page.footer.php";
?>