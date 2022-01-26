<?php include '../handlers/loginHandling.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginRegisterStyles.css"></link>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&family=Oswald:wght@300&display=swap" rel="stylesheet">  
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="../img/login-cover.svg" alt="">
        </div>    
        <div class="right-container">
            <div class="form-container">
                <div class="logo">
                    <img src="../img/logo.png" alt="">
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
                            <img class="icon" src="../img/user.png" alt="">
                            <input type="text" name="username" id="username">
                        </div>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-container">
                            <img class="icon" src="../img/padlock.png" alt="">
                            <input type="password" name="password">
                        </div>
                    </div>
                    <label class="signup-link" for="">Don't have an account? <a href="register.php">Sign Up</a> </label>
                    <button type="submit">Login</button>
                </form>
            </div>
            <div class="creators">
                <p>Created by Pavel & Yavor</p>
                <p>w17ed-KN2021</p>
            </div>
        </div>
    </div>
</body>
</html>