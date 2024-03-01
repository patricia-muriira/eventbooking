<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ticketize</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: rgba(0, 0, 0, 0.7);
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

        .header div a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }

        .footer {
            background-color: rgba(0, 0, 0, 0.7);
            /* Darken the footer */
            color: #fff;
            text-align: center;
            padding: 20px;
            width: 100%;
            margin-top: auto;
            /* Push the footer to the bottom */
        }

        .content {
            padding: 20px;
            text-align: center;
            color: #fff;
            background-color: rgba(0,
                    0,
                    0,
                    0.7);
            /* Darken the content background */
            flex-grow: 1;
            /* Allow content to grow and push footer to bottom */
        }

        .content h2 {
            font-size: 32px;
            /* Adjust the font size */
            font-weight: bold;
            /* Make the text bold */
            margin: 10px 0;
            /* Add margin top and bottom */
        }

        .content p {
            font-size: 18px;
            /* Adjust the font size */
            margin-bottom: 30px;
            /* Increase bottom margin */
        }

        .header div {
            display: flex;
            align-items: center;
        }

        .header div a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }

        .header div a img {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Ticketize</h1>
        <div>
            <a href="User/login.php">User Login</a>
            <a href="Admin/login.php">Admin Login</a>
        </div>
    </div>
    <div class="content">
        <h2>Event Registration Made Easy</h2>
        <p>
            Welcome to Ticketize, where event registration is a breeze. Join us now!
        </p>
    </div>
    <div class="footer">
        &copy;
        <?php echo date("Y"); ?>
        Ticketize by Patricia. 2024 All rights reserved.
    </div>
</body>

</html>