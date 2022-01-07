 <?php

include("connection.php");
include("functions.php");

$logFile = "deleteSong.log";
$id = $_POST['id'];
file_put_contents($logFile, $id);

echo $id;

$query = "delete from songs where song_id ='$id'";

$mysqli->query($query);
 
?>
