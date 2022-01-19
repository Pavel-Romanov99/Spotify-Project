<?php

function checkLogin($mysqli){
    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];

        $query = "Select * from users where user_id = '$id'";

        $result = $mysqli->query($query);

        if($result && mysqli_num_rows($result) > 0){

            $data = mysqli_fetch_assoc($result);
            return $data;   
        }
    }
}


function getPic($mysqli, $user_name){

}