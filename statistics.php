<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Statistics</title>

    <style>
        .box {
            width: 30%;
            background-color: #f0f0f0;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Admin Statistics</h1>

    <?php
   
    require 'config.php';


    $total_users_query = "SELECT COUNT(*) as total_users FROM users";
    $total_users_result = mysqli_query($conn, $total_users_query);
    $total_users_row = mysqli_fetch_assoc($total_users_result);
    $total_users = $total_users_row['total_users'];

    
    $active_users_query = "SELECT COUNT(*) as active_users FROM users WHERE active = 1";
    $active_users_result = mysqli_query($conn, $active_users_query);
    $active_users_row = mysqli_fetch_assoc($active_users_result);
    $active_users = $active_users_row['active_users'];

 
    $inactive_users = $total_users - $active_users;
    ?>

    <div class="box">
    <h2><a href="dashboard.php?filter=all_users">Total Users</a></h2>
        <p><?php echo $total_users; ?></p>
    </div>

    <div class="box">
    <h2><a href="dashboard.php?filter=all_users">Active Users</a></h2>
    <p><?php echo $active_users; ?></p>
    </div>

    <div class="box">
    <h2><a href="dashboard.php?filter=inactive_users">Inactive Users</a></h2>
        <p><?php echo $inactive_users; ?></p>
    </div>

</body>
</html>
