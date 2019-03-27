<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="description" content="Header for the main page after the user has logged in.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="/CSS/ProfileStyles.css">
		<link rel="stylesheet" href="/CSS/NavBar.css">

		<title>TwitchCord</title>
	</head>
	<body>
		<main>
			<form>
				<h1>Profile Settings</h1>
				<div id="input-container">
					<label for="bio">Bio</label>
					<textarea class="paragraph-container" type="text" name="bio"></textarea>
				</div>
				<div id="input-container">
					<label for="displayname">Display Name</label>
					<input type="text" name="displayname">
				</div>
				<div id="input-container">
					<label for="picture">Profile Picture</label>
					<input type="file" name="pic">
				</div>
				<button type="submit" name="save-btn">Save</button>
			</form>
		</main>
	</body>
	<footer>
	</footer>
</html>