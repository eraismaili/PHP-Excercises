<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Clear all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect the user to the login page
    header("Location: login.php");
    exit;
}
// Include database connection and configuration
require 'config.php';

// Query to retrieve the profile picture path from the database
$user_id = $_SESSION["id"];
$query = "SELECT profile_picture FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profile_picture = $row['profile_picture'];
}

// Dummy error variables, you can define them if needed
$nameErr = $lastnameErr = $addressErr = $cityErr = $numberErr = $birthdateErr = $emailErr = $passwordErr = $oldPassErr="";
$updateMessage = "";

// Handling form submission here, if needed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields

    !empty($_POST['name']) ? $_SESSION["name"] = $_POST["name"] :  $nameErr = "Name is required";

    !empty($_POST['lastname']) ? $_SESSION["lastname"] = $_POST["lastname"] :  $lastnameErr = "LastName is required";

    !empty($_POST['address']) ? $_SESSION["address"] = $_POST["address"] :  $addressErr = "Address is required";

    !empty($_POST['city']) ? $_SESSION["city"] = $_POST["city"] :  $cityErr = "City is required";

    !empty($_POST['number']) ? $_SESSION["number"] = $_POST["number"] :  $numberErr = "Number is required";

    !empty($_POST['birthdate']) ? $_SESSION["birthdate"] = $_POST["birthdate"] :  $birthdateErr = "Birthdate is required";

    !empty($_POST['email']) ? $_SESSION["email"] = $_POST["email"] :  $emailErr = "email is required";

    !empty($_POST['password']) ? $_SESSION["password"] = $_POST["password"] :  $oldPassErr= "password is required";
    
    if (empty($nameErr) && empty($lastnameErr) && empty($addressErr) && empty($cityErr) && empty($numberErr) && empty($birthdateErr) && empty($emailErr)) {

  

        if ($_FILES['profile_picture']['name']) {
            // File upload path
            $targetDir = "uploads/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to the server
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
                    // Update profile picture path in the database
                    $query = "UPDATE users SET profile_picture = '$fileName' WHERE id = '" . $_SESSION["id"] . "'";
                    if (mysqli_query($conn, $query)) {
                        $_SESSION["success_message"] = 'Profile picture updated successfully';
                    } else {
                        $_SESSION["error_message"] = "Error updating profile picture: " . mysqli_error($conn);
                    }
                } else {
                    $_SESSION["error_message"] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION["error_message"] = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        }
            
    
            $id = $_SESSION["id"];
            $name = $_SESSION["name"];
            $lastname = $_SESSION["lastname"];
            $address = $_SESSION["address"];
            $city = $_SESSION["city"];
            $number = $_SESSION["number"];
            $birthdate = $_SESSION["birthdate"];
            $email = $_SESSION["email"];
            $password = $_SESSION["password"];
    
            $sql = "UPDATE users SET name='$name', lastname='$lastname', address='$address', city='$city', number='$number', birthdate='$birthdate', email='$email',password='$password' WHERE id='$id'";
    
            if ($conn->query($sql) === TRUE) {
                
        $updateMessage = "Profile updated successfully";
            } else {
                $message = "Error updating record: " . $conn->error;
            }
    
            $conn->close();
        } else {
    }  

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
        <h2>User Profile</h2>

  <!-- Add profile picture display -->
  <?php if(isset($profile_picture)): ?>
    <img src="uploads/<?php echo $profile_picture; ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; margin: 0 auto; display: block;">
<?php endif; ?>

<?php if (!empty($updateMessage)): ?>
        <p style="color: green;"><?php echo $updateMessage; ?></p>
    <?php endif; ?>

        <form action="profile.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" value="<?php echo $_SESSION["id"] ?>" readonly>
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $_SESSION["name"] ?>">
            <span class="error"><?php echo $nameErr;?></span>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $_SESSION["lastname"] ?>">
            <span class="error"><?php echo $lastnameErr;?></span> 

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo $_SESSION["address"] ?>">
            <span class="error"><?php echo $addressErr;?></span>

           
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo $_SESSION["city"] ?>">
            <span class="error"><?php echo $cityErr;?></span>

      
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" value="<?php echo $_SESSION["number"] ?>">
            <span class="error"><?php echo $numberErr;?></span>

            <label for="birthdate">Birth Date:</label>
            <input type="text" name="birthdate" id="birthdate" value="<?php echo $_SESSION["birthdate"] ?>">
            <span class="error"><?php echo $birthdateErr;?></span>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo $_SESSION["email"] ?>">
            <span class="error"><?php echo $emailErr;?></span>
            
            <label for="password">Old Password:</label>
            <input type="password" name="old_password" id="old_password" value="">

            <label for="password"> Password:</label>
            <input type="password" name="new_password" id="new_password" value="">

            <!-- Upload profile picture -->
        <label for="profilepicture">Upload New Profile Picture:</label>
        <input type="file" name="profile_picture" id="profilepicture">
        
            <button type="submit">Update Profile</button>
            <br>
            <button type="submit" name="logout">Logout</button> 
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#birthdate").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: 0,
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
</body>
</html>
