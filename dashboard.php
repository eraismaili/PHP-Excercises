<?php
session_start();

// me check a eshte logged in useri
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}


include 'menu.php';
require 'config.php';
require 'user.php';

// Create an instance of the User class
$user = new User($conn);

/// Retrieve all users using the getAllUsers method
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
       
        <style>
        .table-container {
            margin-top: 50px;
            width: 500px; 
            overflow-x: auto; 
        }
        .table-custom {
            margin-bottom: 0;
            border-radius: 0;
            width: 120%; 
        }
        .table-custom th,
        .table-custom td {
            padding: 0.5rem;
            white-space: nowrap; 
        }
        
        .table-custom th:nth-child(8),
        .table-custom td:nth-child(8),
        .table-custom th:nth-child(4), 
        .table-custom td:nth-child(4),
        .table-custom th:nth-child(9), 
        .table-custom td:nth-child(9) {
            max-width: 150px; 
            overflow: hidden;
            text-overflow: ellipsis; 
        }
    </style>
</head>
    </style>
</head>
<body>


    <h2 class="mt-5 text-center">User Management</h2>
 
    <a class="row float-right btn btn-success mr-5 mb-2" href="add_user.php">Add New User</a>
   
    <div class="table-container col-12">
        <table class="table table-striped table-custom mt-5 ml-3" style="width:95%;!important">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Lastname</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Number</th>
                    <th>Birthdate</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['address']; ?></td>
                    <td><?php echo $user['city']; ?></td>
                    <td><?php echo $user['number']; ?></td>
                    <td><?php echo $user['birthdate']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['password']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a class="btn btn-danger btn-sm" href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>