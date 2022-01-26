<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);

    $errors = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //get the name in the post request
        $user_name = $_POST['friend-username'];
        //we take the data from the logged in user
        $current_user_id = $_SESSION['user_id'];
        $current_user_course_year = $_SESSION['course_year'];
        
        if(!empty($user_name)){

            //we find the data of the friend user
            $query = "Select * from users where user_name = '$user_name'";
            
            $data = $mysqli->query($query);

            if($data && $data->num_rows > 0){

                $result = mysqli_fetch_assoc($data);
                $friend_username = $result['user_name'];
                $friend_id = $result['user_id'];
                $friend_course_year = $result['course_year'];

                if($friend_id != $current_user_id && ($current_user_course_year == $friend_course_year || $friend_course_year == 100 || $current_user_course_year == 100)){
                    $query_add = "insert into friends (user_id, friend_id, friend_username) values ('$current_user_id', '$friend_id', '$friend_username')";

                    $alreadyFriends = "select * from friends where user_id = '$current_user_id' and friend_id = '$friend_id'";

                    $alreadyFriendsData = $mysqli->query($alreadyFriends);

                    if($alreadyFriends->num_rows > 0){
                        $_SESSION['error'] = "You are already friends!";
                    }
                    else{
                        if($mysqli->query($query_add)){
                            echo "New friend added to database!";
                        }else {
                            echo $mysqli->error;
                        }
                    }
                }else {
                    $_SESSION['error'] = "User is not in your course";
                }
            }else{
                $_SESSION['error'] = "User not found!";
            }
        }else{
            $_SESSION['error'] = "Username cannot be empty";
        }
        header("Location: ../pages/home.php");
        die;
    }else{
        echo "No data sent in POST!";
    }
?>