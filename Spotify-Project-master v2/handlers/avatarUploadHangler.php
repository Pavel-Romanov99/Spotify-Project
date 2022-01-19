<?php
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

        session_start();
        include("../utility/functions.php");
        include("../utility/connection.php");
     
        $current_user_data = checkLogin($mysqli);

        //for getting the path of the avatar directory
        $currentDirOneUp = dirname(__DIR__);
        $avatarUploadDir = "/uploads-avatars/";

        //getting an id for the avatar
        $avatar_id = uniqid();

        //get the current user_id for making the query
        $user = $current_user_data['user_name'];

        //if a no avatar image is chosen then use the default one
        if($_FILES['avatar']['size'] == 0)
            $hasAvatar = false;
        else $hasAvatar = true;

        $errors = [];

        if($hasAvatar){
            $avatarName = $_FILES['avatar']['name'];
            $avatarTmpName =  $_FILES['avatar']['tmp_name'];
            $avatarExtension = strtolower(pathinfo($avatarName,PATHINFO_EXTENSION));
            $avatarUploadPath = $currentDirOneUp . $avatarUploadDir . $avatar_id . "." . $avatarExtension; 
            $avatar_id = $avatar_id . "." .$avatarExtension; //adding the extension to the id, written in the DB, for future access to the file via the id only

            if($avatarExtension != "jpg" && $avatarExtension != "png" && $avatarExtension != "jpeg") {
                $errors['format'] = "Only PNG, JPG and JPEG formats are supported!";
            }else{
                $didCoverUpload = move_uploaded_file($avatarTmpName, $avatarUploadPath);
                
                $query_upload_avatar = "update users set avatar_id = '$avatar_id' where user_name = '$user'";

                if($mysqli->query($query_upload_avatar)){
                    echo "Profile picture changed";
                    header("Location: ../pages/myProfile.php");
                }else{
                    echo $mysqli->error;
                }
            }
        }else{
            foreach ($errors as $error) {
                echo "The following error occured: " . $error;
            }
        }

?>

