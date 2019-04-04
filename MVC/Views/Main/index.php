<?php
	$top_streamers = $data['top_streamers'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TwitchCord</title>
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
    <link rel="stylesheet" href="/CSS/Main.css">
</head>

<body>
    <?php require "../MVC/Views/Shared/navigationbar.php" ?>
    <div class="jumbotron">
        <h1 class="title">Welcome to TwitchCord</h1>
        <p class="lead">Like a content creator? join their community!</p>

        <br />

        <span class="channel-search">Look for a channel</h5>
            <form action="/Community/ChannelList" method="post">
			<input type="text" name="channel_name">
			<button type="submit">GO</button>
            </form>
    </div>

    <?php if (!empty($top_streamers)) { ?>
    <div>
        <h2 class="stream-title">Top Streams</h3>
		<div id="stream-carousel">
			<button onclick="carouselDirection(this)" class="carousel-btn" id="carousel-left">
				&#129048;
			</button>
			<div class="stream-window window-1">
				<div>

				</div>
			</div>
			<div class="stream-window window-2">
				<div id="highlight-stream">
					<iframe src="https://player.twitch.tv/?collection=abcDeF1ghIJ2kL" height="300" width="500" frameborder="0" scrolling="no" allowfullscreen="true">
					</iframe>
				</div>
			</div>
			<div class="stream-window window-3">
				<div>
				</div>
			</div>
			<button onclick="carouselDirection(this)" class="carousel-btn" id="carousel-right">
				&#129050;
			</button>
		</div>
	</div>
	<?php } else { ?>
		<div id="no-stream">
			<div id="banner">No one is currently streaming, maybe you can be the first?</div>
		</div>
    <?php } ?>
    <script src="/Javascript/Main.js"></script>
</body>

</html> 