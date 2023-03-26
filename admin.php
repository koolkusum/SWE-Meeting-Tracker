<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_POST['startEvent'])) {
    $query = "UPDATE users SET attended_current_event = 0 WHERE attended_current_event != 0";
    mysqli_query($con, $query);
}
if (isset($_POST['endEvent'])) {
    $query = "UPDATE users SET attended_current_event = 1 WHERE attended_current_event != 1";
    mysqli_query($con, $query);
}
if (isset($_POST['startEventBoard'])) {
    $query = "UPDATE users SET attended_current_event = 2 WHERE attended_current_event != 2";
    mysqli_query($con, $query);
}
if (isset($_POST['endEventBoard'])) {
    $query = "UPDATE users SET attended_current_event = 1 WHERE attended_current_event != 1";
    mysqli_query($con, $query);
}
if (isset($_POST['deleteMember'])) {
    $targetNetID = $_POST['deleteMember'];
    $query = "DELETE FROM users WHERE user_name = '$targetNetID'";
    mysqli_query($con, $query);

    //refresh page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
        <input type="submit" name="startEvent" value="Start Event">
    </form>
    <form method="post">
        <input type="submit" name="endEvent" value="End Event">
    </form>
    <form method="post">
        <input type="submit" name="startEventBoard" value="Start Board Event">
    </form>
    <form method="post">
        <input type="submit" name="endEventBoard" value="End Board Event">
    </form>

    <br>
    Hello,
    <?php echo $user_data['user_name']; ?>

    <h1>Delete From Database</h1>
    <form method="post">
        <label for="netID">Delete NetID from database here:</label>
        <input type="text" name="netID" id="netID">
        <input type="submit" name="submit" value="Execute">
    </form>

    <?php
    if (isset($_POST['submit'])) {

        $targetNetID = $_POST['netID'];
        $query = "DELETE FROM users WHERE user_name = '$targetNetID'";
        mysqli_query($con, $query);

        //refresh page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    ?>

    <form method="post">
        <label>Enter NetID to change meeting count:</label>
        <input type="text" name="textInput">
        <br><br>
        <label>Change general meetings by:</label>
        <input type="number" name="integerInput1">
        <br><br>
        <label>Change board meetings by:</label>
        <input type="number" name="integerInput2">
        <br><br>
        <input type="submit" name="execute" value="Execute">
    </form>

    <?php
    if (isset($_POST['execute'])) {
        $textInput = $_POST['textInput'];
        $integerInput1 = $_POST['integerInput1'];
        $integerInput2 = $_POST['integerInput2'];
        
		//update 
    	$query1 = "UPDATE users SET attendances = (attendances + $integerInput1) WHERE user_name = '$textInput'";
    	$query1 = "UPDATE users SET board_meeting = (board_meeting + $integerInput2) WHERE user_name = '$textInput'";

        mysqli_query($con, $query1);
        // Put your code here that will execute with the given inputs
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Attendance Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT COUNT(*) as num_users FROM users";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $memberCount = $row['num_users'];

            for ($i = 0; $i < $memberCount; $i++) {

                // Combine first and last name
                $query = "SELECT first_name FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $firstName = mysqli_fetch_assoc($result)['first_name'];
                $query = "SELECT last_name FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $lastName = mysqli_fetch_assoc($result)['last_name'];
                $memberName = "$firstName $lastName";

                // NetID, attendance count, major, grad year
                $query = "SELECT user_name FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $memberNetID = mysqli_fetch_assoc($result)['user_name'];

                $query = "SELECT attendances FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $attendanceCount = mysqli_fetch_assoc($result)['attendances'];

                $query = "SELECT board_meeting FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $boardAttendanceCount = mysqli_fetch_assoc($result)['board_meeting'];

                $query = "SELECT graduation_year FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $gradYear = mysqli_fetch_assoc($result)['graduation_year'];

                $query = "SELECT major FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $major = mysqli_fetch_assoc($result)['major'];

                echo "<p> $memberName\n NetID: $memberNetID\n general meetings: $attendanceCount\n board meetings: $boardAttendanceCount\n Major: $major\n grad year: $gradYear\n attendances: $attendanceCount\n\n</p>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>