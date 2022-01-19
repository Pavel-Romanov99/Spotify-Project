<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/universalStyles.css">
    <link rel="stylesheet" href="../styles/myHistoryStyles.css">
    <title>History - Audiobits</title>
</head>
<body>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>
        <div class="content-container">

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php";
                  include "../partials/friends-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <?php include '../partials/player.php';?>
                <div class="content">

                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                    <script type="text/javascript" src="../scripts/removeFromHistoryAjax.js"></script>

                    <div class="page-title">
                        <h1>History</h1>
                    </div>
                    <div class="sub page-title" >
                        <span>The last 10 songs you have listened to.</span>
                    </div>
                    <div class="sub page-title">
                        <button class = "delete-history-button" onclick="removeFromHistory(1, true);">Delete All History</button>
                    </div>

                    <?php
                        $user_id = $current_user_data["user_id"];
                        $table_name = 'history'.$user_id;

                        $query_history = "select * from `".$table_name."`";
                        $history_data = $mysqli->query($query_history);

                        if($history_data->num_rows > 0)
                        {
                            while($song = mysqli_fetch_assoc($history_data))
                            {
                                $song_adress = strval($song['song_id']);
                                $cover_adress = strval($song['cover_id']);

                                echo '<div class="song-content">
                                    <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                    <div class="song-info">
                                        <strong>'.$song['name'].'</strong>
                                        <span>by '.$song['author'].'</span>
                                    </div>

                                    <span><strong>Time:</strong> '.$song['date'].'</span>

                                    <button  class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                        <i class="fas fa-play"></i>
                                    </button>

                                    <button class="songs-list-button" onclick="removeFromHistory(\''.$song['date'].'\', false);">
                                        <i class="fas fa-times"></i>
                                    </button>

                                </div>';
                            }
                        }
                        else
                        {
                            echo "<p>You have no shared songs at the moment.<p>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>