<?php
require 'config.php';

$nameErr = $lastnameErr = $addressErr = $cityErr = $numberErr = $birthdateErr = $emailErr = $passwordErr = "";
$registrationSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last Name is required";
    } else {
        $lastname = $_POST["lastname"];
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = $_POST["address"];
    }

    if (empty($_POST["city"])) {
        $cityErr = "City is required";
    } else {
        $city = $_POST["city"];
    }

    if (empty($_POST["password"]) || (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{6,}$/', $_POST["password"]))) {
        $passwordErr = "Password must contain at least 6 characters with 1 uppercase letter, 1 lowercase letter, and 1 special character";
    } else {
        $password = $_POST["password"];
    }

    if (empty($_POST["number"])) {
        $numberErr = "Number is required";
    } elseif (!preg_match("/^\+?[0-9]{7,15}$/", $_POST["number"])) {
        $numberErr = "Invalid phone number format"; 
    } else {
        $number = $_POST["number"];
    }
    
    if (empty($_POST["birthdate"])) {
        $birthdateErr = "BirthDate is required";
    } else {
        $birthdate = $_POST["birthdate"];
    }
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        
        // Check if the email is already registered
        $check_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($result) > 0) {
            $emailErr = "This email is already registered.";
        } else {
            $email = $_POST["email"];
        }
    }

        // me i check neser error variables jon empty
    if (empty($nameErr) && empty($lastnameErr) && empty($addressErr) && empty($cityErr) && empty($numberErr) && empty($birthdateErr) && empty($emailErr) && empty($passwordErr)) {

    
    // Check if a file is selected
    if ($_FILES['profilepicture']['name']) {
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profilepicture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Upload file to the server
        if (move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFilePath)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert image file name into database
            $query = "INSERT INTO users (name, lastname, address, city, number, birthdate, email, password, profile_picture) VALUES ('$name', '$lastname', '$address', '$city', '$number', '$birthdate', '$email', '$hashed_password', '$fileName')";

            if (mysqli_query($conn, $query)) {
                $registrationSuccess = true;
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo 'Please select a file.';
    } 
}
else {
    echo "Sorry, there was an error .";
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
        .error {
            color: red;
            font-size: 12px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
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
</head>
<body>
    <div class="container">
        <h2>Registration</h2>

        <?php if ($registrationSuccess): ?>
            <div class="success">You have successfully registered</div>
        <?php endif; ?>
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo isset($name) ? $name : ''; ?>">
            <span class="error"><?php echo $nameErr;?></span>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>">
            <span class="error"><?php echo $lastnameErr;?></span>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo isset($address) ? $address : ''; ?>">
            <span class="error"><?php echo $addressErr;?></span>

            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo isset($city) ? $city : ''; ?>">
            <span class="error"><?php echo $cityErr;?></span>

            <label for="number">Number:</label>
            <input type="text" name="number" id="number" value="<?php echo isset($number) ? $number : ''; ?>">
            <span class="error"><?php echo $numberErr;?></span>

            <label for="birthdate">Birth Date:</label>
            <input type="text" name="birthdate" id="birthdate" value="<?php echo isset($birthdate) ? $birthdate : ''; ?>">
            <span class="error"><?php echo $birthdateErr;?></span>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>">
            <span class="error"><?php echo $emailErr;?></span>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php echo $passwordErr;?></span>

            <label for="profilepicture">Profile Picture:</label>
            <input type="file" name="profilepicture" id="profilepicture">

            <button type="submit" name="submit">Register</button>
        </form>
        <div class="login-link">
            <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
