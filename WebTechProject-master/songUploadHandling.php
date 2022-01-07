<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    session_start();
    include("functions.php");
    include("connection.php");
 
    $current_user_data = checkLogin($mysqli);
    
    include_once 'database_api/Database.php';
    include_once 'database_api/songPost.php';

    $currentDir = getcwd();
    $mp3UploadDir = "/uploads-songs/";
    $coverUploadDir = "/uploads-covers/";

    $song_id = uniqid();
    $cover_id = uniqid();
    $song_name = $_POST['song_name'];
    $author_name = $_POST['author_name'];
    $uploader = $_POST['username'];

    if($_FILES['cover']['size'] == 0)
        $hasCoverImage = false;
    else $hasCoverImage = true;

    // Store all errors
    $errors = [];

   if(!empty($_FILES['mp3'] ?? null) && $author_name && $song_name) {
        if($hasCoverImage){ //if a cover image has been chosen
            $coverName = $_FILES['cover']['name'];
            $coverTmpName =  $_FILES['cover']['tmp_name'];
            $coverExtension = strtolower(pathinfo($coverName,PATHINFO_EXTENSION));
            $coverUploadPath = $currentDir . $coverUploadDir . $cover_id . "." . $coverExtension; 
            $cover_id = $cover_id . "." .$coverExtension; //adding the extension to the id, written in the DB, for future access to the file via the id only
            echo "bum";
        }
        else { //if there is no cover image, then assign the default one
            $coverName = 'default-cover.jpg';
            $coverExtension = "jpg";
            $cover_id = $coverName;
            echo "bam";
        }
        $mp3Name = $_FILES['mp3']['name'];
        $mp3TmpName  = $_FILES['mp3']['tmp_name'];
        $mp3Extension = strtolower(pathinfo($mp3Name,PATHINFO_EXTENSION));
        $mp3UploadPath = $currentDir . $mp3UploadDir . $song_id . "." . $mp3Extension; 
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

                echo $mp3UploadPath."\n";
                echo $coverUploadPath."\n";

                if ($didMp3Upload && $didCoverUpload) {
                    
                    // Add new mp3 and cover file to user library database:
                    // Instantiate DB & Connect
                    $database = new Database();
                    $db = $database->connect();

                    // Instantiate Post object
                    $post = new songPost($db);

                    $post->song_id = $song_id;
                    $post->cover_id = $cover_id;
                    $post->name = $song_name;
                    $post->author = $author_name;
                    $post->uploader = $uploader;
                    $post->user = $uploader;

                    // Create post
                    if($post->create()) {
                        echo "Post to database succesful. ";
                        echo "The song " . $song_name . " by " . $author_name . ", uploaded by " . $uploader . " has been uploaded. ";
                    } else {
                        echo "Post to database NOT succesful.";
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
    }
   header("Location: myLibrary.php"); //comment this to see echos from this script
?>