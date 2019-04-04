<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Community</title>
    <link rel="stylesheet" href="/CSS/Community/Community.css">
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
</head>

<body>
    <div id="root">
        <?php require "../MVC/Views/Shared/navigationbar.php" ?>
        <div id="container">
            <div id="groups">
                <img src="">
                <h3><?php echo $data["channel_name"]; ?></h3>
                <ul>
                    <li class="group-active">test group</li>
                    <li>test group</li>
                </ul>
            </div>

            <div id="stream">
            </div>

            
            <div id="chat-container" class="flex-column">
                <div id="window">
                    <ul>
                        <li>
                            <!-- msg template testing -->
                            <div class="msg">
                                <div class="avatar">
                                    <img class="msg-img"/>
                                    <p class="user">username</p>
                                </div>
                                <p class="msg-content">
                                
                                </p>
                                <div class="timestamp">12:00 PM</div>
                            </div> 
                        </li>
                    </ul>
                </div>
                <div id="input">
                  <textarea name="chatbox-input" placeholder="Write your message here" onkeyup="expand_textarea(this)"></textarea>
                  <button type="submit">▶</button>
                </div>
            </div>

            <div></div>
        </div>
    </div>
    <script src="/Javascript/Community.js"> </script>
</body>

</html> 