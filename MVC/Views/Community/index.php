<?php 
    $community_name = isset($data["community_name"]) ? $data["community_name"] : "no channel";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Community</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/CSS/Community.css">
</head>

<body>
    <div id="root">
        <?php require "../MVC/Views/Shared/navbar.php" ?>
        <div id="container">
            <div id="groups">
                <img src="">
                <h3><?php echo $community_name; ?></h3>
                <ul>
                    <li class="group-active">test group</li>
                    <li>test group</li>
                    <li>test group</li>
                    <li>test group</li>
                </ul>
            </div>

            <div id="stream">
            </div>

            <div id="chat-container" class="flex-column">
                <div id="window">
                    <ul>
                        <li>
                            <div class="message">
                            test message
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="input">
                  <textarea name="chatbox-input" placeholder="Write your message here" onkeyup="expand_textarea(this)"></textarea>
                </div>
            </div>

            <div></div>
        </div>
    </div>
    <script src="/Javascript/Community.js"> </script>
</body>

</html> 