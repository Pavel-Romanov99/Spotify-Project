<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");
 
    $current_user_data = checkLogin($mysqli);

    $currentDirOneUp = dirname(__DIR__);
    $mp3UploadDir = "/uploads-songs/";
    $coverUploadDir = "/uploads-covers/";

    $song_id = uniqid();
    $cover_id = uniqid();
    $song_name = $_POST['song_name'];
    $author_name = $_POST['author_name'];
    $uploader = $_POST['username'];
    $user = $current_user_data["user_name"];

    if($_FILES['cover']['size'] == 0)
        $hasCoverImage = false;
    else $hasCoverImage = true;

    // Store all errors
    $errors = [];

   if(!empty($_FILES['mp3'] ?? null) && $author_name && $song_name) {
        echo $_FILES['mp3']['size'];
        if($_FILES['mp3']['size'] < 52428800 && $_FILES['cover']['size'] < 10485760){ //mp3 is max 50MB and cover is max 10MB

            if($hasCoverImage){ //if a cover image has been chosen
                $coverName = $_FILES['cover']['name'];
                $coverTmpName =  $_FILES['cover']['tmp_name'];
                $coverExtension = strtolower(pathinfo($coverName,PATHINFO_EXTENSION));
                $coverUploadPath = $currentDirOneUp . $coverUploadDir . $cover_id . "." . $coverExtension; 
                $cover_id = $cover_id . "." .$coverExtension; //adding the extension to the id, written in the DB, for future access to the file via the id only
            }
            else { //if there is no cover image, then assign the default one
                $coverName = 'default-cover.jpg';
                $coverExtension = "jpg";
                $cover_id = $coverName;
            }
            $mp3Name = $_FILES['mp3']['name'];
            $mp3TmpName  = $_FILES['mp3']['tmp_name'];
            $mp3Extension = strtolower(pathinfo($mp3Name,PATHINFO_EXTENSION));
            $mp3UploadPath = $currentDirOneUp . $mp3UploadDir . $song_id . "." . $mp3Extension; 
            $song_id = $song_id . "." . $mp3Extension; //adding the extension to the id, written in the DB, for future access to the file via the id only

            
            if (isset($mp3Name) && isset($coverName)) {
                if ($mp3Extension != "mp3") {
                    $errors[] = "Only MP3 format is supported!";
                }
                if($coverExtension != "jpg" && $coverExtension != "png" && $coverExtension != "jpeg") {
                    $errors[] = "Only PNG, JPG and JPEG formats are supported!";
                }
                if (empty($errors)) {

                    $didMp3Upload = move_uploaded_file($mp3TmpName, $mp3UploadPath);

                    if($hasCoverImage){
                        $didCoverUpload = move_uploaded_file($coverTmpName, $coverUploadPath);
                    }
                    else $didCoverUpload = true; //the default cover image is already uploaded 

                    if ($didMp3Upload && $didCoverUpload) {
                        
                        // Add new song info to the songs table:
                        $query_insert_new_song = "insert into songs (song_id, cover_id, name, author, uploader, user)
                                                    values ('$song_id', '$cover_id', '$song_name', '$author_name', '$uploader', '$user')";

                        if($mysqli->query($query_insert_new_song)) {
                            echo "The song " . $song_name . " by " . $author_name . ", uploaded by " . $uploader . " has been uploaded. ";
                        } else {
                            echo $mysqli->error;
                        }
                        
                    } else {
                        echo "An error occurred while uploading. Try again.";
                    }
                } else {
                    foreach ($errors as $error) {
                        echo "The following error occured: " . $error;
                    }
                }
            }
        } else {
            echo "Song is over 50MB or cover is over 10MB!";
        }
    }
   header("Location: ../pages/myLibrary.php"); //comment this to see echos from this script
?>