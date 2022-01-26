<?php
session_start();
include("../utility/functions.php");
include("../utility/connection.php");

$current_user_data = checkLogin($mysqli);
$user_id = $current_user_data["user_id"];

$song_id = $_POST['song_id'];
$cover_id = $_POST['cover_id'];
$song_name = $_POST['name'];
$author_name = $_POST['author'];

$table_name = 'history'.$user_id;

$query_check_history_size = "select * from `".$table_name."`";
$check_history_size_data = $mysqli->query($query_check_history_size);

if($check_history_size_data)
{
    echo "History successfully retrieved! ";
    if($check_history_size_data->num_rows > 49)
    {
        $query_get_oldest_entry = "select MIN(date) as oldest_date from `".$table_name."`";
        $get_oldest_entry_data = $mysqli->query($query_get_oldest_entry);

        if($get_oldest_entry_data)
        {
            echo "Data for oldest entry successfully retrieved! ";
            $oldest_date_data = mysqli_fetch_assoc($get_oldest_entry_data);
            $oldest_date = $oldest_date_data['oldest_date'];
            echo $oldest_date;
            $query_delete_oldest_entry = "delete from `".$table_name."` where date = '$oldest_date'";

            if($mysqli->query($query_delete_oldest_entry))
            {
                echo "Oldest entry successfully deleted! ";
            }
            else echo $mysqli->error;
        } else echo $mysqli->error;
    } else echo $mysqli->error;
} else echo $mysqli->error;

$query_add_to_history = "insert into `".$table_name."` (song_id, cover_id, name, author)
                         values ('$song_id', '$cover_id', '$song_name', '$author_name')";

if($mysqli->query($query_add_to_history))
{
    echo "Song succesfully added to user history! ";
}
else
{
    echo $mysqli->error;
}