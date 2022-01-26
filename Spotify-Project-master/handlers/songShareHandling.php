<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $song_id = $_POST['song_id'];
    $username = $current_user_data["user_name"];

    if(!empty($_POST))
    {
        foreach(array_keys($_POST) as $receiver)
        {
            //we don't want to treat the song_id as a receiver!(the song_id is sent together with the receivers in the POST request)
            if(strcmp($receiver, "song_id") !== 0) 
            {
                $share_song_query = "insert into shared_songs (sender_name, receiver_name, song_id) values ('$username', '$receiver', '$song_id')";

                $already_shared_query = "select * from shared_songs where sender_name = '$username' and receiver_name = '$receiver' and song_id = '$song_id'";
                $already_shared_data =  $mysqli->query($already_shared_query);
                
                $receiver_already_has_song_query = "select * from songs where song_id = '$song_id' and user = '$receiver'";
                $receiver_already_has_song_data =  $mysqli->query($receiver_already_has_song_query);

                if(!$already_shared_data->num_rows)
                {
                    if(!$receiver_already_has_song_data->num_rows)
                    {
                        if($mysqli->query($share_song_query))
                        {
                            echo "Song shared succesfully with ".$receiver."!<br>";
                        }
                        else
                        {
                            echo $mysqli->error;
                        }
                    }
                    else 
                    {
                        echo $receiver." already has that song!<br>";
                    }
                }
                else 
                {
                    echo "The song has alredy been shared with ".$receiver."!<br>";
                }
            }
        }
    }
?>