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
    <link rel="stylesheet" href="../styles/sharedSongsStyles.css">
    <title>Shared Songs - Audiobits</title>
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
                <div class = "content">

                    <div class="page-title">
                        <h1>Shared Songs</h1>
                    </div>
                    <div class="sub page-title">
                        <span>Songs that other users have shared with you.</span>
                    </div>

                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                    <script type="text/javascript" src="../scripts/songAcceptDiscardAjax.js"></script>

                    <?php
                        $username = $current_user_data["user_name"];

                        $query_shared_songs = "select * from shared_songs where receiver_name = '$username'";
                        $shared_songs_data = $mysqli->query($query_shared_songs);

                        if($shared_songs_data->num_rows > 0)
                        {
                            while($shared_song = mysqli_fetch_assoc($shared_songs_data))
                            {
                                $shared_song_id = $shared_song['song_id'];
                                $query_full_song_data = "select * from songs where song_id = '$shared_song_id'";
                                $song =  mysqli_fetch_assoc($mysqli->query($query_full_song_data));

                                $song_adress = strval($song['song_id']);
                                $cover_adress = strval($song['cover_id']);

                                echo '<div class="song-content">
                                    <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                    <div class="song-info">
                                        <strong>'.$song['name'].'</strong>
                                        <span>by '.$song['author'].', <span class="grey-text"> uploader: '.$song['uploader'].'</span></span>
                                    </div>

                                    <span>Shared by: <strong>'.$shared_song['sender_name'].'</strong></span>

                                    <button  class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                        <i class="fas fa-play"></i>
                                    </button>

                                    <button class="songs-list-button" onclick="acceptDiscardSong(\''.$song_adress.'\', true);">
                                        <i class="fas fa-check"></i>
                                    </button>


                                    <button class="songs-list-button" onclick="acceptDiscardSong(\''.$song_adress.'\', false);">
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