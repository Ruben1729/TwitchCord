<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TwitchCord</title>
    <link rel="stylesheet" href="/CSS/Community/Index.css">
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <div id="root">
        <?php require "../MVC/Views/Shared/navigationbar.php" ?>
            <div id="list">
                <h3>Filter Channels</h3>
                <input class="list-input" type="text" placeholder="Enter the channel you want to see">
                <div id="list-type">
                    <button class="list-btn">List</button>
                    <button class="list-btn">Tile</button>
                </div>
            </div>
        <div id="container">
            
        </div>
    </div>
</body>

</html>