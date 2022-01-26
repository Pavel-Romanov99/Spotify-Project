<?php
//host name
$db_host = 'localhost';
//user name
$db_user = 'root';
//password
$db_password = 'root';
//database name
$db_db = 'spotifyproject';
//port of MySQL server
$db_port = 8889;

$mysqli = new mysqli(
  $db_host,
  $db_user,
  $db_password,
  $db_db,
  $db_port
);
  
if ($mysqli->connect_error) {
  echo 'Errno: '.$mysqli->connect_errno;
  echo '<br>';
  echo 'Error: '.$mysqli->connect_error;
  exit();
}

