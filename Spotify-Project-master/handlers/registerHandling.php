<?php
    include("../utility/functions.php");
    include("../utility/connection.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //we take the username and password from the post request
        $user_name = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $course_year = $_POST['year'];
        //we create a unique user id
        $user_id = uniqid();
        
        $errors = array();

        if(!empty($user_name) && !empty($password) && !empty($password2) && !empty($course_year)){
            //checking if username contains spaces
            if($user_name == trim($user_name) && strpos($user_name, ' ') == false){

                $checkUser = "Select * from users where user_name = '$user_name'";

                $data = $mysqli->query($checkUser);

                if($data && $data->num_rows > 0){
                    $errors['duplicate'] = "Username is taken!";
                }
                else {
                    if(preg_match("/^[\w\d\s.,-]*$/", $user_name)){
                        if(strlen($user_name) < 31)
                        {
                            if($password == $password2){

                                if(strlen($password) < 5){
                                    $errors['length'] = "Password must be atleast 6 symbols!";
                                }
                                else {
                                    //hash the password
                                    $hashed_password = sha1($password);

                                    $query_insert_new_user_data = "insert into users (course_year, user_id, user_name, password, avatar_id, is_admin) values ('$course_year', '$user_id', '$user_name', '$hashed_password', 'default-avatar.png', false)";
                    
                                    if($mysqli->query($query_insert_new_user_data)){
                                        echo "New record added to database! ";
                                    }else {
                                        echo $mysqli->error;
                                    }

                                    //create the user song history table
                                    $history_table_name = 'history'.$user_id; //creating a unique history table name
                                    $playlists_table_name = 'playlists'.$user_id; //creating a unique playlists table name

                                    $query_create_user_history = "create table `".$history_table_name."` (
                                                                    id int auto_increment not null,
                                                                    song_id varchar(100) not null,
                                                                    cover_id varchar(100) not null,
                                                                    name varchar(100) not null,
                                                                    author varchar(100) not null,
                                                                    date timestamp not null default current_timestamp on update current_timestamp,
                                                                    primary key (id))";

                                    $query_create_user_playlists = "create table `".$playlists_table_name."` (
                                                                    id int auto_increment not null,
                                                                    song_id varchar(100) not null,
                                                                    playlist varchar(100) not null,
                                                                    position int not null,
                                                                    primary key (id))";

                                    if($mysqli->query($query_create_user_history)){
                                        echo "User history table successfully created! ";
                                    }else echo $mysqli->error;

                                    if($mysqli->query($query_create_user_playlists)){
                                        echo "User playlists table successfully created! ";
                                    }else echo $mysqli->error;
                                    
                                    header("Location: login.php");
                                    die;    
                                }
                            }else {
                                $errors['matching'] = "Passwords do not match!";
                            }
                        }else {
                            $errors['username_length'] = "The username cannot be more than 30 symbols long! ";
                        }
                    }else {
                        $error['characters'] = "Username can contain only latin characters, numbers and punctuation!";
                    }
                }
            }else {
                $errors['spaces'] = "The username can't contain spaces!";
            }
        }else {
            $errors['empty'] = "Please fill in all fields!";
        }
    } 
?>