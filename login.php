<?php
require 'config.php';

if (isset($_POST["submit"])) {
    $nameemail = $_POST["nameemail"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE name ='$nameemail' OR email = '$nameemail'");
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
        // Verify the password using password_verify
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Wrong Password');</script>";
        }
    } else {
        echo "<script>alert('User Not Registered');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form class="" action="" method="post" autocomplete="off">
        <label for="nameemail">Name or Email:</label>
        <input type="text" name="nameemail" id="nameemail" required value=""><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required value=""><br>
        <button type="submit" name="submit">Login</button>
    </form>
    <br>
    <a href="registration.php">Registration</a>
</body>
</html>
