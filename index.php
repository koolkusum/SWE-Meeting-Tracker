<?php 
session_start();

	include("connection.php");
	include("functions.php");
	include("sessionInfo.php");


	$user_data = check_login($con);

    if(isset($_POST['submit'])) {

        $asdf = $user_data['user_name'];

    	$query = "SELECT attendances FROM users WHERE user_name = '$asdf'";
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($result);
		$new_num_of_attendances = intval($row['attendances']);
        $new_num_of_attendances++;
        
        echo $new_num_of_attendances;
        echo $user_netID;
        
		//update 
    	$query1 = "UPDATE users SET attendances = (attendances + 1) WHERE user_name = '$asdf'";

        mysqli_query($con, $query1);
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