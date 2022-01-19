<link rel="stylesheet" href="../styles/friendsMenuStyles.css">

<aside class="friends-container">
                 <div class="friends-list">
                        <h2>Friends Activity</h2>
                            <?php
                                $id = $_SESSION['user_id'];
                
                                $query_friends_list = "select * from friends where user_id = '$id'";
                                $friends_data = $mysqli->query($query_friends_list);

                                if($friends_data && $friends_data->num_rows > 0){
                                    while($friend = mysqli_fetch_assoc($friends_data)){

                                        $friend_id = $friend['friend_id'];
                                        $takePic = "select * from users where user_id = '$friend_id'";

                                        $picData = $mysqli->query($takePic);
                                        
                                        
                                        $picResult = mysqli_fetch_assoc($picData);

                                        $picName = $picResult['avatar_id']; 

                                        echo '<div class="friends-content">
                                            <img class="avatar" src="../uploads-avatars/'.$picName.'" alt="">
                                            <div class="friend-info">
                                                <strong class = "username">'.$friend['friend_username'].'</strong>
                                                <span class = "current-song">Drake - Nonstop</span>
                                            </div>
                                            <img class="music-icon" src="../img/music_img.svg" alt="">
                                        </div>';
                                    }

                                }else{
                                    echo "No friends found\n"; 
                                }
                            ?>
                        <?php
                            if(empty($_SESSION['error'])){
                            
                            }else{ ?>
                                <h4 style="color:red"><?php echo $_SESSION['error'] ?> </h4>
                                <?php
                                unset($_SESSION['error']);
                                }
                        ?>
                        <form  action="../handlers/addFriendHandling.php" method="POST" id = "add-friends-form">
                            <div class = "friends-search-container">
                                <input type="text" class ="friends-search" placeholder="Search username..." name="friend-username">
                                <button type="submit" class="add_friend">Add Friend</button>
                            </div>
                        </form>
                 </div>
</aside>