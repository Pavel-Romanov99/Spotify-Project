<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $user_id = $current_user_data["user_id"];

    $playlist_table_name = "playlists" . $user_id;
    $playlist_name = $_POST['playlist_name'];
    $song_id = $_POST['song_id'];

    $query_remove_song_from_playlist = "delete from `".$playlist_table_name."` where song_id = '$song_id' and playlist = '$playlist_name'";

    if($mysqli->query($query_remove_song_from_playlist ))
    {
        echo "Song has been successfully removed from " . $playlist_name;
    }
    else
    {
        echo $mysqli->error;
    }
?>