<link rel="stylesheet" href="../styles/friendsMenuStyles.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/friendsLastSongAjax.js"></script>

<aside class="friends-container">
                 <div class="friends-list">
                 <script type="text/javascript">
                     updateLatestFriendsSong('<?php echo $_SESSION['user_id']?>');
                </script>
                        <h2>Friends Activity</h2>
                            <?php
                                $id = $_SESSION['user_id'];
                
                                $query_friends_list = "select * from friends where user_id = '$id'";
                                $friends_data = $mysqli->query($query_friends_list);

                                if($friends_data && $friends_data->num_rows > 0){
                                    while($friend = mysqli_fetch_assoc($friends_data)){
                                        
                                        $friend_id = $friend['friend_id'];
                                        $take_pic = "select * from users where user_id = '$friend_id'";
                                        $pic_data = $mysqli->query($take_pic);
                                        $pic_result = mysqli_fetch_assoc($pic_data);
                                        $pic_name = $pic_result['avatar_id']; 
                                        $course_year = $pic_result['course_year'];

                                        if($course_year != 100){
                                            echo '<div class="friends-content">
                                            <img class="avatar" src="../uploads-avatars/'.$pic_name.'" alt="">
                                            <div class="friend-info">
                                                <strong class = "username">'.$friend['friend_username'].' from KN'.$course_year.'</strong>
                                                <span id = "'.$friend['friend_id'].'" class = "last-song"></span>
                                            </div>
                                            <img class="music-icon" src="../img/music_img.svg" alt="">
                                            </div>';
                                        }else {
                                            echo '<div class="friends-content">
                                            <img class="avatar" src="../uploads-avatars/'.$pic_name.'" alt="">
                                            <div class="friend-info">
                                                <strong class = "username">'.$friend['friend_username'].'</strong>
                                                <span id = "'.$friend['friend_id'].'" class = "last-song"></span>
                                            </div>
                                            <img class="music-icon" src="../img/music_img.svg" alt="">
                                            </div>';
                                        }

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