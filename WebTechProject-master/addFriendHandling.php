<?php
    session_start();
    include("functions.php");
    include("connection.php");

    $current_user_data = checkLogin($mysqli);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //get the name in the post request
        $user_name = $_POST['friend-username'];
        //we take the data from the logged in user

        $current_user_id = $_SESSION['user_id'];
        
        if(!empty($user_name)){

            //we find the data of the friend user
            $query = "Select * from users where user_name = '$user_name'";
            
            $data = $mysqli->query($query);

            if($data && $data->num_rows > 0){

                $result = mysqli_fetch_assoc($data);
                $friend_username = $result['user_name'];
                $friend_id = $result['user_id'];
                
                $query_add = "insert into friends (user_id, friend_id, friend_username) values ('$current_user_id', '$friend_id', '$friend_username')";

                if($mysqli->query($query_add)){
                    echo "new friend added to db";
                }else {
                    echo $mysqli->error;
                }

            }else{
                echo "No user found\n"; 
            }
        }else{
            echo "Cannot enter an empty username!\n";
        }
        header("Location: home.php");
    }else{
        echo "Ne stava";
    }
?>