<?php
require 'config.php';

function editUser($conn, $id, $name, $lastname, $address, $city, $number, $birthdate, $email, $role) {
    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $lastname = mysqli_real_escape_string($conn, $lastname);
    $address = mysqli_real_escape_string($conn, $address);
    $city = mysqli_real_escape_string($conn, $city);
    $number = mysqli_real_escape_string($conn, $number);
    $birthdate = mysqli_real_escape_string($conn, $birthdate);
    $email = mysqli_real_escape_string($conn, $email);
    $role= mysqli_real_escape_string($conn, $role);



    $sql = "UPDATE users SET name='$name', lastname='$lastname', address='$address', city='$city', number='$number', birthdate='$birthdate', email='$email',  role='$role' WHERE id='$id'";
    
    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return false; 
    }
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $number = $_POST['number'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

 
    if (editUser($conn, $id, $name,  $lastname, $address, $city, $number, $birthdate, $email, $role)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating user.";
    }
} else {

    $id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>">
        <label for="lastname">LastName:</label>
        <input type="text" name="lastname" id="lastname" value="<?php echo $user['lastname']; ?>">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $user['address']; ?>">
        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $user['city']; ?>">
        <label for="number">Number:</label>
        <input type="text" name="number" id="number" value="<?php echo $user['number']; ?>">
        <label for="birthdate">BirthDate:</label>
        <input type="text" name="birthdate" id="birthdate" value="<?php echo $user['birthdate']; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" value="<?php echo $user['role']; ?>">
        <button type="submit">Update User</button>
    </form>
</body>
</html>