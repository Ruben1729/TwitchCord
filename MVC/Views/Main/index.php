<?php

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
	<script src="/Javascript/Main.js"></script>
    <div id="stream-carousel">
		<button onclick="carouselDirection(this)" class="btn btn-dark" id="carousel-left"> 
			<i class="fas fa-arrow-left"></i> 
		</button>
		
		<div class="stream-window window-1">
			<div>
				
			</div>
		</div>
        <div class="stream-window window-2">
			<div id="highlight-stream">
				<iframe
						src="https://player.twitch.tv/?collection=abcDeF1ghIJ2kL"
						height="300"
						width="500"
						frameborder="0"
						scrolling="no"
						allowfullscreen="true">
				</iframe>
			</div>
        </div>
        <div class="stream-window window-3">
			<div>
			</div>
		</div>

		<button onclick="carouselDirection(this)" class="btn btn-dark" id="carousel-right"> 
			<i class="fas fa-arrow-right"></i> 
		</button>
	</div>
</body>

</html> 