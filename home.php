<?php

    session_start();
    include("functions.php");
    include("connection.php");

    $data = checkLogin($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Homepage</title>
</head>
<body onload="onPageLoad()">
    <h1>Greetings from the homepage, <?php echo $data["user_name"] ?> !</h1>
    <a href="logout.php">Logout</a>

    <div id="tokenSection">
        <form action="">
            <label for="">Client ID: <input type="text" id="clientId"></label>
            <label for="">Client Secret: <input type="text" id="clientSecret"></label>
            <input type="button" onclick="requestAuthorization()" value="CLick me">
        </form>
    </div>

    <div id="test">
        <label for="devices" class="form-label">test request</label>
        <input  type="button" onclick="testRequest()" value="Test Request">
    </div>

    <div id="playlists">
        <label for="devices" class="form-label">Playlists</label>
        <select id="devices" class="form-control">
        </select>
        <input  type="button" onclick="refreshPlaylists()" value="Playlist request">
    </div>

    <div id="artists">
        <form action="">
            <label for="">Artist name: <input type="text" id="artist_field"></label>
            <button id="search_artist">Search Artist</button>
        </form>
        <ul id="tracks">
        </ul>
    </div>

    <script src="app.js"></script>
</body>
</html>