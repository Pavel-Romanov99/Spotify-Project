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
    <link rel="stylesheet" href="../styles/playlistsStyles.css">
    <title>Playlists - Audiobits</title>
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
                <div class="content">

                    <div class="page-title">
                        <h1>Playlists</h1>
                    </div>
                
                     <?php
                        include("../getid3/getid3.php");//we use getID3 to get the duration of the songs
                        $getID3 = new getID3;

                        $user_id = $current_user_data["user_id"];
                        $user_name = $current_user_data["user_name"];
                        $playlist_table_name = "playlists" . $user_id;

                        $query_get_playlists = "select distinct(playlist) from `".$playlist_table_name."`";
                        $get_playlist_data = $mysqli->query($query_get_playlists);

                        if($get_playlist_data->num_rows > 0)
                        {
                            while($playlist = mysqli_fetch_assoc($get_playlist_data))
                            {
                                $playlist_duration = 0;
                                $playlist_name = $playlist['playlist'];
                                $query_get_playlist_elements = "select * from `".$playlist_table_name."` where playlist = '$playlist_name' order by position";
                                $get_playlist_elements_data = $mysqli->query($query_get_playlist_elements);

                                $playlist_size = $get_playlist_elements_data->num_rows;

                                //iterating over songs in playlist to get playlist duration
                                while($song_in_playlist = mysqli_fetch_assoc($get_playlist_elements_data))
                                {
                                    $song_path = "../uploads-songs/" . $song_in_playlist['song_id'];
                                    $analyzed_song = $getID3->analyze($song_path);
                                    $playlist_duration += $analyzed_song['playtime_seconds'];
                                }

                                mysqli_data_seek($get_playlist_elements_data,0);//resetting the pointer

                                echo '<div class="playlist-content">
                                    <img class="cover-icon" src="../img/playlist-icon.png" alt="">
                                    <div class="playlist-info">
                                        <strong>'.$playlist_name.'</strong>
                                        <span>Num of songs: <strong>'.$playlist_size.'</strong></span>
                                        <span>Duration: <strong>'.gmdate("H:i:s", $playlist_duration).'</strong></span>
                                    </div>

                                    <button class="songs-list-button" onclick="return playPlaylist(\''.$playlist_name.'\');" >
                                        <i class="fas fa-play"></i>
                                    </button>

                                    <button class="songs-list-button" onclick="return showPlaylistContent(\''.$playlist_name.'\');" >
                                        <i class="fas fa-wrench"></i>
                                    </button>

                                    

                                    <button class="songs-list-button" onclick="return deletePlaylist(\''.$playlist_name.'\');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="playlist-content-container" id=\''.$playlist_name.'\' style = "display: none;">';
                                            while($song_in_playlist = mysqli_fetch_assoc($get_playlist_elements_data))
                                            {
                                                $song_id = strval($song_in_playlist['song_id']);
                                                $query_get_full_song_info = "select song_id, cover_id, name, author from songs where user = '$user_name' and song_id = '$song_id'";
                                                $get_full_song_info_data = $mysqli->query($query_get_full_song_info);
                                                $song_position = $song_in_playlist['position'];
                                                $song =  mysqli_fetch_assoc($get_full_song_info_data);
                
                                                echo '<div class="song-content">
                                                    <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                                    <div class="song-info">
                                                        <strong>'.$song['name'].'</strong>
                                                        <span>by '.$song['author'].'</span>
                                                    </div>
                                                    <span  class="songs-list-button" onclick="loadSong(\''.$song_id.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                                        <i class="fas fa-play"></i>
                                                    </span>
                
                                                    <span class="songs-list-button dropdown" onclick="movePlaylistSong(\''.$song_id.'\', \''.$playlist_name.'\', \''.$song_position.'\', \''.$playlist_size.'\', true);">
                                                        <i class="fas fa-chevron-up"></i>
                                                    </span>
                
                                                    <span class="songs-list-button dropdown" onclick="movePlaylistSong(\''.$song_id.'\', \''.$playlist_name.'\', \''.$song_position.'\', \''.$playlist_size.'\', false);">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </span>              
                
                                                    <span class="songs-list-button" onclick="removeFromPlaylist(\''.$song_id.'\', \''.$playlist_name.'\');">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                </div>';
                                            }
                                            echo ' 
                                        </div>';
                            }
                        }
                        else
                        {
                            echo "<p>You have no playlists.<p>";
                        }
                    ?>
                </div>

                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                <?php include '../partials/player.php';?>
                <script type="text/javascript" src="../scripts/playlistActions.js"></script>

            </div>
        </div>
    </div>
</body>
</html>