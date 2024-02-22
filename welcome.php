<?php 

session_start();

// me check a eshte logged in useri
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}


include 'menu.php';
require 'config.php';
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="welcome-message">
        <h1>Welcome <?php echo $_SESSION["name"]; ?></h1>
        <p>Welcome</p>
    </div>
</body>
</html>