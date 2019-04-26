<?php

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
    <div>
        <h1>Friend List</h1>
        
    </div>
    <script src="/Javascript/Main.js"></script>
</body>

</html>