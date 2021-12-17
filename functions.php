<?php

function checkLogin($con){
    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];

        $query = "Select * from users where user_id = '$id'";

        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0){

            $data = mysqli_fetch_assoc($result);
            return $data;   
        }
    }else {
        //if we don't have a logged in user
        header('Location: login.php');
        die;
    }
}