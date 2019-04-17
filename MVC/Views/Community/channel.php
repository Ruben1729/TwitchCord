<?php
// if the user isn't logged in or invalid, redirect to login screen
if (!isset($_SESSION['uid']))
    header('Location: /Home/Index');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Community</title>
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
    <link rel="stylesheet" href="/CSS/Community/Channels.css">
    <link rel="stylesheet" href="/CSS/Background-Styles.css">
</head>

<body>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="/Dependencies/vue-socketio.js"></script>
    <script src="/Dependencies/Vue.js"></script>
    <div id="root">
        <?php require "../MVC/Views/Shared/navigationbar.php" ?>
        <div id="app"></div>
    </div>
    <script type="module" src="/Vue/Community.js"></script>
</body>

</html>