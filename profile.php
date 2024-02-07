<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// Dummy error variables, you can define them if needed
$idErr = $nameErr = $lastnameErr = $addressErr = $cityErr = $numberErr = $birthdateErr = $emailErr = $passwordErr = "";

// Handling form submission here, if needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <form action="update_profile.php" method="post" autocomplete="off">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" value="<?php echo $_SESSION["id"] ?>" readonly><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $_SESSION["name"] ?>"><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" id="lastname" value="<?php echo $_SESSION["lastname"] ?>"><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $_SESSION["address"] ?>"><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $_SESSION["city"] ?>"><br>

        <label for="number">Number:</label>
        <input type="text" name="number" id="number" value="<?php echo $_SESSION["number"] ?>"><br>

        <label for="birthdate">Birth Date:</label>
        <input type="text" name="birthdate" id="birthdate" value="<?php echo $_SESSION["birthdate"] ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo $_SESSION["email"] ?>"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value=""><br>

        <!-- Add a confirm password field if needed -->

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
