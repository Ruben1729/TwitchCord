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
		<link rel="stylesheet" href="/CSS/Profile.css">
		<link rel="stylesheet" href="/CSS/Dashboard.css">
		<link rel="stylesheet" href="/CSS/PictureGallery.css">

		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
		<script src="/Javascript/Animations.js"></script>

		<title>TwitchCord</title>
	</head>
	<body >
		<?php require "../MVC/Views/Shared/verticalNavigation.php" ?>
		<main id="main-form">

			<div id="img-container">
				<h1>Picture Gallery</h1>
				
			</div>
		</main>
		<script>

			window.addEventListener("load", function() {

				let reload = <?php 
				if(!array_key_exists('reload', $data))
					echo "true";
				else
					echo "false";
				?>;

				if(reload){

					var elem = document.querySelector("#main-form");
					animateForm(elem);

				}

				let picArray = (<?php echo json_encode($data['pics']) ?>);
				
				let parent = document.getElementById("img-container");

				for(i = 0; i < picArray.length; i ++){
					let img = document.createElement("img");

					img.src = picArray[i].path;
					img.addEventListener('click', showContextMenu, event);
					parent.appendChild(img);
					console.log(picArray[i]);
				}

			})
		</script>
		<style>
			a{
				color: white;
			}
			a:hover{
				text-decoration: none;
			}
		</style>
		<?php require "../MVC/Views/Shared/rightClickListener.php" ?>
	</body>
	<footer>
	</footer>
</html>