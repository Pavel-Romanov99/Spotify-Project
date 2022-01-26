<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

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
    <link rel="stylesheet" href="../styles/universalStyles.css">
    <link rel="stylesheet" href="../styles/adminDeleteSongsStyles.css">
    <title>Audiobits</title>
</head>
<body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../scripts/adminActions.js"></script>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>

        <div class="content-container">
            

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                <h1 class = "page-title">Delete Songs</h1>

                <?php
                    $query_get_all_songs = "select * from songs";
                    $get_all_songs_data = $mysqli->query($query_get_all_songs);

                    if($get_all_songs_data->num_rows > 0)
                    {
                        while($song = mysqli_fetch_assoc($get_all_songs_data))
                        {
                            $song_adress = strval($song['song_id']);
                            $cover_adress = strval($song['cover_id']);
                            $song_user = $song['user'];
                            $query_get_user_id = "select user_id from users where user_name = '$song_user' and is_admin = false"; //only non-admin songs
                            $get_user_id_data = $mysqli->query($query_get_user_id);

                            if($get_user_id_data->num_rows > 0)
                            {
                                $user_id = mysqli_fetch_assoc($get_user_id_data)['user_id'];

                                echo '
                                <div class="song-content">
                                    <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                    <div class="song-info">
                                        <strong>'.$song['name'].'</strong>
                                        <span>by '.$song['author'].', <span class="grey-text"> uploader: '.$song['uploader'].'</span></span>
                                    </div>

                                    <span><strong>User:</strong> '.$song_user.'</span>

                                    <button  class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                        <i class="fas fa-play"></i>
                                    </button>

                                    <button class="songs-list-button" onclick="showSongConfirmationBox(\''.$song_adress.'\', \''.$song_user.'\');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>       
                                </div>

                                <div class="confirmation-box" id="confbox'.$song_adress.$song_user.'" style = "display: none;">
                                    <strong>Are you sure you want to delete the song '.$song['name'].', by '.$song['author'].', uploaded by '.$song['uploader'].' from '.$song['user'].'\'s library?</strong>
                                    <div>
                                        <button class="confirmation-button" onclick="showSongConfirmationBox(\''.$song_adress.'\', \''.$song_user.'\'); adminDeleteSong(\''.$song_adress.'\', \''.$cover_adress.'\', \''.$user_id.'\', \''.$song_user.'\');">Yes</button>
                                        <button class="confirmation-button" onclick="showSongConfirmationBox(\''.$song_adress.'\', \''.$song_user.'\');">No</button>
                                    </div>
                                </div>';
                            }
                        }
                    }
                    else
                    {
                        echo "Currently no user has any songs in their library.";
                    }
                ?>
                        

                <?php include '../partials/player.php';?>
            </div>

            <?php if($current_user_data) { ?>
            <?php include "../partials/friends-menu.php"; ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>