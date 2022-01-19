<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/universalStyles.css">
    <link rel="stylesheet" href="../styles/myProfile.css">
    <title>My Profile - Audiobits</title>
</head>
<body>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>
        <div class="content-container">

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php";
                  include "../partials/friends-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <div class="profile-content">
                        <h1>My Profile</h1>

                        <div class="avatar-form-container">
                            <?php
                                $id = $_SESSION['user_id'];

                                $takePic = "select * from users where user_id = '$id'";

                                $picData = $mysqli->query($takePic);

                                if($picData && $picData->num_rows > 0){
                                    $picResult = mysqli_fetch_assoc($picData);

                                    $picName = $picResult['avatar_id'];
                                    echo ' <img class="profile-picture" src="../uploads-avatars/'.$picName.'" alt="">';
                                }
                            ?>
                            <div class="form-container">
                                <form action="../handlers/avatarUploadHangler.php"  enctype="multipart/form-data" method="POST" class="avatar-form">
                                    <input type="button" class="side-button" value="Choose avatar" onclick="document.getElementById('avatar-button').click();">
                                    <input type="file" id="avatar-button" name="avatar" style="display:none">
                                    <input type="submit" id="submit-button" name="submit-button" value="Upload">
                                </form> 
                                <p>Must be JPEG, PNG, or JPG and cannot exceed 10MB.</p>
                            </div>
                              
                        </div>


                        <div class="change-password-container">
                            <?php
                                    if(isset($_SESSION['errors'])){
                                        echo '<h3 style="color:red">'.$_SESSION['errors'].'</h3>';
                                        unset($_SESSION['errors']); 
                                    }
                            ?>
                            <form action="../handlers/newPassword.php" method="POST" class="password-form">
                                <h3>Change Password</h3>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="password" placeholder="Old password">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="new_password" placeholder="New password">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="new_password2" placeholder="New password">
                                    </div>
                                </div>
                                <button type="submit" class="side-button">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include '../partials/player.php';?>
            </div>
        </div>
    </div>
</body>
</html>