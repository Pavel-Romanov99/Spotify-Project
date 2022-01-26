<?php
session_start();
include("../utility/functions.php");
include("../utility/connection.php");

$song_id = $_POST['song_id'];
$cover_id = $_POST['cover_id'];
$user_id = $_POST['user_id'];
$username = $_POST['user_name'];

//deleting song entry from library database
$query_delete_song = "delete from songs where song_id ='$song_id' and user = '$username'";
//deleting song entry from shared songs database
$query_delete_shared_song = "delete from shared_songs where song_id ='$song_id' and sender_name = '$username'";
//deleting song entry from playlists database
$playlists_table_name = 'playlists'.$user_id;
$query_delete_playlists_song = "delete from `".$playlists_table_name."` where song_id ='$song_id'";
//deleting song entry from history database
$history_table_name = 'history'.$user_id;
$query_delete_history_song = "delete from `".$history_table_name."` where song_id ='$song_id'";

if($mysqli->query($query_delete_song))
{
    echo "Song succesfully deleted from DB!";
}
else echo $mysqli->error;

if($mysqli->query($query_delete_shared_song))
{
    echo "Shared song succesfully deleted from DB!";
}
else echo $mysqli->error;

if($mysqli->query($query_delete_playlists_song))
{
    echo "Playlisted song succesfully deleted from DB!";
}
else echo $mysqli->error;

if($mysqli->query($query_delete_history_song))
{
    echo "Song entry in user history succesfully deleted from DB!";
}
else echo $mysqli->error;

$song_pointer = getcwd() . "/../uploads-songs/" . $song_id; 
$cover_pointer = getcwd() . "/../uploads-covers/" . $cover_id; 

$query_check_if_any_users_have_song = "select * from songs where song_id ='$song_id'";
$check_if_any_users_have_song_data = $mysqli->query($query_check_if_any_users_have_song);

if($check_if_any_users_have_song_data->num_rows == 0) //if no one has the song in their library, than delete the .mp3 and cover files
{
    echo "Deleting file! ";
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