<?php
    header('Content-Type: application/json');

    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $id = $current_user_data["user_name"];
        
    $query_songs_list = "select song_id, cover_id, name, author from songs where user = '$id'";
    $songs_data = $mysqli->query($query_songs_list);

    $resultList = array();

    while($song = mysqli_fetch_assoc($songs_data))
    {
        array_push($resultList, json_encode($song));
    }

    echo json_encode($resultList);
?>