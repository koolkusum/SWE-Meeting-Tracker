<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if(isset($_POST['submit'])) {
        $query = "UPDATE users SET attended_current_event = 0 WHERE attended_current_event = 1";
        mysqli_query($con, $query);
    }
    if(isset($_POST['submit2'])) {
        $query = "UPDATE users SET attended_current_event = 1 WHERE attended_current_event = 0";
        mysqli_query($con, $query);
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="logout.php">Logout</a>
	<h1>This is the admin page</h1>

    <form method="post">
        <input type="submit" name="submit" value="Start Event">
    </form>
	<form method="post">
        <input type="submit2" name="submit2" value="End Event">
    </form>

	<br>
	Hello, <?php echo $user_data['user_name']; ?>
</body>
</html>