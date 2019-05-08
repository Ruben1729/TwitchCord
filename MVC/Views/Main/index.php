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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    <?php if(!empty($_SESSION['uid'])) { ?>
    <div class="jumbotron">
        <h1 class="title    ">Friend Requests</h1>
        <div id="request-list"></div>
    </div>
    <div class="jumbotron">
        <h1 class="title    ">Friend List</h1>
        <div id="friend-list"></div>
        <form action="/Relation/SearchUser" method="post">
            <div class="search-box">
                <input type="text" name="user_name" class="user-name" placeholder="Search for user...">
                <button class="search-user" type="submit">GO</button>
            </div>
        </form>
    </div>
    <?php } ?>
    <script src="/Javascript/Main.js"></script>
    <script>
        let friendList = <?php echo empty($data['friend_list']) ? '""' : json_encode($data['friend_list']); ?>;
        if(friendList !== ""){
            let parent = document.getElementById('friend-list');

            for(let i = 0; i < friendList.length; i ++){
                let friend = document.createElement("div");
                let img = document.createElement("img");
                let userContainer = document.createElement("div");
                let deleteButton = document.createElement("button");

                deleteButton.type="submit";
                deleteButton.innerText="Delete";
                deleteButton.onclick = deleteFriend;
                deleteButton.classList.add("accept-request");
                deleteButton.classList.add(friendList[i].user_id);

                let blockButton = document.createElement("button");

                blockButton.type="submit";
                blockButton.innerText="Block";
                blockButton.onclick = blockFriend;
                blockButton.classList.add("accept-request");
                blockButton.classList.add(friendList[i].user_id);
                userContainer.classList.add("user-item");

                img.src = friendList[i].path === null ? "/Pictures/default.png" : friendList[i].path;
                friend.innerText = friendList[i].username;
                userContainer.appendChild(img);
                userContainer.appendChild(friend);
                userContainer.appendChild(deleteButton);
                userContainer.appendChild(blockButton);
                parent.appendChild(userContainer);
            }
        }

        let relationList = <?php echo empty($data['request_list']) ? '""' : json_encode($data['request_list']); ?>;
        if(relationList !== ""){
            let parent = document.getElementById('request-list');

            for(let i = 0; i < relationList.length; i ++){
                let friend = document.createElement("div");
                let img = document.createElement("img");
                let userContainer = document.createElement("div");
                let acceptButton = document.createElement("button");

                acceptButton.type="submit";
                acceptButton.innerText="Accept";
                acceptButton.onclick = acceptRequest;
                acceptButton.classList.add("accept-request");
                acceptButton.classList.add(relationList[i].user_id);

                userContainer.classList.add("user-item");

                img.src = relationList[i].path === null ? "/Pictures/default.png" : relationList[i].path;
                friend.innerText = relationList[i].username;
                userContainer.appendChild(img);
                userContainer.appendChild(friend);
                userContainer.appendChild(acceptButton);
                parent.appendChild(userContainer);
            }
        }

        function deleteFriend(){
            let userData = event.target.classList[1];

            $.ajax({
                type: "POST",
                dataType: "text",
                url: "/Relation/DeleteFriend/",
                data: { userData: userData }
            });
            document.location.reload(true)
        }

        function blockFriend(){
            let userData = event.target.classList[1];

            $.ajax({
                type: "POST",
                dataType: "text",
                url: "/Relation/BlockFriend/",
                data: { userData: userData }
            });
            document.location.reload(true)
        }

        function acceptRequest(event){
            let userData = event.target.classList[1];

            $.ajax({
                type: "POST",
                dataType: "text",
                url: "/Relation/AddFriend/",
                data: { userData: userData }
            });
            document.location.reload(true)
        }
    </script>
    <style>
        .accept-request{
            width: 100px;
        }
        .user-item{
            display: inline-block;
            margin: 25px;
            width: 100px;
        }
        .user-item > div{
            text-align: center;
        }
        img{
            width: 100px;
            height: 100px;
            margin: auto;
        }
    </style>
</body>

</html>