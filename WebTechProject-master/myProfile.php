<?php
    session_start();
    include("functions.php");
    include("connection.php");

    $current_user_data = checkLogin($mysqli);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>My Profile</title>
</head>
<body onload="onPageLoad()">

    <div class="container">
        <?php include './partials/navbar.php'; ?>
        <div class="content-container">

            <?php if($current_user_data) { ?>
            <?php include "./partials/side-menu.php";
                  include "./partials/friends-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <h1>My Profile</h1>
                    
                </div>
                <?php include 'player.php';?>
            </div>
        </div>
    </div>

    <script src="./scripts/app.js"></script>
</body>
</html>