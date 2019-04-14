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
    <template>  
        <li>
            <span class="user">
                <img class="img-user" src="">
                <p class="username"></p>
            </span>
            <button class="follow-button">Follow</button>
        </li>
    </template>
    <?php require "../MVC/Views/Shared/navigationbar.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <div id="root">
            <div id='channel-list'>
                <h2>Channel's Found</h2>
                <p>Search for a channel</p>
                <input id="channel-input" type="input" value="<?= $_POST['channel_name']; ?>">
                <button id="search-button" type="submit">Submit</button>

                <hr class="divider">
                <!-- Channel List -->
                <ul>
                </ul>
            </div>
        </div>
        <script src="/Javascript/Community/Channel_List.js"></script>
</body>

</html>