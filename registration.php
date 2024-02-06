<?php
require 'config.php';

if(isset($_POST["submit"])) {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $number = $_POST["number"];
    $email = $_POST["email"];
  
    $password = $_POST["password"];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Email Has Already Taken'); </script>";
    } else {
        $query = "INSERT INTO users (name, lastname, address, city, number, email, password ) VALUES ('$name', '$lastname', '$address', '$city', '$number', '$email', '$hashed_password' )";
        
        if(mysqli_query($conn, $query)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
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
        <input type="text" name="name" id="name" required value=""><br>
        <label for="lastname">LastName:</label>
        <input type="text" name="lastname" id="lastname" required value=""><br>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required value=""><br>
        <label for="city">City:</label>
        <input type="text" name="city" id="city" required value=""><br>
        <label for="number">Number:</label>
        <input type="text" name="number" id="number" required value=""><br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required value=""><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required value=""><br>
        <button type="submit" name="submit">Register</button>
    </form>
    <br>
    <a href="login.php">Login</a>
</body>
</html>
