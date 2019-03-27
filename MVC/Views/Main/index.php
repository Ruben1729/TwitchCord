<?php

session_start();
if(empty($_SESSION))
	header('Location: /User/Login');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TwitchCord</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/Main.css">
</head>

<body>
    <?php require "../MVC/Views/Shared/navbar.php" ?>
    <div class="jumbotron">
        <h1 class="display-4">Welcome to TwitchCord</h1>
        <p class="lead">Like a content creator? join their community!</p>
	</div>

	<h3>Top Streams</h3>
    <div id="stream-carousel">
        <i class="fas fa-arrow-left"></i>
		
		<div class="stream-window window-1">
		</div>
        <div class="stream-window window-2">
			<div id="highlight-1"></div>
        </div>
        <div class="stream-window window-3">

		</div>
		
        <i class="fas fa-arrow-right"></i>
	</div>
	
	<script src="https://embed.twitch.tv/embed/v1.js"></script>
		<script type="text/javascript">
			let embed = new Twitch.Embed("highlight-1", {
				width: 500,
				height: 300,
				channel: "summit1g",
				layout: "video",
			});

			embed.addEventListener(Twitch.Embed.VIDEO_READY, () => {
				var player = embed.getPlayer();
				player.play();
			});
		</script>
</body>

</html> 