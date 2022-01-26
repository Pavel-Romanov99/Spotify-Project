<?php
    header('Content-Type: application/json');

    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $id = $_GET["user_id"];

    $query_get_friends_ids = "select friend_id from friends where user_id = '$id'";
    $get_friends_ids_data = $mysqli->query($query_get_friends_ids);

    $result_list = array();

    if($get_friends_ids_data->num_rows > 0)
    {
        while($friend_id = mysqli_fetch_assoc($get_friends_ids_data))
        {
            $table_name = 'history'.$friend_id['friend_id'];

            $query_get_latest_song_in_history = "select name, author from `".$table_name."` where date = (select MAX(date) from `".$table_name."` limit 1)";
            $get_latest_song_in_history_data = $mysqli->query($query_get_latest_song_in_history);

            $latest_song_in_history = mysqli_fetch_assoc($get_latest_song_in_history_data);
            $latest_song_in_history['id'] = $friend_id['friend_id'];

            array_push($result_list, json_encode($latest_song_in_history));
        }
        echo json_encode($result_list);
    } 
?>