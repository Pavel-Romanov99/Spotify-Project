<?php
    session_start();
    include("../utility/functions.php");
    include("../utility/connection.php");

    $current_user_data = checkLogin($mysqli); 
    
    if(!$current_user_data){
        header("Location: login.php");
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/universalStyles.css">
    <link rel="stylesheet" href="../styles/myLibraryStyles.css">
    <title>Audiobits</title>
</head>
<body>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>

        <div class="content-container">
            

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <div class="greetings-message">
                        <h1>Welcome back, <?php echo $current_user_data["user_name"]?> !</h1>
                    </div>


                    <div id="artists">
                        <form class="search-form" method="POST">
                            <input class="search-bar" placeholder="Search artist..." type="text" name="artist" id="artist_field">
                            <button id="search_artist" type="submit">Search Artist</button>
                        </form>
                        <ul id="tracks">
                        <?php
                                if(isset($_SESSION['artist_error'])){
                                    echo '<h3 style="color:red">'.$_SESSION['artist_error'].'</h3>';
                                    unset($_SESSION['artist_error']); 
                                }
                        ?>
                        <?php
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $errors = array();
                                $artist_name = $_POST['artist'];

                                if(!empty($artist_name)){
                                    
                                    $query = "select * from songs where uploader = '$artist_name' or name = '$artist_name' or author = '$artist_name'";

                                    $data = $mysqli->query($query);

                                    if($data && $data->num_rows > 0){
                                        
                                        echo '<h3>Found '.$data->num_rows.' songs from you searching '.$artist_name.'</h3>';

                                        while($song = mysqli_fetch_assoc($data)){
                                            
                                            $song_adress = strval($song['song_id']);

                                            echo '<div class="song-content">
                                            <img class="cover-icon" src="../uploads-covers/'.$song['cover_id'].'" alt="">
                                            <div class="song-info">
                                                <strong>'.$song['name'].'</strong>
                                                <span>by '.$song['author'].', <span class="grey-text"> uploader: '.$song['uploader'].'</span></span>
                                            </div>

                                            <button  class="songs-list-button" onclick="loadSong(\''.$song_adress.'\', \''.$song['name'].'\', \''.$song['author'].'\', \''.$song['cover_id'].'\', true);" >
                                                <i class="fas fa-play"></i>
                                            </button>
                                            </div>';
                                        }
                                        header("Location: home.php");
                                    }else {
                                        $_SESSION['artist_error'] = "Could not find artist\n";
                                        header("Location: home.php");

                                    }

                                }else{
                                    $_SESSION['artist_error'] = "Please enter an artist\n";
                                    header("Location: home.php");

                                }
                            }
                        ?>
                        </ul>
                    </div>
                </div>
                <?php include '../partials/player.php';?>
            </div>


            <?php if($current_user_data) { ?>
            <?php include "../partials/friends-menu.php"; ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>