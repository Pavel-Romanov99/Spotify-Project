<aside class="friends-container">
                 <div class="friends-list">
                        <h2>Friends Activity</h2>
                            <?php
                                $id = $_SESSION['user_id'];
                
                                $query_friends_list = "select * from friends where user_id = '$id'";
                                $friends_data = $mysqli->query($query_friends_list);

                                if($friends_data && $friends_data->num_rows > 0){
                                    while($friend = mysqli_fetch_assoc($friends_data)){
                                        echo '<div class="friends-content">
                                            <img class="avatar" src="./img/avatar.png" alt="">
                                            <div class="friend-info">
                                                <strong>'.$friend['friend_username'].'</strong>
                                                <span>Drake - Nonstop   </span>
                                            </div>
                                            <img class="music-icon" src="./img/music_img.svg" alt="">
                                        </div>';
                                    }

                                }else{
                                    echo "No friends found\n"; 
                                }
                            ?>
                        <form  action="" method="POST">
                            <input type="text" placeholder="Find Friend.." name="friend-username">
                            <button type="submit" class="add_friend" style="width: 33%">Add Friend</button>
                        </form>
                </div>
</aside>