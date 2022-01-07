<?php
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //we take the username and password from the post request
        $user_name = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        //we create a unique user id
        $user_id = uniqid();
        
        $errors = array();

        if(!empty($user_name) && !empty($password) && !empty($password2)){

            $checkUser = "Select * from users where user_name = '$user_name'";

            $data = $mysqli->query($checkUser);

            if($data && $data->num_rows > 0){
                $errors['duplicate'] = "Username is taken!";
            }
            else {
                 if($password == $password2){

                    if(strlen($password) < 6){
                        $errors['length'] = "Password cannot be shorter than 6 symbols!";
                    }
                    else {
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
                    }
                }
                else 
                {
                    $errors['matching'] = "Passwords do not match!";
                }
            }
        }else {
            $errors['empty'] = "Please fill in all fields!";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css"></link>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&family=Oswald:wght@300&display=swap" rel="stylesheet">  
    <title>Register Page</title>
</head>
<body>
    <div class="container">   
        <div class="right-container">
            <div class="form-container">
                <div class="logo">
                    <img src="./img/logo.png" alt="">
                    <h1>AudioBits</h1>
                </div>
                <?php
                    if(empty($errors)){
                       
                    }else{
                    foreach($errors as $key => $value)
                        { ?>
                        <h3 style="color:red"><?php echo $value.PHP_EOL; ?> </h3>
                        <?php
                        }
                    }
                ?>
                <form method="POST">
                    <div class="field">
                        <label for="username">Username</label>
                        <div class="input-container">
                            <img class="icon" src="./img/user.png" alt="">
                            <input type="text" name="username" id="username">
                        </div>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-container">
                            <img class="icon" src="./img/padlock.png" alt="">
                            <input type="password" name="password">
                        </div>
                    </div>
                    <div class="field">
                        <label for="password">Repeat Password</label>
                        <div class="input-container">
                            <img class="icon" src="./img/padlock.png" alt="">
                            <input type="password" name="password2">
                        </div>
                    </div>
                    <label class="signup-link" for="">Already have an account? <a href="login.php">Log In</a> </label>
                    <button type="submit">Register</button>
                </form>
            </div>
        </div> 
        <div class="image-container">
            <img id="cover-image" src="./img/register-cover.svg" alt="">
        </div> 
    </div>
</body>
</html>