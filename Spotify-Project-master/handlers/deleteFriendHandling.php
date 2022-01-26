<?php
    include("../utility/functions.php");
    include("../utility/connection.php");

    $friend_id = $_POST['friend_id'];
    $user_id = $_POST['user_id'];

    $query_delete_friend = "delete from friends where friend_id = '$friend_id' and user_id = '$user_id'";

    if($mysqli->query($query_delete_friend))
    {
        echo "Friend successfully deleted!";
    }
    else
    {
        echo $mysqli->error;
    }
?>