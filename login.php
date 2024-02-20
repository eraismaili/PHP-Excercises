<?php
require 'config.php';


function loginUser($conn, $email, $password) {
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["lastname"] = $row["lastname"];
            $_SESSION["address"] = $row["address"];
            $_SESSION["city"] = $row["city"];
            $_SESSION["number"] = $row["number"];
            $_SESSION["birthdate"] = $row["birthdate"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["role"] = $row["role"];

    // Redirect based on role
       if ($row["role"] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: profile.php");
    }
    exit();
    }else {
    return "Wrong Password";
    }
    }else {
    return "User Not Registered";
    }
}

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $loginResult = loginUser($conn, $email, $password);

    if ($loginResult) {
        echo "<script>alert('$loginResult');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .registration-link {
            text-align: center;
            margin-top: 10px;
        }
        .registration-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="" method="post" autocomplete="on">
            <label for="email">Name or Email:</label>
            <input type="text" name="email" id="email" required value="">
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required value="">
            
            <button type="submit" name="submit">Login</button>
        </form>
        
        <div class="registration-link">
            <a href="registration.php">Registration</a>
        </div>
    </div>
</body>
</html>
