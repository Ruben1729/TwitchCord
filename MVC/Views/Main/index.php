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
    <style>
        .user-name, .search-user{
            margin-left: 5%;
        }
        .search-user{
            display: inline;
        }
    </style>
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
    <div class="jumbotron">
        <h1 class="title    ">Friend List</h1>
        <div id="friend-list"></div>
        <form action="/Community/ChannelList" method="post">
            <div class="search-box">
                <input type="text" class="user-name" placeholder="Search for user...">
                <button class="search-user" type="submit">GO</button>
            </div>
        </form>
    </div>
    <script src="/Javascript/Main.js"></script>
    <script>
        let friendList = <?php echo empty($data['friend_list']) ? '""' : json_encode($data['friend_list']); ?>;
        if(friendList !== ""){
            let parent = document.getElementById('friend-list');
            for(let i = 0; i < friendList.length; i ++){
                let friend = document.createElement("div");
                let img = document.createElement("img");
                img.src = friendList[i].path === null ? "/Pictures/default.png" : friendList[i].path;
                friend.innerText = friendList[i].username;
                parent.appendChild(img);
                parent.appendChild(friend);
            }
        }
    </script>
</body>

</html>