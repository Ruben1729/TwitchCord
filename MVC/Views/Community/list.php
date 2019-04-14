<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TwitchCord</title>
    <link rel="stylesheet" href="/CSS/Community/List.css">
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
</head>

<body>
    <?php require "../MVC/Views/Shared/navigationbar.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <div id="root">
        <div id='channel-list'>
            <h2>Channel's Found</h2>
            <p>Search for a channel</p>
            <input id="channel-input" type="input" value="<?=$_POST['channel_name'];?>">
            <button id="channel-search" type="submit">Submit</button>

            <hr class="divider">

            <ul>
                <li>
                    <span id="user">
                        <img id="img-user"src="/Pictures/default.png">
                        <p>TEST USER</p>
                    </span>
                    <button id="follow-button">Follow</button>
                </li>
            </ul>
        </div>
    </div>
    <script src="/Javascript/Channel_List.js"></script>
</body>

</html> 