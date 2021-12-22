<?php
    session_start();
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $user_name = $_POST['username'];
        $password = $_POST['password'];
        
        if(!empty($user_name) && !empty($password)){
            $query = "Select * from users where user_name = '$user_name'";
            
            $data = $mysqli->query($query);

            if($data && $data->num_rows > 0){

                $result = mysqli_fetch_assoc($data);
                
                $hashed_password = sha1($password);
                if($hashed_password == $result['password']){

                    $_SESSION['user_id'] = $result['user_id'];
                    header('Location: home.php');
                }else{
                    echo "Incorrect username or password\n";
                }
            }else{
                echo "Incorrect username or password\n"; 
            }
        }else{
            echo "Please fill in all fields\n";
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <div>
        <h1>This is the Login page</h1>
        <form method="POST">
            <label for="">Username: <input type="text" name="username"></label>
            <label for="">Password: <input type="password" name="password"></label>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>