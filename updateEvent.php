<?php 
session_start();
    include("connection.php");	
    include("functions.php");


    $query = "UPDATE users SET attended_current_event = 0 WHERE attended_current_event = 1"
    mysqli_query($con, $query);

?>
