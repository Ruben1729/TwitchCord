<?php
	require "welcome_page.header.php";
?>
	<body>
		<main>
			<form>
				<input type="text" name="uid" placeholder="Username">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="pwd" placeholder="Password">
				<input type="password" name="pwd-repeat" placeholder="Repeat Password">

				<button type="submit" name="register-btn">Register</button>
				<div>Already have an account?<a href="Login">Login</a></div>
			</form>
		</main>
	</body>
<?php
	require "welcome_page.footer.php";
?>