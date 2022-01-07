<nav class="nav-bar">
            <div class="logo-nav">
                <div class="logo" onclick="location.href='home.php';" style="cursor: pointer;">
                    <img src = "img/logo.jpg" class = "logo-image" style = "float: left;">
                    <div class = "logo-text">Audiobits</div>
                </div>
                
                <?php if($current_user_data) { ?>
                <a class = "signup-buttons" href="logout.php">Logout</a>
                <?php } ?>

                <?php if(!$current_user_data) { ?>
                <a class = "signup-buttons" href="login.php">Login</a>
                <a class = "signup-buttons" href="register.php">Register</a>
                <?php } ?>
                    
                </div>
            </div>
</nav>