<?php
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //we take the username and password from the post request
        $user_name = $_POST['username'];
        $password = $_POST['password'];
        //we create a unique user id
        $user_id = uniqid();


        if(!empty($user_name) && !empty($password)){
            //hash the password
            $hashed_password = sha1($password);

            $query = "insert into users (user_id, user_name, password) values ('$user_id', '$user_name', '$hashed_password')";

            if($mysqli->query($query)){
                echo "new record added to db";
            }else {
                echo $mysqli->error;
            }
            
            header("Location: login.php");
            die;
        }else {
            echo "Please fill in all fields";
        }
    } 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<body>
    <div>
        <h1>This is the register page</h1>
        <form action="" method="POST">
            <label for="">Username: <input type="text" name="username"></label>
            <label for="">Password: <input type="password" name="password"></label>
            <button type="submit">Register</button>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>