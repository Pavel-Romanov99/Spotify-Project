  <?php  
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
    $song_id = $_POST['song_id'];
    $new_playlist = $_POST['new_playlist'];
    $user_id = $current_user_data["user_id"];
    $playlists_table_name = "playlists" . $user_id;

    if(!empty($_POST))
    {
        foreach(array_keys($_POST) as $playlist_name)
        {
            //we don't want to treat the song_id as a playlist!(the song_id is sent together with the playlist names in the POST request)
            //neither do we want to treat the name of the input field - "new_playlist", as a checkbox (it has a special treatment later) 
            if(strcmp($playlist_name, "song_id") !== 0 && strcmp($playlist_name, "new_playlist") !== 0) 
            {
                $query_playlist_size = "select * from `".$playlists_table_name."` where playlist = '$playlist_name'";
                $playlist_size_data = $mysqli->query($query_playlist_size);
                $position = $playlist_size_data->num_rows;

                //here only the playlists with checked checkboxes get updated
                $query_add_to_playlist = "insert into `".$playlists_table_name."` (song_id, playlist, position) values ('$song_id', '$playlist_name', '$position')";

                $query_already_added = "select * from `".$playlists_table_name."` where song_id = '$song_id' and playlist = '$playlist_name'";
                $already_added_data = $mysqli->query($query_already_added);

                if(!$already_added_data->num_rows)
                {
                    if($mysqli->query($query_add_to_playlist))
                    {
                        echo "Song successfully added to " . $playlist_name . "!<br>";
                    }
                    else
                    {
                        echo $mysqli->error;
                    }
                }
                else
                {
                    echo $playlist_name . ' already contains that song!<br>';
                }
            }
        }
        //now adding the song to the new playlist (this is that special treatment I was talking about)
        if($new_playlist)
        {
            if(strlen($new_playlist) < 30)
            {
                $new_playlist = str_replace(' ', '_', $new_playlist);
                $query_add_to_playlist = "insert into `".$playlists_table_name."` (song_id, playlist, position) values ('$song_id', '$new_playlist', 0)";

                $query_check_if_playlist_already_exists = "select * from `".$playlists_table_name."` where playlist = '$new_playlist'";
                $playlist_already_exists_data = $mysqli->query($query_check_if_playlist_already_exists);

                if(!$playlist_already_exists_data->num_rows)
                {
                    if($mysqli->query($query_add_to_playlist))
                    {
                        echo "Song successfully added to " . $new_playlist . "! Refresh page to add more songs to it.<br>";
                    }
                    else
                    {
                        echo $mysqli->error;
                    }
                }
                else
                {
                    echo $new_playlist . " already exists, please use its checkbox!<br>";
                }
            }
            else
            {
                echo "Max length of playlist name is 30 symbols! ";
            }
        }
    }
?>