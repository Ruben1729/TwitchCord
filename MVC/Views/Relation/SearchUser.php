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
    <script>
        var user = <?= json_encode($_SESSION)?>
    </script>
    <template>  
        <li>
            <img class="img-user" src="">
            <p class="username"></p><br/>
            <button class="add-button">Add Friend</button>
        </li>
    </template>
    <?php require "../MVC/Views/Shared/navigationbar.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <div id="root">
            <div id='user-list'>
                <h2>User's Found</h2>
                <p>Search for a User</p>
                <input id="user-input" type="input" value="<?= $_POST['user_name']; ?>">
                <button id="search-button" type="submit">Submit</button>

                <hr class="divider">
                <!-- User List -->
                <ul>
                </ul>
            </div>
        </div>
        <script src="/Javascript/User_List.js"></script>
        <style>
            body{
                background-color: #849c95;
            }
            button{
                border: solid 1px #53615d;
            }
        </style>
</body>

</html>