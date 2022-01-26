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

                    if($old_password !== $new_password)
                    {
                        if(strlen($new_password) > 5){
                            $hashed_new_password = sha1($new_password);

                            $query_change_password = "update users set password = '$hashed_new_password' where user_id = '$user_id'";
        
                            if($mysqli->query($query_change_password)){
                                $errors['error'] = "Password changed successfully";
                            }else{
                                echo $mysqli->error;
                            }
                        }else {
                            $errors['error'] = "Password must be atleast 6 characters\n";
                        }
                    }else {
                        $errors['error'] = "New password cannot be the same as the old one\n";
                    }
                }else {
                    $errors['error'] =  "New passwords do not match!\n";
                }
            }else {
                $errors['error'] =  "Incorrect old password\n";
            }
        }else{
            $errors['error'] =  "Incorrect old password\n";
        }
    }else{
        $errors['error'] =  "Please fill in all fields\n";
    }
    $_SESSION['errors'] = $errors['error'];
    header("Location: ../pages/myProfile.php");
?>