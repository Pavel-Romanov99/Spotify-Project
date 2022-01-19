<?php
session_start();
include("../utility/functions.php");
include("../utility/connection.php");

$current_user_data = checkLogin($mysqli);
$user_id = $current_user_data["user_id"];
$table_name = 'history'.$user_id;

$date = $_POST['date'];
$delete_all_history = $_POST['deleteAllHistory'];

if(filter_var($delete_all_history, FILTER_VALIDATE_BOOLEAN))
{
    $query_remove_from_history = "truncate table `".$table_name."`";
}
else
{
    $query_remove_from_history = "delete from `".$table_name."` where date = '$date'";
}
   

if($mysqli->query($query_remove_from_history))
{
    echo "Succesfully removed from history! ";
}
else
{
    echo $mysqli->error;
}
?>