<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// Include your database connection file if you haven't already
// require_once 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update each field individually
    if (!empty($_POST["name"])) {
        $_SESSION["name"] = $_POST["name"];
    }
    if (!empty($_POST["lastname"])) {
        $_SESSION["lastname"] = $_POST["lastname"];
    }
    if (!empty($_POST["address"])) {
        $_SESSION["address"] = $_POST["address"];
    }
    if (!empty($_POST["city"])) {
        $_SESSION["city"] = $_POST["city"];
    }
    if (!empty($_POST["number"])) {
        $_SESSION["number"] = $_POST["number"];
    }
    if (!empty($_POST["birthdate"])) {
        $_SESSION["birthdate"] = $_POST["birthdate"];
    }
    if (!empty($_POST["email"])) {
        $_SESSION["email"] = $_POST["email"];
    }

    // Update the database
    // Assuming you're using mysqli for database operations
    // Replace 'your_db_connection' with your actual database connection object
    $conn=mysqli_connect("localhost", "root", "", "users");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_SESSION["id"];
    $name = $_SESSION["name"];
    $lastname = $_SESSION["lastname"];
    $address = $_SESSION["address"];
    $city = $_SESSION["city"];
    $number = $_SESSION["number"];
    $birthdate = $_SESSION["birthdate"];
    $email = $_SESSION["email"];

    $sql = "UPDATE users SET name='$name', lastname='$lastname', address='$address', city='$city', number='$number', birthdate='$birthdate', email='$email' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
       $message = 'Success';
    } else {
        $message = "Error updating record: " . $conn->error;
    }

    $conn->close();
}
header("Location: profile.php");
// Redirect back to the profile page after updating

exit();
?>
