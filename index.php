<?php 
session_start();

include("connection.php");
include("functions.php");
// include("sessionInfo.php"); // not provided, assumed to contain non-critical session info

$user_data = check_login($con);
$namet = $user_data['user_name'];
$queryat= "SELECT attended_current_event FROM users WHERE user_name='$namet'";
$resultat=mysqli_query($con, $queryat);
$rowat=mysqli_fetch_assoc($resultat);
$numcurr=intval($rowat['attended_current_event']);
//echo $numcurr;

if ($numcurr == 0 && isset($_POST['submit'])) {
    $asdf = $user_data['user_name'];
    $query = "SELECT attendances FROM users WHERE user_name = '$asdf'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $new_num_of_attendances = intval($row['attendances']);
    $new_num_of_attendances++;

    $query1 = "UPDATE users SET attendances = (attendances + 1) WHERE user_name = '$asdf'";
    mysqli_query($con, $query1);
    $query3= "UPDATE users SET attended_current_event = 1 WHERE user_name = '$asdf'";
    mysqli_query($con, $query3);
}

if ($numcurr==2 && isset($_POST['submit']))
{
    $asdf = $user_data['user_name'];
    $query = "SELECT board_meeting FROM users WHERE user_name = '$asdf'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $new_num_of_attendances = intval($row['board_meeting']);
    $new_num_of_attendances++;

    $query1 = "UPDATE users SET board_meeting = (board_meeting + 1) WHERE user_name = '$asdf'";
    mysqli_query($con, $query1);
    $query3= "UPDATE users SET attended_current_event = 1 WHERE user_name = '$asdf'";
    mysqli_query($con, $query3);

}
if ($numcurr==1 && isset($_POST['submit']))
{
    echo '<script>alert("You have already signed in!");</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            margin: 0;
            padding: 0;
        }

        #header {
            font-family: Calibri, sans-serif;
            background-color: #5A5377;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        #content {
            font-family: Calibri, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
        }

        form {
            margin-bottom: 20px;
        }

        input[type=submit] {
            background-color: #5A5377;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #47425c;
        }
        #logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
		    color: white;
		    background-color: #4CAF50;
		    border: none;
		    border-radius: 5px;
		    cursor: pointer;}
    </style>
</head>
<body>

	<div id="header">
        <h1>Welcome <?php echo $user_data['user_name'];?></h1>
        <a href="logout.php" id="logout-btn">Logout</a>
    </div>

	<div id="content">
        <form method="post">
            <input type="submit" name="submit" value="Check In to Event">
        </form>

        <p>You have attended <?php 
            $asdf = $user_data['user_name'];
            $query = "SELECT attendances FROM users WHERE user_name = '$asdf'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $new_num_of_attendances = intval($row['attendances']);
            echo $new_num_of_attendances;
        ?> general meetings</p>
            
            <p>You have attended <?php 
            $asdf = $user_data['user_name'];
            $query = "SELECT board_meeting FROM users WHERE user_name = '$asdf'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $new_num_of_board = intval($row['board_meeting']);
            echo $new_num_of_board;
        ?> board meetings</p>
    </div>
</body>
</html>