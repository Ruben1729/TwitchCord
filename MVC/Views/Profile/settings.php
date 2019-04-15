<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name="description" content="Header for the main page after the user has logged in.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<link rel="stylesheet" href="/CSS/Background-Styles.css">
		<link rel="stylesheet" href="/CSS/Form.css">
		<link rel="stylesheet" href="/CSS/Profile.css">

		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
		<script src="/Javascript/Animations.js"></script>

		<title>TwitchCord</title>
	</head>
	<body>
		<?php require "../MVC/Views/Shared/verticalNavigation.php" ?>
		<main id="main-form">
			<form enctype="multipart/form-data" action="create" method="post">
				<h1>Profile Settings</h1>

				<div class="input-container">
					<label for="pic-id">Upload Picture</label>
					<input type="file" id="file" name="userImg" onchange="readURL(this);" class="visually-hidden">
					<img id="pic-id" src="/Pictures/default.png" alt="Profile Pic">
				</div>
				
				<div class="input-container">
					<label for="bio">Bio</label>
					<textarea class="paragraph-container" type="text" name="bio"></textarea>
				</div>
				
				<button type="submit" name="save-btn">Save Changes</button>
			</form>
		</main>
		<script>

			var elem = document.getElementById("pic-id");
			var fileIn = document.getElementById("file");

			elem.addEventListener("click", function(){
				fileIn.click();
			});

			function readURL(input) {
		        if (input.files && input.files[0]) {
		            var reader = new FileReader();

		            reader.onload = function (e) {
		                $('#pic-id').attr('src', e.target.result)
		            };

		            reader.readAsDataURL(input.files[0]);
		        }
		    }

			window.addEventListener("load", function() {

				var reload = <?php 
				if(!array_key_exists('reload', $data))
					echo "true";
				else
					echo "false";
				?>;

				if(reload){

					var elem = document.querySelector("#main-form");
					animateForm(elem);

				}

			})
		</script>
	</body>
	<footer>
	</footer>
</html>