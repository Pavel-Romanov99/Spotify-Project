<?php
session_start();
include("../utility/functions.php");
include("../utility/connection.php");

$current_user_data = checkLogin($mysqli);

$username = $current_user_data["user_name"];
$song_id = $_POST['song_id'];
$accept_song = $_POST['accept_song'];

if(filter_var($accept_song, FILTER_VALIDATE_BOOLEAN))
{
    $query_check_if_user_has_song = "select * from songs where song_id = '$song_id' and user = '$username'";
    $check_if_user_has_song_data = $mysqli->query($query_check_if_user_has_song);
    if($check_if_user_has_song_data->num_rows == 0)
    {
        $query_full_song_data = "select * from songs where song_id = '$song_id'";
        $song = mysqli_fetch_assoc($mysqli->query($query_full_song_data));

        $cover_id = $song['cover_id'];
        $name = $song['name'];
        $author = $song['author'];
        $uploader = $song['uploader'];

        $query_add_to_library = "insert into songs (song_id, cover_id, name, author, uploader, user) values ('$song_id', '$cover_id', '$name', '$author', '$uploader', '$username')";
        
        if($mysqli->query($query_add_to_library))
        {
            echo "Song succesfully added to library!";
        }
        else
        {
            echo $mysqli->error;
        }
    }
    else
    {
        echo "User already has that song!";
    }
}

$query_delete_sharing = "delete from shared_songs where song_id = '$song_id' and receiver_name = '$username'";

if($mysqli->query($query_delete_sharing))
{
    echo "Song sharing succesfully deleted!";
}
else
{
    echo $mysqli->error;
}