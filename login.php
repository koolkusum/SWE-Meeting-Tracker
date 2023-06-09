<?php 

session_start();

	include("connection.php");
	include("functions.php");
	include("sessionInfo.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);	
					if($user_data['password'] === $password)
					{
						$_SESSION['user_id'] = $user_data['user_id'];
						if($user_name == "admin"){
							header("Location: admin.php");	
							die;
						}
						header("Location: index.php");
						$user_netID = $user_name; 
						die;
					}
				}
			}
			
            echo '<script>alert("wrong username or password!");</script>';
		}else
		{
			echo '<script>alert("wrong username or password!");</script>';
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
	body {
		font-family: Arial, sans-serif;
		background-color: #f2f2f2;
	}
    #header {
            background-color: #5A5377;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

	#box {
		background-color: white;
		border-radius: 5px;
		box-shadow: 0 0 10px rgba(0,0,0,0.2);
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	h1 {
		margin-top: 0;
		text-align: center;
		color: #444;
	}
    h2
    {
        color: #fff;
    }

	input[type="text"],
	input[type="password"] {
		height: 40px;
		border-radius: 5px;
		padding: 10px;
		border: none;
		width: 100%;
		margin-bottom: 10px;
		box-sizing: border-box;
	}

	input[type="submit"] {
		padding: 10px 20px;
		color: white;
		background-color: #4CAF50;
		border: none;
		border-radius: 5px;
		cursor: pointer;
	}

	input[type="submit"]:hover {
		background-color: #3e8e41;
	}

	a {
		color: #777;
		text-decoration: none;
	}

	a:hover {
		color: #000;
	}
	</style>
</head>
<body>

<div id="header">
        <h2>SWE Meeting Sign In</h2>
    </div>
	<div id="box">
		<h1>Login</h1>
		<form method="post">
			<input type="text" name="user_name" placeholder="NetID"><br>
			<input type="password" name="password" placeholder="Password"><br>
			<input type="submit" value="Login"><br>
			<p>Don't have an account? <a href="signup.php">Sign up</a></p>
		</form>
	</div>

</body>
</html>