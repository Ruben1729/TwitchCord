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
		<link rel="stylesheet" href="/CSS/Form.css">
		<link rel="stylesheet" href="/CSS/NavBar.css">

		<title>TwitchCord</title>
	</head>
	<body>
		<main <?php if(array_key_exists('reload', $data)) echo "class=\"mainError\""?> class="main-form">
			<form>
				<button type="button" class="btn btn-twitch">
					<a href="https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=bo0nrcahpqfeh6i73cthasv3ysbz1r&redirect_uri=http://localhost/Channel/Link&scope=user_read">
					<i class="fa fa-1x fa-twitch"></i> Connect Using Twitch
					</a>
				</button>
				<h1>Channel Creation</h1>
				<div id="input-container">
					<label for="name">Channel Name</label>
					<input type="text" name="name" value="<?php if(sizeof($_GET) > 1)echo $_GET['displayname'];?>">
				</div>
				<div id="input-container">
					<label for="desc">Channel Description</label>
					<textarea class="paragraph-container" type="text" name="desc"></textarea>
				</div>
				<div id="input-container">
					<label for="pic" class="piclabel">Channel Picture</label>
					<input type="file" name="pic" class="picin">
				</div>
				<button type="submit" name="create-btn">Create</button>
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