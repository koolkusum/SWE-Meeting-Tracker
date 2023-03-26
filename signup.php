<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Something was posted
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $ruid = $_POST['ruid'];
        $email = $_POST['email'];
        $graduation_year = $_POST['graduation_year'];
        $major = $_POST['major'];
        $academic_status = $_POST['academic_status'];
    
        if (!empty($user_name) && !empty($password) && !is_numeric($user_name) && !empty($first_name) && !empty($graduation_year) && !empty($major) && !empty($last_name) && !empty($email) && !empty($ruid) && !empty($academic_status)) {
    
            $check_query = "SELECT user_id FROM users WHERE user_name='$user_name' OR ruid='$ruid' LIMIT 1";
            $result = mysqli_query($con, $check_query);
            $user = mysqli_fetch_assoc($result);
    
            if ($user) {
                // NetID or RUID already exists
                echo "NetID or RUID already exists, please choose a different one.";
            } else {
                // Save to database
                $user_id = random_num(20);
                $query = "INSERT INTO users (user_id,user_name,password,first_name,last_name,ruid,email,graduation_year,major,academic_status) 
                VALUES ('$user_id','$user_name','$password','$first_name','$last_name','$ruid','$email','$graduation_year','$major','$academic_status')";
    
                mysqli_query($con, $query);
    
                header("Location: login.php");
                die;
            }
        } else {
            echo "Please enter valid information for all fields!";
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<style type="text/css">
		body {
            font-family: Calibri, sans-serif;
			background-color: #f1f1f1;
		}
        #header {
            background-color: #5A5377;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

		form {
			background-color: #fff;
			padding: 20px;
			max-width: 500px;
			margin: 50px auto;
			border-radius: 5px;
			box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
		}
		form h2 {
			font-size: 30px;
			font-weight: 600;
			margin-top: 0px;
			margin-bottom: 20px;
			color: #333;
		}
		form label {
			font-size: 18px;
			display: block;
			margin-bottom: 5px;
			color: #333;
		}
		form input[type="text"], form input[type="password"], form input[type="number"] {
			height: 40px;
			border-radius: 5px;
			padding: 0px 10px;
			border: none;
			width: 100%;
			font-size: 16px;
			margin-bottom: 20px;
			box-sizing: border-box;
			border: solid thin #aaa;
		}
		form input[type="submit"] {
			background-color: #1877f2;
			color: #fff;
			border: none;
			padding: 10px 20px;
			font-size: 18px;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.2s ease-in-out;
		}
		form input[type="submit"]:hover {
			background-color: #166fe5;
		}
		form a {
			color: #333;
			text-decoration: none;
			font-size: 16px;
		}
		form a:hover {
			color: #1877f2;
		}
	</style>
</head>
<body>
<div id="header">
        <h1>SWS Meeting Sign In</h1>
    </div>
	<form method="post">
		<h2>Sign up</h2>

		<label> First Name</label>
		<input type="text" name="first_name">

		<label>Last Name</label>
		<input type="text" name="last_name">

		<label>RUID</label>
		<input type="number" name="ruid">

		<label>Email</label>
		<input type="text" name="email">

		<label>Major</label>
		<input type="text" name="major">

		<label>Graduation Year</label>
		<input type="number" name="graduation_year">
        
        <label>Academic Status</label>
		<select name="academic_status">
			<option value="undergrad">Undergraduate</option>
			<option value="grad">Graduate</option>
		</select>

		<label>NetID</label>
		<input type="text" name="user_name">

		<label>Password</label>
		<input type="password" name="password">

		<input type="submit" value="Sign up">

		<div style="margin-top: 20px;">
			Already have an account? <a href="login.php">Click to Login</a>
		</div>
	</form>

</body>
</html>
