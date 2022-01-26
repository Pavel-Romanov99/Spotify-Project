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
    <link rel="stylesheet" href="../styles/homeStyles.css">
    <title>Audiobits</title>
</head>
<body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../scripts/songAcceptDiscardAjax.js"></script>

    <div class="container">
        <?php include '../partials/navbar.php'; ?>

        <div class="content-container">
            

            <?php if($current_user_data) { ?>
            <?php include "../partials/side-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <div class="greetings-message">
                        <h1>Greetings, <?php echo $current_user_data["user_name"]?> !</h1>
                    </div>


                    <div id="artists">
                        <form class="search-form" method="POST">
                            <input class="search-bar" placeholder="Search artist, song, or uploader..." type="text" name="search_term" id="artist_field">
                            <button id="search_artist" type="submit">Search</button>
                        </form>
                        <ul id="tracks">
                        <?php
                                
                        ?>
                        <?php
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $errors = array();
                                $search_term = $_POST['search_term'];

                                if(!empty($search_term)){
                                    
                                    $query = "select distinct song_id, cover_id, name, author, uploader from songs where uploader = '$search_term' or name = '$search_term' or author = '$search_term'";

                                    $data = $mysqli->query($query);

                                    if($data && $data->num_rows > 0){
                                        
                                        echo '<h3>Found '.$data->num_rows.' songs from you searching \''.$search_term.'\'</h3>';

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

                                                <button class="songs-list-button" onclick="acceptDiscardSong(\''.$song_adress.'\', true);">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>';
                                        }
                                    }else {
                                        echo "<h3 class = 'error-message'>No results found</h3>";
                                    }

                                }else{
                                    echo "<h3 class = 'error-message'>Please enter something to search</h3>";
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