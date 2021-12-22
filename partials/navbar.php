<nav class="nav-bar">
            <div class="logo-nav">
                <div class="logo">
                    Music Geeks
                </div>
                <div class="signup-buttons">

                        <?php if($current_user_data) { ?>
                        <button><a href="logout.php">Logout</a></button>
                        <?php } ?>

                        <?php if(!$current_user_data) { ?>
                        <button><a href="login.php">Login</a></button>
                        <button><a href="register.php">Register</a></button>
                        <?php } ?>
                    </div>  
                </div>
                <div class="nav-nav">
                    <div class="menu-container">
                    <a href="">Playlists</a>
                    <a href="">Recommendations</a>
                    <a href="">Add your songs</a>
                    </div>
                </div>
            </div>
</nav>