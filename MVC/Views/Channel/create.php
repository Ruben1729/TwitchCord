<?php
	
	$userChannel = $this->model('ChannelModel')->getChannelById($_SESSION['uid']);
	$auth = true;
	if(empty($userChannel)){
		$auth = false;
	}

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
		<link rel="stylesheet" href="/CSS/Profile.css">

		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
		<script src="/Javascript/Animations.js"></script>

		<title>TwitchCord</title>
	</head>
	<body>

		<video playsinline autoplay muted loop id="bgvid">
		    <source src="/Clips/allclips.mp4" type="video/mp4">
		</video>

		<main <?php if(array_key_exists('reload', $data)) echo "class=\"mainError\""?> class="main-form">
			<form enctype="multipart/form-data" action="create" method="post">
				<h1>Channel Creation</h1>

				<div class="authorized" <?php if($auth == true)echo "id=\"hidden\"";?>>
					<button type="button" class="btn-twitch">
						<a id="twitch-link" href="https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=bo0nrcahpqfeh6i73cthasv3ysbz1r&redirect_uri=http://localhost/Channel/Link&scope=user_read">
						<img id="twitch-icon" src="/Icons/GlitchIcon_White_24px.png"> Connect Using Twitch
						</a>
					</button>
				</div>

				<div class="not-authorized" <?php if($auth == false)echo "id=\"hidden\"";?>>
					<div class="input-container">
						<label for="pic-id">Channel Picture</label>
						<input type="file" id="file" name="userImg" onchange="readURL(this);" class="visually-hidden">
						<img id="pic-id" src="/Pictures/default.png" alt="Profile Pic">
					</div>
					<div class="input-container">
						<label for="desc">Channel Description</label>
						<textarea class="paragraph-container" type="text" name="desc"></textarea>
					</div>
					<button type="submit" name="create-btn">Create</button>
				</div>

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