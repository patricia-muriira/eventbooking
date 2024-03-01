<?php
// Include the database connection file
include_once "../Includes/dbconn.php";

// Initialize variables
$eventname = $category = $date = $time = $duration = $location = $capacity = $regularticket = $vipticket = "";
$eventname_err = $category_err = $date_err = $time_err = $duration_err = $location_err = $capacity_err = $regularticket_err = $vipticket_err = "";

// Check if event ID is provided
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Prepare a select statement
    $sql = "SELECT * FROM events WHERE id = ?";

    if ($stmt = mysqli_prepare(connectToDatabase(), $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameter
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array.  */
                $row = mysqli_fetch_assoc($result);

                // Retrieve individual field values
                $eventname = $row["eventname"];
                $category = $row["category"];
                $date = $row["date"];
                $time = $row["time"];
                $duration = $row["duration"];
                $location = $row["location"];
                $capacity = $row["capacity"];
                $regularticket = $row["regularticket"];
                $vipticket = $row["vipticket"];
            } else {
                // Event ID doesn't exist
                header("location: error.php");
                exit();
            }

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close(connectToDatabase());
} else {
    // Event ID not provided, redirect to error page
    header("location: error.php");
    exit();
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate event name
    if (empty(trim($_POST["eventname"]))) {
        $eventname_err = "Please enter the event name.";
    } else {
        $eventname = trim($_POST["eventname"]);
    }

    // Validate category
    if (empty(trim($_POST["category"]))) {
        $category_err = "Please enter the category.";
    } else {
        $category = trim($_POST["category"]);
    }

    // Validate other fields similarly

    // Check if all fields are validated successfully
    if (empty($eventname_err) && empty($category_err) && empty($date_err) && empty($time_err) && empty($duration_err) && empty($location_err) && empty($capacity_err) && empty($regularticket_err) && empty($vipticket_err)) {
        // Prepare an update statement
        $sql = "UPDATE events SET eventname=?, category=?, date=?, time=?, duration=?, location=?, capacity=?, regularticket=?, vipticket=? WHERE id=?";

        if ($stmt = mysqli_prepare(connectToDatabase(), $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssssi", $param_eventname, $param_category, $param_date, $param_time, $param_duration, $param_location, $param_capacity, $param_regularticket, $param_vipticket, $param_id);

            // Set parameters
            $param_eventname = $eventname;
            $param_category = $category;
            $param_date = $date;
            $param_time = $time;
            $param_duration = $duration;
            $param_location = $location;
            $param_capacity = $capacity;
            $param_regularticket = $regularticket;
            $param_vipticket = $vipticket;
            $param_id = $row["id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to admin dashboard
                header("location: admin_dashboard.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close(connectToDatabase());
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f5f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #3498db;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"] {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"],
        input[type="button"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Event</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Event Name</label>
                <input type="text" name="eventname" value="<?php echo $eventname; ?>">
                <div class="error">
                    <?php echo $eventname_err; ?>
                </div>
            </div>
            <div>
                <label>Category</label>
                <input type="text" name="category" value="<?php echo $category; ?>">
                <div class="error">
                    <?php echo $category_err; ?>
                </div>
            </div>
            <div>
                <label>Date</label>
                <input type="date" name="date" value="<?php echo $date; ?>">
                <div class="error">
                    <?php echo $date_err; ?>
                </div>
            </div>
            <div>
                <label>Time</label>
                <input type="time" name="time" value="<?php echo $time; ?>">
                <div class="error">
                    <?php echo $time_err; ?>
                </div>
            </div>
            <div>
                <label>Duration</label>
                <input type="text" name="duration" value="<?php echo $duration; ?>">
                <div class="error">
                    <?php echo $duration_err; ?>
                </div>
            </div>
            <div>
                <label>Location</label>
                <input type="text" name="location" value="<?php echo $location; ?>">
                <div class="error">
                    <?php echo $location_err; ?>
                </div>
            </div>
            <div>
                <label>Capacity</label>
                <input type="number" name="capacity" value="<?php echo $capacity; ?>">
                <div class="error">
                    <?php echo $capacity_err; ?>
                </div>
            </div>
            <div>
                <label>Regular Ticket Price</label>
                <input type="number" name="regularticket" value="<?php echo $regularticket; ?>">
                <div class="error">
                    <?php echo $regularticket_err; ?>
                </div>
            </div>
            <div>
                <label>VIP Ticket Price</label>
                <input type="number" name="vipticket" value="<?php echo $vipticket; ?>">
                <div class="error">
                    <?php echo $vipticket_err; ?>
                </div>
            </div>
            <div>
                <input type="submit" value="Save Changes">
                <input type="button" value="Cancel" onclick="window.location.href='admin_dashboard.php';">
            </div>
        </form>
    </div>
</body>

</html>