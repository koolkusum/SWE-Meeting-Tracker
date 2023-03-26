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
    <style type="text/css">
        body {
            font-family: Calibri, sans-serif;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
        }

        th {
            background-color: #c1c1c1;
        }

        td:first-child {
            text-align: center;
        }

        td:last-child {
            font-weight: bold;
        }
    </style>
</head>

<body>

    body {
    font-family: Calibri, sans-serif;
    }

    form {
    margin-bottom: 20px;
    }

    table {
    border-collapse: collapse;
    margin-top: 20px;
    }

    th, td {
    border: 1px solid black;
    padding: 10px;
    }

    th {
    background-color: #c1c1c1;
    }

    td:first-child {
    text-align: center;
    }

    td:last-child {
    font-weight: bold;
    }
    <a href="logout.php">Logout</a>
    <h1>Admin Controls</h1>
    <form method="post">
        <input type="submit" name="startEvent" value="Start Event">
    </form>
    <form method="post">
        <input type="submit" name="endEvent" value="End Event">
    </form>
    <br>
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
        <caption>Member Attendance</caption>
        <thead>
            <tr>
                <th>Member Name</th>
                <th>NetID</th>
                <th>General Meetings</th>
                <th>Board Meetings</th>
                <th>Major</th>
                <th>Grad Year</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM users";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $memberName = $row['first_name'] . ' ' . $row['last_name'];
                $memberNetID = $row['user_name'];
                $attendanceCount = $row['attendances'];
                $boardAttendanceCount = $row['board_meeting'];
                $major = $row['major'];
                $gradYear = $row['graduation_year'];
                echo "<tr>
              <td>$memberName</td>
              <td>$memberNetID</td>
              <td>$attendanceCount</td>
              <td>$boardAttendanceCount</td>
              <td>$major</td>
              <td>$gradYear</td>
            </tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>