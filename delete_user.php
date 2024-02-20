<?php
require 'config.php';

function deleteUser($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        return true; 
    } else {
        return false; 
    }
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id = $_GET['id'];

    if (deleteUser($conn, $id)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting user.";
    }
} else {

    echo '<script>';
    echo 'if(confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete_user.php?id=' . $_GET['id'] . '&confirm=true";
        } else {
            window.location.href = "dashboard.php";
        }';
    echo '</script>';
}
?>
