<?php 
session_start();

	include("connection.php");
	include("functions.php");	
	include("sessionInfo.php");


	$user_data = check_login($con);

    if(isset($_POST['submit'])) {

        $id = 3; // The ID of the row to update
    	$query = "SELECT attendances FROM users WHERE user_name = '$user_netID'";
		$new_num_of_attendances = mysqli_query($con, $query);
        
		//update 
		$new_attendance_count =
    	$query = "UPDATE users SET attendances = $new_attendance_count WHERE user_name = '$user_name'";

        mysqli_query($con, $query);
        echo "attendances++";
      }
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<form method="post">
        <input type="submit" name="submit" value="I am currently attending event">
    </form>
	<a href="logout.php">Logout</a>
	<h1>This is the index page</h1>

	<br>
	Hello, <?php echo $user_data['user_name']; ?>
</body>
</html>