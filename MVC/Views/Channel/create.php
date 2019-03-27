<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="description" content="Header for the main page after the user has logged in.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!--<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="/CSS/ProfileStyles.css">
		<link rel="stylesheet" href="/CSS/NavBar.css"> -->
		<link rel="stylesheet" href="/CSS/test.css">

		<title>TwitchCord</title>
	</head>
	<body>
		<main>
			<form>
				<h1>Channel Creation</h1>
				<div id="input-container">
					<label for="chanName">Channel Name</label>
					<input type="text" name="chanName">
				</div>
				<div id="input-container">
					<label for="displayname">Channel Description</label>
					<textarea class="paragraph-container" type="text" name="chanDesc"></textarea>
				</div>
				<div id="input-container">
					<label for="picture" class="piclabel">Channel Picture</label>
					<input type="file" name="pic" class="picin">
				</div>
				<button type="submit" name="create-btn">Create</button>
			</form>
		</main>
	</body>
	<footer>
	</footer>
</html>