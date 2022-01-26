<?php
    header('Content-Type: application/json');

    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $user_id = $current_user_data["user_id"];
    $user_name = $current_user_data["user_name"];

    $playlist_table_name = "playlists" . $user_id;
    $playlist_name = $_GET['playlist_name'];
        
    $query_playlist_songs = "select song_id from `".$playlist_table_name."` where playlist = '$playlist_name' order by position";
    $playlist_songs_data = $mysqli->query($query_playlist_songs);

    $result_list = array();

    //getting full song info to so we can pass it to the player
    while($song = mysqli_fetch_assoc($playlist_songs_data))
    {
        $song_id = $song['song_id'];
        $query_get_full_song_info = "select song_id, cover_id, name, author from songs where user = '$user_name' and song_id = '$song_id'";
        $get_full_song_info_data = $mysqli->query($query_get_full_song_info);

        $full_song_info =  mysqli_fetch_assoc($get_full_song_info_data);
        array_push($result_list, json_encode($full_song_info));
    }

    echo json_encode($result_list);
?>