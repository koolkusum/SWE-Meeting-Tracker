<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (isset($_POST['startEvent'])) {
    $query = "UPDATE users SET attended_current_event = 0 WHERE attended_current_event != 0";
    mysqli_query($con, $query);
    echo '<script>alert("General event started");</script>';
}
if (isset($_POST['endEvent'])) {
    $query = "UPDATE users SET attended_current_event = 1 WHERE attended_current_event = 0";
    mysqli_query($con, $query);
    echo '<script>alert("General event ended");</script>';
}
if (isset($_POST['startEventBoard'])) {
    $query = "UPDATE users SET attended_current_event = 2 WHERE attended_current_event != 2";
    mysqli_query($con, $query);
    echo '<script>alert("Board event started");</script>';
}
if (isset($_POST['endEventBoard'])) {
    $query = "UPDATE users SET attended_current_event = 1 WHERE attended_current_event = 2";
    mysqli_query($con, $query);
    echo '<script>alert("Board event ended");</script>';
}

//this method might be useless but I forgot so sorry about that lol
if (isset($_POST['deleteMember'])) {
    $targetNetID = $_POST['deleteMember'];
    $query = "DELETE FROM users WHERE user_name = '$targetNetID'";
    $userFoundAndDeleted = mysqli_query($con, $query);

    if ($userFoundAndDeleted) {
        echo '<script>alert("User deleted from database");</script>';
    } else {
        echo '<script>alert("User not found in database");</script>';
    }
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
            font-size: 20px;
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

        #logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #header {
            font-family: Calibri, sans-serif;
            background-color: #5A5377;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .green-btn {
            display: inline-block;
            padding: 20px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .red-btn {
            display: inline-block;
            padding: 20px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }
        h1 {
    font-size: 24px;
    margin-top: 30px;
  }

  form {
    margin-bottom: 30px;
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"],
  input[type="number"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    width: 10%;
    margin-bottom: 20px;
  }

  button[type="submit"] {
    background-color: #ccc;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }

  button[type="submit"]:hover {
    background-color: #555;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .success-msg {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 5px;
    margin-top: 20px;
  }

  .error-msg {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 5px;
    margin-top: 20px;
  }
    </style>
</head>

<body>
    <div id="header">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" id="logout-btn">Logout</a>
    </div>
    <a href="logout.php" id="logout-btn">Logout</a>
    <h1>Event Controls</h1>
    <form method="post">
        <input type="submit" name="startEvent" value="Start General Meeting" class="green-btn">
        <input type="submit" name="endEvent" value="End General Meeting" class="red-btn">
    </form>

    <form method="post">
        <input type="submit" name="startEventBoard" value="Start Board Meeting" class="green-btn">
        <input type="submit" name="endEventBoard" value="End Board Meeting" class="red-btn">
    </form>

    <br>

    <h1>Delete User From Database</h1>
<form method="post">
  <label for="netID">Enter NetID:</label>
  <input type="text" name="netID" id="netID">
  <button type="submit" name="submit">Delete User</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $targetNetID = $_POST['netID'];
    $query = "DELETE FROM users WHERE user_name = '$targetNetID'";
    $userFoundAndDeleted = mysqli_query($con, $query);
    if (!$userFoundAndDeleted) {
        echo '<div class="error-msg">User not found in database</div>';
    } else {
        echo '<div class="success-msg">User deleted from database</div>';
    }
    // Refresh page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<h1>Change Database</h1>
<form method="post">
  <div class="form-group">
    <label for="textInput">Enter NetID:</label>
    <input type="text" name="textInput" id="textInput">
  </div>
  <div class="form-group">
    <label for="integerInput1">Change general meetings by:</label>
    <input type="number" name="integerInput1" id="integerInput1">
  </div>
  <div class="form-group">
    <label for="integerInput2">Change board meetings by:</label>
    <input type="number" name="integerInput2" id="integerInput2">
  </div>
  <button type="submit" name="execute">Execute</button>
</form>
    <?php
    if (isset($_POST['execute'])) {
        $textInput = $_POST['textInput'];
        $integerInput1 = $_POST['integerInput1'];
        $integerInput2 = $_POST['integerInput2'];
        //update 
        $query1 = "UPDATE users SET attendances = (attendances + $integerInput1) WHERE user_name = '$textInput'";
        $query2 = "UPDATE users SET board_meeting = (board_meeting + $integerInput2) WHERE user_name = '$textInput'";
        mysqli_query($con, $query1);
        mysqli_query($con, $query2);
    }
    ?>
    <table>
        <h1>Member Attendance</h1>
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