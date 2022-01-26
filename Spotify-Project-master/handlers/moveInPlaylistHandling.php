<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $user_id = $current_user_data["user_id"];

    $playlist_table_name = "playlists" . $user_id;
    $playlist_name = $_POST['playlist_name'];
    $song_id = $_POST['song_id'];
    $song_position = $_POST['song_position'];
    $move_up = $_POST['move_up'];

    if(filter_var($move_up, FILTER_VALIDATE_BOOLEAN)) //if we want to move the chosen song up
    {
        $new_song_position = $song_position - 1;

        $query_move_upper_song_down = "update `".$playlist_table_name."` set position = '$song_position' where position = '$new_song_position'";
        $query_move_chosen_song_up = "update `".$playlist_table_name."` set position = '$new_song_position' where song_id = '$song_id' and playlist = '$playlist_name'";

        if($mysqli->query($query_move_upper_song_down))
        {
            echo "Upper song successsfully moved down!";
        }
        else echo $mysqli->error;

        if($mysqli->query($query_move_chosen_song_up))
        {
            echo "Chosen song successfully move up!";
        }
        else  echo $mysqli->error;
    }
    else //if we want to move the chosen song down
    {
        $new_song_position = $song_position + 1;

        $query_move_lower_song_up = "update `".$playlist_table_name."` set position = '$song_position' where position = '$new_song_position'";
        $query_move_chosen_song_down = "update `".$playlist_table_name."` set position = '$new_song_position' where song_id = '$song_id' and playlist = '$playlist_name'";

        if($mysqli->query($query_move_lower_song_up))
        {
            echo "Upper song successsfully moved down!";
        }
        else echo $mysqli->error;

        if($mysqli->query($query_move_chosen_song_down))
        {
            echo "Chosen song successfully move up!";
        }
        else  echo $mysqli->error;
    }
?>