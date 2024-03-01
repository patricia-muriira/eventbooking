<?php
// Include the database connection file
include_once "../Includes/dbconn.php";

// Check if the booking ID is set and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Get the booking ID from the URL parameter
    $booking_id = $_GET['id'];

    // Function to fetch booking details by ID
    function getBookingDetails($conn, $booking_id)
    {
        $sql = "SELECT * FROM bookings WHERE id = $booking_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    // Get booking details
    $booking = getBookingDetails(connectToDatabase(), $booking_id);

    // If booking exists, display confirmation page
    if ($booking) {
        // If the form is submitted
        if (isset($_POST['confirm_delete'])) {
            // If 'Yes' is clicked, delete the booking record
            $sql = "DELETE FROM bookings WHERE id = $booking_id";
            if (mysqli_query(connectToDatabase(), $sql)) {
                // Booking deleted successfully, redirect to dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "Error deleting booking: " . mysqli_error(connectToDatabase());
            }
        }

        // If 'No' is clicked, redirect to dashboard
        if (isset($_POST['cancel'])) {
            header("Location: Admin/dashboard.php");
            exit();
        }
    } else {
        echo "Booking not found.";
        exit();
    }
} else {
    echo "Invalid booking ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-red {
            background-color: #e74c3c;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Delete Booking</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>User ID</th>
                <th>Event ID</th>
            </tr>
            <tr>
                <td>
                    <?php echo $booking['id']; ?>
                </td>
                <td>
                    <?php echo $booking['username']; ?>
                </td>
                <td>
                    <?php echo $booking['userid']; ?>
                </td>
                <td>
                    <?php echo $booking['eventid']; ?>
                </td>
            </tr>
        </table>
        <div class="btn-container">
            <form method="post">
                <button class="btn" type="submit" name="confirm_delete">Yes</button>
                <button class="btn btn-red" type="submit" name="cancel">No</button>
            </form>
        </div>
    </div>
</body>

</html>