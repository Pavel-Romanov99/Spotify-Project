<?php

    if(isset($_GET['song_id']))
    {
        //clear the cache
        clearstatcache();

        $song_id = $_GET['song_id'];
        $song_name = $_GET['name'];
        $song_author = $_GET['author'];
        $file_name = $song_author . " - " . $song_name . ".mp3";

        $currentDirOneUp = dirname(__DIR__);
        $song_path = $currentDirOneUp . "/uploads-songs/" . $song_id;

        if(file_exists($song_path))
        {
            //define header information
            header('Content-Type: audio/mpeg');
            header('Content-Disposition: attachment; filename='.$file_name.'');
            header('Content-length: '. filesize($song_path));
            header('Cache-Control: no-cache');
            header('Content-Transfer-Encoding: chunked'); 
            readfile($song_path);
            exit;

            //terminate from the script
            die();
        }
        else
        {
            echo "File does not exist! ";
        }
    }
    else
    {
        echo "File not specified! ";
    }
?>