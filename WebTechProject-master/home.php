<?php
    session_start();
    include("functions.php");
    include("connection.php");

    $current_user_data = checkLogin($mysqli); 
    
    if(!$current_user_data){
        header("Location: login.php");
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body onload="onPageLoad()">

    <div class="container">
        <?php include './partials/navbar.php'; ?>

        <div class="content-container">
            

            <?php if($current_user_data) { ?>
            <?php include "./partials/side-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <div class="greetings-message">
                        <h1>Good afternoon, <?php echo $current_user_data["user_name"]?> !</h1>
                    </div>


                    <div id="artists">
                        <form class="search-form">
                            <input class="search-bar" placeholder="Search artist..." type="text" id="artist_field">
                            <button id="search_artist">Search Artist</button>
                        </form>
                        <ul id="tracks">

                        </ul>
                    </div>

                    <div class="greetings-message"">
                        <h1>Recommended for you:</h1>
                    </div>
                </div>
                <?php include 'player.php';?>
            </div>


            <?php if($current_user_data) { ?>
            <?php include "./partials/friends-menu.php"; ?>
            <?php } ?>
        </div>
    </div>

    <script src="./scripts/app.js"></script>
</body>
</html>