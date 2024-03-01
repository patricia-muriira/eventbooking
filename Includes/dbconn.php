<?php
// Database connection variables
$db_host = "qn66usrj1lwdk1cc.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$db_username = "a52gc9o9mb32hf10";
$db_password = "kj6jhdvpuda8mxa0";
$db_name = "iwanv5dsy059vl6m";

//JAWSDB HEROKU URL - mysql://a52gc9o9mb32hf10:kj6jhdvpuda8mxa0@qn66usrj1lwdk1cc.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/iwanv5dsy059vl6m
// Function to establish a database connection
function connectToDatabase()
{
    global $db_host, $db_username, $db_password, $db_name;

    $connection = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Return the connection object
    return $connection;
}
?>