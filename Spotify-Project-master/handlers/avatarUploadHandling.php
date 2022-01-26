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
        $old_avatar_id = $_POST['old_avatar_id'];

        $errors = [];
        echo $_FILES['avatar']['size'];
        if($_FILES['avatar']['size'] < 10485760) {//10MB max avatar size

            if($_FILES['avatar']['size'] !== 0){//if file is empty

                $avatarName = $_FILES['avatar']['name'];
                $avatarTmpName =  $_FILES['avatar']['tmp_name'];
                $avatarExtension = strtolower(pathinfo($avatarName,PATHINFO_EXTENSION));
                $avatarUploadPath = $currentDirOneUp . $avatarUploadDir . $avatar_id . "." . $avatarExtension; 
                $avatar_id = $avatar_id . "." .$avatarExtension; //adding the extension to the id, written in the DB, for future access to the file via the id only

                if($avatarExtension != "jpg" && $avatarExtension != "png" && $avatarExtension != "jpeg") {
                    echo "File is not in correct format!";
                }else{
                    $didAvatarUpload = move_uploaded_file($avatarTmpName, $avatarUploadPath);
                    
                    $query_upload_avatar = "update users set avatar_id = '$avatar_id' where user_name = '$user'";

                    if($didAvatarUpload)
                    {
                        if($mysqli->query($query_upload_avatar)){
                            echo "Profile picture changed";

                            //using unlink() function to delete the old avatar if it's not the default one
                            if(strcmp($old_avatar_id, "default-avatar.png") !== 0)
                            {
                                $old_avatar_pointer = getcwd() . "/../uploads-avatars/" . $old_avatar_id; 
                            
                                if (!unlink($old_avatar_pointer)) 
                                { 
                                    echo "$old_avatar_pointer cannot be deleted due to an error!"; 
                                } 
                                else 
                                { 
                                    echo "$old_avatar_pointer has been deleted!"; 
                                }
                            }

                        }else{
                            echo $mysqli->error;
                        }
                    }else{
                        echo "Cannot upload file!";
                    }    
                }
            }else{
               echo "File is empty!";
            }
        }else{
            echo "Selected file is over 10 MB!";
        }
        header("Location: ../pages/myProfile.php"); //comment this to see echos from this script
?>

