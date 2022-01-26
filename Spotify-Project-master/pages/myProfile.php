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
    <link rel="stylesheet" href="../styles/myProfileStyles.css">
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
                    <div class="profile-content">
                        <h1>My Profile</h1>

                        <div class="avatar-form-container">
                            <h3>Change Avatar</h3>
                            
                            <div class="form-container">
                                <?php
                                    $id = $_SESSION['user_id'];

                                    $takePic = "select * from users where user_id = '$id'";

                                    $picData = $mysqli->query($takePic);

                                    if($picData && $picData->num_rows > 0){
                                        $picResult = mysqli_fetch_assoc($picData);

                                        $picName = $picResult['avatar_id'];
                                        echo ' <img class="avatar-picture" src="../uploads-avatars/'.$picName.'" alt="">';
                                    }
                                ?>
                                <form action="../handlers/avatarUploadHandling.php"  enctype="multipart/form-data" method="POST" class="avatar-form">
                                    <input type="button" class="my-profile-button" value="Choose avatar" onclick="document.getElementById('avatar-button').click();">
                                        <input type="file" id="avatar-button" name="avatar" style="display:none">

                                    <input type="hidden" name="old_avatar_id" value=<?php echo $current_user_data["avatar_id"];?> />    

                                    <input type="submit" class="my-profile-button upload-button" id="submit-button" name="submit-button" value="Upload">
                                </form> 
                                <p>Must be JPEG, PNG, or JPG and cannot exceed 10 MB.</p>

                            </div>
                              
                        </div>


                        <div class="change-password-container">
                            <?php
                                    if(isset($_SESSION['errors'])){
                                        echo '<h3 style="color:red">'.$_SESSION['errors'].'</h3>';
                                        unset($_SESSION['errors']); 
                                    }
                            ?>
                            <form action="../handlers/newPasswordHandling.php" method="POST" class="password-form">
                                <h3>Change Password</h3>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="password" placeholder="Old password...">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="new_password" placeholder="New password...">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="input-container">
                                        <img class="icon" src="../img/padlock.png" alt="">
                                        <input type="password" name="new_password2" placeholder="New password again...">
                                    </div>
                                </div>
                                <button type="submit" class="my-profile-button">Submit</button>
                            </form>
                        </div>

                        <div class="statistics-container">
                            <h3>User Statistics</h3>
                            <?php 
                                $table_name = "history" . $id;

                                $query_get_favourite_song = "select name, count(name) as frequency from `".$table_name."` group by name order by frequency desc limit 1";
                                $query_get_favourite_artist = "select author, count(author) as frequency from `".$table_name."` group by author order by frequency desc limit 1";
                                $favourite_song_data = $mysqli->query($query_get_favourite_song);
                                $favourite_artist_data = $mysqli->query($query_get_favourite_artist);

                                if($favourite_song_data->num_rows > 0){
                                    $favourite_song = mysqli_fetch_assoc($favourite_song_data)["name"];
                                }else {
                                    $favourite_song = "More data is needed...";
                                }

                                if($favourite_artist_data->num_rows > 0){
                                    $favourite_artist = mysqli_fetch_assoc($favourite_artist_data)["author"];
                                }else {
                                    $favourite_artist = "More data is needed...";
                                }

                                echo '
                                <p class = "statistics-name"><strong>Current Favourite Song: </strong></p>
                                <p id = "favourite-song">'.$favourite_song.'</p>
                                <p class = "statistics-name"><strong>Current Favourite Artist: </strong></p>
                                <p id = "favourite-artist">'.$favourite_artist.'</p>
                                '?>
                        </div>

                        <div class = "delete-friends-container">
                            <h3>Delete Friends</h3>
                            <div class = "inner-delete-friends-container">
                                <?php 
                                    $query_friends_list = "select * from friends where user_id = '$id'";
                                    $friends_list_data = $mysqli->query($query_friends_list);

                                    if($friends_list_data->num_rows > 0){
                                        while($friend = mysqli_fetch_assoc($friends_list_data)){
                                        
                                            $friend_id = $friend['friend_id'];
                                            $take_pic = "select * from users where user_id = '$friend_id'";
                                            $pic_data = $mysqli->query($take_pic);
                                            $pic_result = mysqli_fetch_assoc($pic_data);
                                            $pic_name = $pic_result['avatar_id']; 
    
                                            echo '
                                            <div class="delete-friend-row">
                                                <img class="delete-friend-avatar" src="../uploads-avatars/'.$pic_name.'" alt="">
                                                <div class="delete-friend-info">
                                                    <strong class = "username">'.$friend['friend_username'].'</strong>
                                                </div>

                                                <button class="delete-friend-button" onclick="deleteFriend(\''.$friend['friend_id'].'\', \''.$id.'\');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>';
                                        }
                                    }else {
                                        echo "You have no friends to delete!";
                                    }
                                ?>
                            </div> 
                        </div>

                    </div>
                </div>
                <?php include '../partials/player.php';?>
            </div>
        </div>
    </div>
</body>
</html>