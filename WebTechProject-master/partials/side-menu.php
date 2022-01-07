<link rel="stylesheet" href="./styles/side-menu.css">

<aside class="side-menu">
    <div class="side-menu-container">
        <img class="profile-picture" src="img/avatar.png" alt="">
        <h2><?php echo $current_user_data["user_name"] ?></h2>
        <a class = "side-button" href="home.php">Home</a>
        <a class = "side-button" href="myProfile.php">My Profile</a>
        <a class = "side-button" href="myLibrary.php">My Library</a>
        <a class = "side-button" href="">Recommendations</a>
        <a class = "side-button" href="">Add your songs</a>
    </div>
</aside>