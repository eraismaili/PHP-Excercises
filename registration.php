<?php
require 'config.php';

$nameErr = $lastnameErr = $addressErr = $cityErr = $numberErr = $birthdateErr = $emailErr = $passwordErr = "";

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

    if (empty($_POST["number"])) {
        $numberErr = "Number is required";
    } else {
        $number = $_POST["number"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["birthdate"])) {
        $emailErr = "BirthDate is required";
    } else {
        $email = $_POST[""];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty($nameErr) && empty($lastnameErr) && empty($addressErr) && empty($cityErr) && empty($numberErr) && empty($birthdateErr) && empty($emailErr) && empty($passwordErr)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            echo "<script> alert('Email Has Already Taken'); </script>";
        } else {
            $query = "INSERT INTO users (name, lastname, address, city, number, birthdate, email, password ) VALUES ('$name', '$lastname', '$address', '$city', '$number', '$email', '$birthdate','$hashed_password' )";

            if (mysqli_query($conn, $query)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }

            header("Location: login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form class="" action="" method="post" autocomplete="off">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"  value="">
        <span class="error"><?php echo $nameErr;?></span><br>

        <label for="lastname">LastName:</label>
        <input type="text" name="lastname" id="lastname"  value="">
        <span class="error"><?php echo $lastnameErr;?></span><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="">
        <span class="error"><?php echo $addressErr;?></span><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city"  value="">
        <span class="error"><?php echo $cityErr;?></span><br>

        <label for="number">Number:</label>
        <input type="text" name="number" id="number"  value="">
        <span class="error"><?php echo $numberErr;?></span><br>

        <label for="birthdate">BirthDate:</label>
        <input type="text" name="birthdate" id="birthdate"  value="">
        <span class="error"><?php echo $birthdateErr;?></span><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email"  value="">
        <span class="error"><?php echo $emailErr;?></span><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"  value="">
        <span class="error"><?php echo $passwordErr;?></span><br>

        <button type="submit" name="submit">Register</button>
    </form>
    <br>
    <a href="login.php">Login</a>
</body>
</html>
