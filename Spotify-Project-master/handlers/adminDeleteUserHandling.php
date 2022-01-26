<?php
    include("../utility/functions.php");
    include("../utility/connection.php");

    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];

    $query_get_user_songs = "select * from songs where user = '$user_name'";
    $get_user_songs_data = $mysqli->query($query_get_user_songs);

    if($get_user_songs_data->num_rows > 0)//check if the user has any songs
    {
        //deleting user songs one by one while checking if the .mp3 and cover have to deleted too
        while($song = mysqli_fetch_assoc($get_user_songs_data))
        {
            $song_id = $song['song_id'];
            $cover_id = $song['cover_id'];

            $query_delete_song = "delete from songs where song_id ='$song_id' and user = '$user_name'";
            $mysqli->query($query_delete_song);

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
        }
    }
    echo "User songs successfully deleted! ";

    $query_delete_user = "delete from users where user_id = '$user_id'";
    $query_delete_user_shared_songs = "delete from shared_songs where receiver_name = '$user_name' or sender_name = '$user_name'";
    $query_delete_user_s = "delete from friends where user_id = '$user_id' or friend_id = '$user_id'";

    $history_table_name = "history" . $user_id;
    $query_delete_user_history = "drop table `".$history_table_name."`";

    $playlists_table_name = "playlists" . $user_id;
    $query_delete_user_playlists = "drop table `".$playlists_table_name."`";

    $query_get_user_avatar = "select avatar_id from users where user_id = '$user_id'";
    $avatar_id =  mysqli_fetch_assoc($mysqli->query($query_get_user_avatar))['avatar_id'];

    if($mysqli->query($query_delete_user))
    {
        echo "User successfully deleted from 'users' table! ";

        //using unlink() function to delete the user avatar if it's not the default one
        if(strcmp($avatar_id, "default-avatar.png") !== 0)
        {
            $avatar_pointer = getcwd() . "/../uploads-avatars/" . $avatar_id; 

            if (!unlink($avatar_pointer)) 
            { 
                echo "$avatar_pointer cannot be deleted due to an error!"; 
            } 
            else 
            { 
                echo "$avatar_pointer has been deleted!"; 
            }
        }
    }
    else echo $mysqli->error;

    if($mysqli->query($query_delete_user_shared_songs))
    {
        echo "User shared songs successfully deleted from 'shared_songs' table! ";
    }
    else echo $mysqli->error;

    if($mysqli->query($query_delete_user_history))
    {
        echo "User history table ".$history_table_name." succesfully deleted! ";
    }
    else echo $mysqli->error;

    if($mysqli->query($query_delete_user_playlists))
    {
        echo "User playlists table ".$playlists_table_name." succesfully deleted! ";
    }
    else echo $mysqli->error;
?>