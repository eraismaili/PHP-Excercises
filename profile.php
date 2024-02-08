<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// Dummy error variables, you can define them if needed
$nameErr = $lastnameErr = $addressErr = $cityErr = $numberErr = $birthdateErr = $emailErr = $passwordErr = "";
$updateMessage = "";

// Handling form submission here, if needed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last Name is required";
    }
    if (empty($_POST["address"])) {
        $nameErr = "Address is required";
    }

    if (empty($_POST["city"])) {
        $lastnameErr = "City is required";
    }
    if (empty($_POST["number"])) {
        $nameErr = "Number is required";
    }

    if (empty($_POST["birthdate"])) {
        $lastnameErr = "Birthdate is required";
    }
    if (empty($_POST["email"])) {
        $nameErr = "Email is required";
    }

    if (empty($_POST["password"])) {
        $lastnameErr = "Password is required";
    }
    if (empty($nameErr) && empty($lastnameErr) && empty($addressErr) && empty($cityErr) && empty($numberErr) && empty($birthdateErr) && empty($emailErr) && empty($passwordErr)) {
        // Your update logic here

        // After successful update, set success message
        $updateMessage = "Profile updated successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title>User Profile</title>
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
    </style>
</head>
<body>

<div class="container">
        <h2>User Profile</h2>
    
        
        <form action="update_profile.php" method="post" autocomplete="off">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" value="<?php echo $_SESSION["id"] ?>" readonly>
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $_SESSION["name"] ?>">
            
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $_SESSION["lastname"] ?>">
            
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo $_SESSION["address"] ?>">
            
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo $_SESSION["city"] ?>">
            
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" value="<?php echo $_SESSION["number"] ?>">
            
            <label for="birthdate">Birth Date:</label>
            <input type="text" name="birthdate" id="birthdate" value="<?php echo $_SESSION["birthdate"] ?>">
            
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo $_SESSION["email"] ?>">
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="">
            
            
            <!-- Add a confirm password field if needed -->
            
            <button type="submit">Update Profile</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#birthdate").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0,
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
</body>
</html>
