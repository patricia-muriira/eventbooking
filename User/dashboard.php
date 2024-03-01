<?php
// Start session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include database connection
include_once "../Includes/dbconn.php";

// Fetch user's booked events from the database
$userID = $_SESSION["id"]; // Assuming the user ID is stored in session after login

$sql = "SELECT events.id, events.eventname, events.regularticket, events.vipticket
        FROM events
        LEFT JOIN bookings ON events.id = bookings.eventid AND bookings.userid = ?
        WHERE bookings.eventid IS NULL";
$stmt = mysqli_prepare(connectToDatabase(), $sql);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$upcomingEvents = array();
while ($row = mysqli_fetch_assoc($result)) {
    $upcomingEvents[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("images/concert.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(70%);
            /* Adjust the brightness of the background */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: rgba(0, 0, 0, 0.7);
            /* Darken the header */
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            /* Adjust the font size */
        }

        .header a {
            color: #fff;
            text-decoration: none;
        }

        .header a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }

        .content {
            padding: 20px;
            text-align: center;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.7);
            /* Darken the content background */
            flex-grow: 1;
            /* Allow content to grow and push footer to bottom */
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        caption {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .event-list {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
            text-align: left;
        }

        .event-list li {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .event-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Welcome,
            <?php echo $_SESSION["username"]; ?>
        </h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <div class="table-container">
            <table>
                <table>
                    <caption>Booked Events</caption>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch user's booked events from the database
                        $userID = $_SESSION["id"]; // Assuming the user ID is stored in session after login
                        
                        $sql = "SELECT events.eventname, COUNT(bookings.id) AS tickets
                    FROM events
                    INNER JOIN bookings ON events.id = bookings.eventid
                    WHERE bookings.userid = ?
                    GROUP BY events.eventname";
                        $stmt = mysqli_prepare(connectToDatabase(), $sql);
                        mysqli_stmt_bind_param($stmt, "i", $userID);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['eventname'] . "</td>";
                            echo "<td>" . $row['tickets'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
        </div>
        <h2>Upcoming Events</h2>
        <ul class="event-list">
            <?php foreach ($upcomingEvents as $event): ?>
                <li>
                    <div class="event-name">
                        <?php echo $event['eventname']; ?>
                    </div>
                    <div>VIP Price: $
                        <?php echo $event['vipticket']; ?>
                    </div>
                    <div>Regular Price: $
                        <?php echo $event['regularticket']; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>