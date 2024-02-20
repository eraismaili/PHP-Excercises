<?php
session_start();

// me check a eshte logged in useri
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// me check rolin nese useri eshte admin ose jo
if ($_SESSION["role"] !== 'admin') {
    header("Location: profile.php");
    exit();
}

include 'menu.php';
require 'config.php';

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        .table-container {
            margin-top: 50px;
        }
        .table-custom {
            margin-bottom: 0;
            border-radius: 0;
        }
        .table-custom th,
        .table-custom td {
            padding: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Management</h2>

    <div class="table-container">
        <table class="table table-striped table-custom">
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

    <a class="btn btn-success" href="add_user.php">Add New User</a>

    <br><br>
    <form action="profile.php" method="post">
        <button class="btn btn-secondary" type="submit" name="logout">Logout</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>