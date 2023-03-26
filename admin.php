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
if (isset($_POST['removeMember'])) {
    $targetNetID = $_POST['netID'];
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

    <br>
    Hello,
    <?php echo $user_data['user_name']; ?>

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

                $query = "SELECT graduation_year FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $gradYear = mysqli_fetch_assoc($result)['graduation_year'];

                $query = "SELECT major FROM users LIMIT $i, 1";
                $result = mysqli_query($con, $query);
                $major = mysqli_fetch_assoc($result)['major'];

                $form = "post";
                $submit = "submit";
                $buttonName = "removeMember";
                $value = "Delete $memberNetID";

                echo "<p>$memberName<br>NetID: $memberNetID<br>Attendance Count: $attendanceCount<br>Major: $major<br>Graduation Year: $gradYear</p>";
                echo "<form method='$form'>";
                echo "<button type='$submit' name='$buttonName' value='$memberNetID'>$value</button>";
                echo "</form>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>