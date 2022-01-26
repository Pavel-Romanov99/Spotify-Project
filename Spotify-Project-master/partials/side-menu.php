<link rel="stylesheet" href="../styles/sideMenuStyles.css">

<aside class="side-menu">
    <div class="side-menu-container">
        <div class="profile-div">

            <?php
                $id = $_SESSION['user_id'];

                $takePic = "select * from users where user_id = '$id'";

                $picData = $mysqli->query($takePic);

                if($picData && $picData->num_rows > 0){
                    $picResult = mysqli_fetch_assoc($picData);

                    $picName = $picResult['avatar_id'];
                    echo '<img class="profile-picture" src="../uploads-avatars/'.$picName.'" alt="">';
                }
            ?>
            <h2 class="user-title"><?php echo $current_user_data["user_name"] ?></h2>
        </div>
        <a class = "side-button" href="home.php">Home</a>
        <a class = "side-button" href="myProfile.php">My Profile</a>
        <a class = "side-button" href="myLibrary.php">My Library</a>
        <a class = "side-button" href="playlists.php">Playlists</a>
        <a class = "side-button" href="sharedSongs.php">Shared Songs</a>
        <a class = "side-button" href="myHistory.php">History</a>

        <?php 
            $current_user_data = checkLogin($mysqli);
            $is_admin = $current_user_data['is_admin'];

            if($is_admin){
                echo '<a class = "side-button" href="adminDeleteUsers.php">&ltadmin&gtDelete Users</a>
                      <a class = "side-button" href="adminDeleteSongs.php">&ltadmin&gtDelete Songs</a>';
            }
        ?>
    </div>
</aside>