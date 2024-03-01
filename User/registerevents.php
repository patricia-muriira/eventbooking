<?php
// Include the database connection file
include_once "../Includes/dbconn.php";

// Fetch events from the database
function fetchEvents($conn)
{
    // Query to select all rows from the 'events' table
    $sql = "SELECT id, eventname, category, date, time, duration, regularticket, vipticket FROM events";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table class='event-table'>";
        echo "<tr><th>Event Name</th><th>Category</th><th>Date</th><th>Time</th><th>Duration</th><th>Regular Ticket Price</th><th>VIP Ticket Price</th><th>Remaining Tickets</th><th>Action</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Calculate remaining tickets
            $remainingTickets = 5; // Assuming maximum 5 tickets per event

            // Output table rows
            echo "<tr>";
            echo "<td>" . $row["eventname"] . "</td>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["duration"] . "</td>";
            echo "<td>$" . $row["regularticket"] . "</td>";
            echo "<td>$" . $row["vipticket"] . "</td>";
            echo "<td>" . $remainingTickets . "</td>";
            echo "<td><form method='post'><input type='hidden' name='event_id' value='" . $row["id"] . "'><input type='submit' name='reserve' value='Get Tickets'></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No events found.";
    }
}

// Reserve tickets
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "Please log in to reserve tickets.";
    } else {
        // Get event ID
        $event_id = $_POST['event_id'];

        // Fetch user's email from the database
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT email FROM users WHERE id = ?";
        $stmt = mysqli_prepare(connectToDatabase(), $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Send email confirmation
        $to = $email;
        $subject = 'Ticket Reservation Confirmation';
        $message = "Dear customer,\n\nCongratulations! You have successfully reserved tickets for the event.\n\nEvent Details:\nEvent ID: $event_id\nEvent Name: $event_name\nCategory: $event_category\nDate: $event_date\nTime: $event_time\nDuration: $event_duration\nRegular Ticket Price: $event_regularticket\nVIP Ticket Price: $event_vipticket";
        $headers = 'From: mpatriciamwende@gmail.com';

        // Send email
        mail($to, $subject, $message, $headers);

        echo "Tickets reserved successfully. Check your email for confirmation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .event-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .event-table th,
        .event-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .event-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .event-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .event-table tr:hover {
            background-color: #f2f2f2;
        }

        form {
            display: inline;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <h2>Upcoming Events</h2>
    <?php
    // Include the database connection file
    include '../Includes/dbconn.php';

    // Function to fetch and display events
    fetchEvents($conn);
    ?>
</body>

</html>