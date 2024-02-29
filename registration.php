<?php
require 'config.php';
require 'Validation.php';
class RegistrationForm {
    private $nameErr = '';
    private $lastnameErr = '';
    private $addressErr = '';
    private $cityErr = '';
    private $numberErr = '';
    private $birthdateErr = '';
    private $emailErr = '';
    private $passwordErr = '';
    private $registrationSuccess = false;
    private $conn; 

    public function __construct($conn) {
        $this->conn = $conn;
    }

    
    public function registerUser($name, $lastname, $address, $city, $number, $birthdate, $email, $password, $fileName, $role) {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, lastname, address, city, number, birthdate, email, password, profile_picture, role) VALUES ('$name', '$lastname', '$address', '$city', '$number', '$birthdate', '$email', '$hashed_password', '$fileName', '$role')";

        if (mysqli_query($this->conn, $query)) {
            $this->registrationSuccess = true;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($this->conn);
        }
    }


    public function handleFileUpload() {
        if ($_FILES['profilepicture']['name']) {
          
            $targetDir = "uploads/";
            $fileName = basename($_FILES["profilepicture"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFilePath)) {
                return $fileName;
            } else {
                echo "Sorry, there was an error uploading your file.";
                return null;
            }
        } else {
            echo 'Please select a file.';
            return null;
        }
    }

    public function isRegistrationSuccessful() {
        return $this->registrationSuccess;
    }

    public function getErrors() {
        return [
            'nameErr' => $this->nameErr,
            'lastnameErr' => $this->lastnameErr,
            'addressErr' => $this->addressErr,
            'cityErr' => $this->cityErr,
            'numberErr' => $this->numberErr,
            'birthdateErr' => $this->birthdateErr,
            'emailErr' => $this->emailErr,
            'passwordErr' => $this->passwordErr,
        ];
    }
}

$registrationForm = new RegistrationForm($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $password = $_POST["password"];
    $number = $_POST["number"];
    $birthdate = $_POST["birthdate"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    if ($registrationForm->validateName($name) && 
        $registrationForm->validateLastName($lastname) && 
        $registrationForm->validateAddress($address) && 
        $registrationForm->validateCity($city) && 
        $registrationForm->validatePassword($password) && 
        $registrationForm->validateNumber($number) && 
        $registrationForm->validateBirthdate($birthdate) && 
        $registrationForm->validateEmail($email) && 
        $registrationForm->validateRole($role)) {

        $fileName = $registrationForm->handleFileUpload();
        if ($fileName) {
            $registrationForm->registerUser($name, $lastname, $address, $city, $number, $birthdate, $email, $password, $fileName, $role);
        }
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
        .error {
            color: red;
            font-size: 12px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
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
</head>
<body>
    
    <div class="container">
        <h2>Registration</h2>

        <?php if ($registrationForm->isRegistrationSuccessful()): ?>
            <div class="success">You have successfully registered</div>
        <?php endif; ?>
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">

            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo isset($name) ? $name : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['nameErr'];?></span>


            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['lastnameErr'];?></span>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo isset($address) ? $address : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['addressErr'];?></span>

            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo isset($city) ? $city : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['cityErr'];?></span>

            <label for="number">Number:</label>
            <input type="text" name="number" id="number" value="<?php echo isset($number) ? $number : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['numberErr'];?></span>

            <label for="birthdate">Birth Date:</label>
            <input type="text" name="birthdate" id="birthdate" value="<?php echo isset($birthdate) ? $birthdate : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['birthdateErr'];?></span>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>">
            <span class="error"><?php echo $registrationForm->getErrors()['emailErr'];?></span>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php echo $registrationForm->getErrors()['passwordErr'];?></span>

            <label for="profilepicture">Profile Picture:</label>
            <input type="file" name="profilepicture" id="profilepicture">


            <button type="submit" name="submit">Register</button>
        </form>
        <div class="login-link">
            <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
