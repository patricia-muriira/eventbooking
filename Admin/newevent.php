<?php
// Include the database connection file
include_once "../Includes/dbconn.php";

// Define variables and initialize with empty values
$eventname = $category = $date = $time = $duration = $location = $capacity = $regularticket = $vipticket = "";
$eventname_err = $category_err = $date_err = $time_err = $duration_err = $location_err = $capacity_err = $regularticket_err = $vipticket_err = "";

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

    // Validate date
    if (empty(trim($_POST["date"]))) {
        $date_err = "Please enter the date.";
    } else {
        $date = trim($_POST["date"]);
    }

    // Validate time
    if (empty(trim($_POST["time"]))) {
        $time_err = "Please enter the time.";
    } else {
        $time = trim($_POST["time"]);
    }

    // Validate duration
    if (empty(trim($_POST["duration"]))) {
        $duration_err = "Please enter the duration.";
    } else {
        $duration = trim($_POST["duration"]);
    }

    // Validate location
    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter the location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate capacity
    if (empty(trim($_POST["capacity"]))) {
        $capacity_err = "Please enter the capacity.";
    } else {
        $capacity = trim($_POST["capacity"]);
    }

    // Validate regular ticket price
    if (empty(trim($_POST["regularticket"]))) {
        $regularticket_err = "Please enter the regular ticket price.";
    } else {
        $regularticket = trim($_POST["regularticket"]);
    }

    // Validate VIP ticket price
    if (empty(trim($_POST["vipticket"]))) {
        $vipticket_err = "Please enter the VIP ticket price.";
    } else {
        $vipticket = trim($_POST["vipticket"]);
    }

    // Check input errors before inserting into database
    if (empty($eventname_err) && empty($category_err) && empty($date_err) && empty($time_err) && empty($duration_err) && empty($location_err) && empty($capacity_err) && empty($regularticket_err) && empty($vipticket_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO events (eventname, category, date, time, duration, location, capacity, regularticket, vipticket) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare(connectToDatabase(), $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_eventname, $param_category, $param_date, $param_time, $param_duration, $param_location, $param_capacity, $param_regularticket, $param_vipticket);

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

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to dashboard
                header("location: admin_dashboard.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
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
    <title>Add Event</title>
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
        input[type="reset"] {
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
        input[type="reset"]:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Event</h2>
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
                <input type="number" name="regularticket" step="0.01" value="<?php echo $regularticket; ?>">
                <div class="error">
                    <?php echo $regularticket_err; ?>
                </div>
            </div>
            <div>
                <label>VIP Ticket Price</label>
                <input type="number" name="vipticket" step="0.01" value="<?php echo $vipticket; ?>">
                <div class="error">
                    <?php echo $vipticket_err; ?>
                </div>
            </div>
            <div>
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
        </form>
    </div>
</body>

</html>