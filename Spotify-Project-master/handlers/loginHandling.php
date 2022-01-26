<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $user_name = $_POST['username'];
        $password = $_POST['password'];

        $errors = array();
        
        if(!empty($user_name) && !empty($password)){
            $query = "Select * from users where user_name = '$user_name'";
            
            $data = $mysqli->query($query);

            if($data && $data->num_rows > 0){

                $result = mysqli_fetch_assoc($data);
                
                $hashed_password = sha1($password);
                if($hashed_password == $result['password']){

                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['course_year'] = $result['course_year'];
                    header('Location: home.php');
                }else{
                    $errors['incorrect'] = "Incorrect username or password\n";
                }
            }else{
                $errors['incorrect'] = "Incorrect username or password\n"; 
            }
        }else{
            $errors['empty'] = "Please fill in all fields\n";
        }

    }
?>