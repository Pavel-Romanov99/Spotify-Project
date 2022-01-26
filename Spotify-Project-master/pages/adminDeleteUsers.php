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
    <link rel="stylesheet" href="../styles/adminDeleteUsersStyles.css">
    <title>My Profile - Audiobits</title>
</head>
<body>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../scripts/deleteFriendAjax.js"></script>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>
        <div class="content-container">

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php";
                  include "../partials/friends-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <h1 class = "page-title">Delete Users</h1>

                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                    <script type="text/javascript" src="../scripts/adminActions.js"></script>

                    <?php 
                        $query_regular_users_list = "select * from users where is_admin = false"; //admins can only delete non-admin users
                        $regular_users_list_data = $mysqli->query($query_regular_users_list);

                        if($regular_users_list_data->num_rows > 0){
                            while($user = mysqli_fetch_assoc($regular_users_list_data)){
                            
                                $user_id = $user['user_id'];
                                $take_pic = "select * from users where user_id = '$user_id'";
                                $pic_data = $mysqli->query($take_pic);
                                $pic_result = mysqli_fetch_assoc($pic_data);
                                $pic_name = $pic_result['avatar_id']; 

                                echo '
                                <div class="delete-user-row">
                                    <img class="delete-user-avatar" src="../uploads-avatars/'.$pic_name.'" alt="">
                                    <div class="delete-user-info">
                                        <strong class = "username">'.$user['user_name'].'</strong>
                                        <span>'.$user_id.'</span>
                                    </div>

                                    <button class="delete-user-button" onclick="showConfirmationBox(\''.$user_id.'\');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="confirmation-box" id="confbox'.$user_id.'" style = "display: none;">
                                    <strong>Are you sure you want to delete user '.$user['user_name'].', including all his songs, playlists, shares and history?</strong>
                                    <div>
                                        <button class="confirmation-button" onclick="showConfirmationBox(\''.$user_id.'\'); adminDeleteUser(\''.$user_id.'\', \''.$user['user_name'].'\');">Yes</button>
                                        <button class="confirmation-button" onclick="showConfirmationBox(\''.$user_id.'\');">No</button>
                                    </div>
                                </div>
                                ';
                            }
                        }else {
                            echo "There are no regular users! ";
                        }
                    ?>

                </div>
                <?php include '../partials/player.php';?>
            </div>
        </div>
    </div>
</body>
</html>