<?php

?>
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
			<form enctype="multipart/form-data" action="create" method="post">
				<h1>Create Your Profile!</h1>

				<div id="input-container">
					<label for="pic-id">Upload Picture</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
					<input type="file" id="file" name="fileElem" class="visually-hidden">
					<img id="pic-id" src="/Pictures/default.png" alt="Profile Pic">
				</div>

				<div id="input-container">
					<label for="displayname">Display Name</label>
					<input type="text" name="displayname">
				</div>
				
				<div id="input-container">
					<label for="bio">Bio</label>
					<textarea class="paragraph-container" type="text" name="bio"></textarea>
				</div>
				
				<button type="submit" name="save-btn">Create</button>
			</form>
		</main>

		<script>

			var elem = document.getElementById("pic-id");
			var fileIn = document.getElementById("file");

			elem.addEventListener("click", function(){

				fileIn.click();

			});

		</script>

	</body>
	<footer>
	</footer>
</html>