<?php
// Include the database connection file
require_once "../Includes/dbconn.php";

$conn = connectToDatabase();

// Function to fetch total events from the database
function getTotalEvents()
{
    $connection = connectToDatabase();
    $sql = "SELECT COUNT(*) as total_events FROM events";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalEvents = $row['total_events'];
    mysqli_close($connection);
    return $totalEvents;
}

// Function to fetch total bookings from the database
function getTotalBookings()
{
    $connection = connectToDatabase();
    $sql = "SELECT COUNT(*) as total_bookings FROM bookings";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalBookings = $row['total_bookings'];
    mysqli_close($connection);
    return $totalBookings;
}
function displayEvents($conn)
{
    // Query to select all rows from the 'events' table
    $sql = "SELECT * FROM events";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<p>";
            echo "Event Name: " . $row["eventname"] . "<br>";
            echo "Category: " . $row["category"] . "<br>";
            echo "Date: " . $row["date"] . "<br>";
            echo "Time: " . $row["time"] . "<br>";
            echo "Duration: " . $row["duration"] . "<br>";
            echo "Location: " . $row["location"] . "<br>";
            echo "Capacity: " . $row["capacity"] . "<br>";
            echo "Regular Ticket Price: $" . $row["regularticket"] . "<br>";
            echo "VIP Ticket Price: $" . $row["vipticket"] . "<br>";
            echo "<div class='button-row'>";
            echo "<a href='edit_event.php?id=" . $row["id"] . "' class='edit-button'>Edit</a>";
            echo "<a href='remove_event.php?id=" . $row["id"] . "' class='remove-button'>Remove</a>";
            echo "</div>";
            echo "</p>";
        }
    } else {
        echo "You have not created any events yet";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .statistics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            background-color: #3498db;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .stat-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            text-align: center;
        }

        .stat-value a {
            color: #fff;
            text-decoration: none;
        }

        .stat-value a:hover {
            text-decoration: underline;
        }

        .manage-links {
            text-align: center;
            margin-top: 20px;
        }

        .manage-links a {
            display: inline-block;
            background-color: #2c3e50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
        }

        .manage-links a:hover {
            background-color: #34495e;
        }

        .edit-button {
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            margin-right: 5px;
        }

        .remove-button {
            background-color: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .header-right span {
            margin-left: 10px;
            cursor: pointer;
        }

        .header-right span:hover {
            text-decoration: underline;
        }

        /* Footer Styles */
        footer {
            background-color: #34495e;
            color: #fff;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-container a {
            color: #fff;
            text-decoration: none;
        }

        .footer-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1>Ticketize</h1>
            </div>
            <div class="header-right">
                <a href="newevent.php" class="new-event">Create New Event</a>
                <span class="admin">Admin</span>
                <span class="logout">Logout</span>
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="statistics">
            <!-- Total Events -->
            <div class="stat-item">
                <div class="stat-title">Total Events</div>
                <div class="stat-value">
                    <?php echo getTotalEvents(); ?>
                </div>


            </div>
            <!-- Total Bookings -->
            <div class="stat-item">
                <div class="stat-title">Total Bookings</div>
                <div class="stat-value">
                    <?php echo getTotalBookings(); ?>
                </div>
            </div>
        </div>
        <h1>Events</h1>
        <?php
        // Include the database connection file
        include_once '../Includes/dbconn.php';

        // Function to fetch and display events
        displayEvents($conn);
        ?>
    </div>
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 Ticketize by Patricia Muriira</p>
        </div>
    </footer>
</body>

</html>