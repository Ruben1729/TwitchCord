<?php 
    // if the user isn't logged in or invalid, redirect to login screen
    if(!isset($_SESSION['uid']))
        header('Location: /Home/Index');
    $channel = $data['channel'];
    $channel_json = json_encode($channel);
    $user = $data['user'];
    $user_json = json_encode($user);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Community</title>
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
    <link rel="stylesheet" href="/CSS/Community/Community.css">
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
</head>

<body>
    <!-- msg template-->
    <template>
        <li>
            <div class="msg">
                <div class="avatar">
                    <img src="" class="msg-img" />
                    <p class="username"></p>
                </div>
                <p class="msg-content">

                </p>
                <div class="timestamp">12:00 PM</div>
            </div>
        </li>
    </template>
    <script>
        var user = JSON.parse('<?= $user_json ?>');
        var channel = JSON.parse(<?= $channel_json ?>);
    </script>
    <div id="root">
        <?php require "../MVC/Views/Shared/navigationbar.php" ?>
        <div id="container">
            <div id="groups">
                <img src="">
                <h3><?= $channel->channel_name ?? 'null' ?></h3>
                <ul>
                    <li class="group-active">test group</li>
                    <li>test group</li>
                </ul>
            </div>

            <div id="stream">
            </div>
            <div id="chat-container" class="flex-column">
                <div id="window">
                    <ul></ul>
                </div>
                <div id="input">
                    <textarea id="chatbox-input" placeholder="Write your message here"></textarea>
                    <button type="submit" onclick="sendMsg()">▶</button>
                </div>
            </div>

            <div></div>
        </div>
    </div>
    <script src="/Javascript/Community/Community.js"></script>
</body>

</html>