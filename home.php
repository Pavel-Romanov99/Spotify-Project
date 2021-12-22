<?php
    session_start();
    include("functions.php");
    include("connection.php");

    $current_user_data = checkLogin($mysqli);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //get the name in the post request
        $user_name = $_POST['friend-username'];
        //we take the data from the logged in user

        $current_user_id = $_SESSION['user_id'];
        
        if(!empty($user_name)){

            //we find the data of the friend user
            $query = "Select * from users where user_name = '$user_name'";
            
            $data = $mysqli->query($query);

            if($data && $data->num_rows > 0){

                $result = mysqli_fetch_assoc($data);
                $friend_username = $result['user_name'];
                $friend_id = $result['user_id'];
                
                $query_add = "insert into friends (user_id, friend_id, friend_username) values ('$current_user_id', '$friend_id', '$friend_username')";

                if($mysqli->query($query_add)){
                    echo "new friend added to db";
                }else {
                    echo $mysqli->error;
                }
                
               header("Location: home.php");

            }else{
                echo "No user found\n"; 
            }
        }else{
            echo "Cannot enter an empty username!\n";
        }

    }else{
        echo "Ne stava";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <title>Homepage</title>
</head>
<body onload="onPageLoad()">

    <div class="container">
        <?php include './partials/navbar.php'; ?>

        <div class="content-container">
            

            <?php if($current_user_data) { ?>
            <?php include "./partials/side-menu.php"; ?>
            <?php } ?>

            <div class="track-container">
                <div class="content">
                    <div class="greetings-message">
                        <h1>Good afternoon, <?php echo $current_user_data["user_name"]?> !</h1>
                    </div>


                    <div id="artists">
                        <form class="search-form">
                            <input class="search-bar" placeholder="Search..." type="text" id="artist_field">
                            <button id="search_artist">Search Artist</button>
                        </form>
                        <ul id="tracks">

                        </ul>
                    </div>
                </div>
                <?php include 'player.php';?>
            </div>


            <?php if($current_user_data) { ?>
            <?php include "./partials/friends-menu.php"; ?>
            <?php } ?>
        </div>
    </div>

    <script src="./scripts/app.js"></script>
</body>
</html>