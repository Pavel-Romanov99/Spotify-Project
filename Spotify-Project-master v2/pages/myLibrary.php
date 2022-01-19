<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/universalStyles.css">
    <link rel="stylesheet" href="../styles/myLibraryStyles.css">
    <title>My Library - Audiobits</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
    />
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
                <?php include '../partials/player.php';?>
                <div class = "content">

                    <div class="page-title">
                        <h1>My Library</h1>
                    </div>

                    <div class = "song-upload">
                        <span id = "upload-messages">Upload your own songs! The cover image is not required.</span>

                        <form id="song-upload-form" enctype="multipart/form-data" action="../handlers/songUploadHandling.php" method="POST">

                            <input class="form-field" name="author_name" placeholder="Enter author name..." >
                            <input class="form-field" name="song_name" placeholder="Enter song name..." >

                            <input type="button" class="form-button" value="Choose cover image" onclick="document.getElementById('cover-button-hidden').click();">
                                <input type="file" id="cover-button-hidden" name="cover" style="display:none">

                            <input type="button" class="form-button" value="Choose .mp3 file" onclick="document.getElementById('mp3-button-hidden').click();" >
                                <input type="file" id="mp3-button-hidden" name="mp3" style="display:none" >

                            <input type="hidden" name="username" value=<?php echo $current_user_data["user_name"]?> />

                            <input type="submit" id="upload-button" name="submit-button" value="Upload">
                            
                        </form>

                        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
                        <script type="text/javascript" src="../scripts/songDeleteAjax.js"></script>
                        <script type="text/javascript" src="../scripts/songShareAjax.js"></script>
                        <script type="text/javascript" src="../scripts/songDownloadAjax.js"></script>
                        <script type="text/javascript" src="../scripts/songUploadFeedback.js"></script>
                        
                    </div>
                    
                    <?php
                        $username = $current_user_data["user_name"];
                        $id = $_SESSION['user_id'];
        
                        $query_songs_list = "select * from songs where user = '$username'";
                        $query_friends_list = "select * from friends where user_id = '$id'";

                        $songs_data = $mysqli->query($query_songs_list);
                        $friends_data = $mysqli->query($query_friends_list);
                        
                        if($songs_data->num_rows > 0){
                            while($song = mysqli_fetch_assoc($songs_data)){
                                $song_adress = strval($song['song_id']);
                                $cover_adress = strval($song['cover_id']);

                                echo '<div class="song-content">
                                    <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                    <div class="song-info">
                                        <strong>'.$song['name'].'</strong>
                                        <span>by '.$song['author'].', <span class="grey-text"> uploader: '.$song['uploader'].'</span></span>
                                    </div>
                                    <button  class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                        <i class="fas fa-play"></i>
                                    </button>

                                    <button class="songs-list-button">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                    <button class="songs-list-button dropdown">
                                        <i class="fas fa-share"></i>
                                        <div class="dropdown-content">
                                            <p id=\'msg'.$song_adress.'\' class = "message-box">Share song with:</p>
                                            <form id=\''.$song_adress.'\'>
                                                <div class = "checkbox-container">';
                                                //printing the content of the Share Song dropdown window
                                                if($friends_data && $friends_data->num_rows > 0){
                                                    while($friend = mysqli_fetch_assoc($friends_data)){
                                                        echo '<input type="checkbox" name=\''.$friend['friend_username'].'\'>
                                                            <label for=\''.$friend['friend_username'].'\' class="checkbox-label">'.$friend['friend_username'].'</label><br>';
                                                    }
                                                    echo '<input type="hidden" name="song_id" value=\''.$song_adress.'\'>
                                                </div> 
                                                <p class="share-button" onclick="return submitShareForm(\''.$song_adress.'\', event);">Share<p>';
                                                }
                                                else{
                                                    echo 'No friends found!';
                                                }  
                                                mysqli_data_seek($friends_data,0);//resetting the pointer
                                                unset($_SESSION['error']);

                                                echo'
                                            </form>
                                        </div>
                                    </button>
                                    
                                    <button class="songs-list-button">
                                        <a class ="download-link" href="../handlers/songDownloadHandling.php?song_id='.$song_adress.'&name='.urlencode($song['name']).'&author='.urlencode($song['author']).'">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </button>

                                    <button class="songs-list-button" onclick="deleteSong(\''.$song_adress.'\', \''.$cover_adress.'\');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>';
                            }
                        }else{
                            echo "No songs found!"; 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>