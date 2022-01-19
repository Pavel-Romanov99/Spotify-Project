<?php
session_start();
include("../utility/functions.php");
include("../utility/connection.php");

$current_user_data = checkLogin($mysqli);
$username = $current_user_data["user_name"];

$song_id = $_POST['song_id'];
$cover_id = $_POST['cover_id'];

//deleting song entry from database
$query_delete_song = "delete from songs where song_id ='$song_id' and user = '$username'";

if($mysqli->query($query_delete_song))
{
    echo "Song succesfully deleted!";
}
else
{
    echo $mysqli->error;
}

$song_pointer = getcwd() . "/../uploads-songs/" . $song_id; 
$cover_pointer = getcwd() . "/../uploads-covers/" . $cover_id; 

$query_check_if_any_users_have_song = "select * from songs where song_id ='$song_id'";
$check_if_any_users_have_song_data = $mysqli->query($query_check_if_any_users_have_song);

if($check_if_any_users_have_song_data->num_rows == 0) //if no one has the song in their library, than delete the .mp3 and cover files
{
    echo "deleting file!";
    //using unlink() function to delete the song and cover file 
    if (!unlink($song_pointer)) 
    { 
        echo "$song_pointer cannot be deleted due to an error"; 
    } 
    else 
    { 
        echo "$song_pointer has been deleted"; 
    }

    if(strcmp($cover_id, "default-cover.jpg") !== 0) //we don't want to delete the default cover image!
    {
        if (!unlink($cover_pointer)) 
        { 
            echo ("$song_pointer cannot be deleted due to an error"); 
        } 
        else 
        { 
            echo ("$cover_pointer has been deleted"); 
        }
    }
} 
?>