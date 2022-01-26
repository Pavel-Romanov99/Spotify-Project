<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $user_id = $current_user_data["user_id"];

    $playlist_table_name = "playlists" . $user_id;
    $playlist_name = $_POST['playlist_name'];

    $query_delete_playlist = "delete from `".$playlist_table_name."` where playlist = '$playlist_name'";

    if($mysqli->query($query_delete_playlist))
    {
        echo "Playlist `".$playlist_table_name."` successfully deleted!";
    }
    else
    {
        echo $mysqli->error;
    }
?>