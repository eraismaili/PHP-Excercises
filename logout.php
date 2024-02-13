<!--!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }
        .redirect {
            text-align: center;
            margin-top: 20px;
        }
        .redirect a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logging out...</h2>
        <div class="message">
        </div>
        <div class="redirect">
            <p>If you're not redirected, <a href="login.php">click here</a> to log in again.</p>
        </div>
    </div>
</body>
</html>
