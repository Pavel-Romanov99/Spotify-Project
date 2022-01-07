<?php
    session_start();
    include("functions.php");
    include("connection.php");

    $current_user_data = checkLogin($mysqli);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/myLibraryStyles.css">
    <title>My Library</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
    />
</head>
<body onload="onPageLoad()">

    <div class="container">
        <?php include './partials/navbar.php'; ?>
        <div class="content-container">

            <?php if($current_user_data) { ?>
            <?php include "./partials/side-menu.php";
                  include "./partials/friends-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <?php include 'player.php';?>
                <div class = "content">

                    <div class="page-title">
                        <h1>My Library</h1>
                    </div>

                    <div class = "song-upload">
                        <span id = "upload-messages">Upload your own songs! The cover image is not required.</span>

                        <form id="song-upload-form" enctype="multipart/form-data" action="songUploadHandling.php" method="POST">

                            <input class="form-field" name="author_name" placeholder="Enter author name..." >
                            <input class="form-field" name="song_name" placeholder="Enter song name..." >

                            <input type="button" class="form-button" value="Choose cover image" onclick="document.getElementById('cover-button-hidden').click();">
                                <input type="file" id="cover-button-hidden" name="cover" style="display:none">

                            <input type="button" class="form-button" value="Choose .mp3 file" onclick="document.getElementById('mp3-button-hidden').click();" >
                                <input type="file" id="mp3-button-hidden" name="mp3" style="display:none" >

                            <input type="hidden" name="username" value=<?php echo $current_user_data["user_name"]?> />

                            <input type="submit" id="submit-button" name="submit-button" value="Upload">
                            
                        </form>

                        <script type="text/javascript" src="./scripts/songUploadFeedback.js"></script>
                        
                    </div>
                    
                    <?php
                        $id = $current_user_data["user_name"];
        
                        $query_songs_list = "select * from songs where user = '$id'";
                        $songs_data = $mysqli->query($query_songs_list);
                        

                        if($songs_data && $songs_data->num_rows > 0){
                            while($song = mysqli_fetch_assoc($songs_data)){
                                $song_adress = strval($song['song_id']);
                                echo '<div class="song-content">
                                    <img class="cover-icon" src="./uploads-covers/'.$song['cover_id'].'" alt="">
                                    <div class="song-info">
                                        <strong>'.$song['name'].'</strong>
                                        <span>by '.$song['author'].', <span class="grey-text"> uploader: '.$song['uploader'].'</span></span>
                                    </div>
                                    <button id="INSERT ID1 HERE" class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['cover_id'].'\');" >
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button id="INSERT ID2 HERE" class="songs-list-button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button id="INSERT ID3 HERE" class="songs-list-button">
                                        <i class="fas fa-share"></i>
                                    </button>
                                    <button id="INSERT ID3 HERE" class="songs-list-button" onclick="deleteSong(\''.$song_adress.'\');">
                                    <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>';
                            }
                        }else{
                            echo "No songs found\n"; 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="./scripts/app.js"></script>
    <script src="./scripts/player.js"></script>
</body>
</html>