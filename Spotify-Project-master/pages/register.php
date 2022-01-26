<?php include '../handlers/registerHandling.php';?>

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
    <title>Register Page</title>
</head>
<body>
    <div class="container">   
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
                    <div class="field">
                        <label for="password">Repeat Password</label>
                        <div class="input-container">
                            <img class="icon" src="../img/padlock.png" alt="">
                            <input type="password" name="password2">
                        </div>
                    </div>
                    <div class="course-year-container">
                        <label>Select course year </label>
                        <select id="course-year" name="year">
                            <option value="100" selected="selected">--- Choose a year ---</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2022">2023</option>
                        </select>
                    </div>
                    <label class="signup-link" for="">Already have an account? <a href="login.php">Log In</a> </label>
                    <button type="submit">Register</button>
                </form>
            </div>
            <div class="creators">
                <p>Created by Pavel & Yavor</p>
                <p>w17ed-KN2021</p>
            </div>
        </div> 
        <div class="image-container">
            <img id="cover-image" src="../img/register-cover.svg" alt="">
        </div> 
    </div>
</body>
</html>