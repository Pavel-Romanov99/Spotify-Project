<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $old_password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $new_password2 = $_POST['new_password2'];

    $user_id = $_SESSION['user_id'];

    $errors = array();

    if(!empty($old_password) && !empty($new_password) && !empty($new_password2)){
        
        $query = "Select * from users where user_id = '$user_id'";
        $data = $mysqli->query($query);

        if($data && $data->num_rows > 0){
            
            $result = mysqli_fetch_assoc($data);

            $hashed_old_pass = sha1($old_password);
            if($hashed_old_pass == $result['password']){
                
                if($new_password == $new_password2){

                    if(strlen($new_password) > 6){
                        $hashed_new_password = sha1($new_password);

                        $query_change_password = "update users set password = '$hashed_new_password' where user_id = '$user_id'";
    
                        if($mysqli->query($query_change_password)){
                            $errors['error'] = "Password changed successfully";
                            header("Location: ../pages/myProfile.php");
                        }else{
                            echo $mysqli->error;
                        }
                    }else {
                        $errors['error'] = "Password must be longer than 6 characters\n";
                        header("Location: ../pages/myProfile.php");
                    }

                }else {
                    $errors['error'] =  "New passwords do not match!\n";
                    header("Location: ../pages/myProfile.php");
                }
            }else {
                $errors['error'] =  "Incorrect old password\n";
                header("Location: ../pages/myProfile.php");

            }
        }else{
            $errors['error'] =  "Incorrect old password\n";
            header("Location: ../pages/myProfile.php");

        }
    }else{
        $errors['error'] =  "Please fill in all fields\n";
        header("Location: ../pages/myProfile.php");

    }
    $_SESSION['errors'] = $errors['error'];

?>