
/*session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

require'config.php';

//  validation functions for email, number, and password
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateNumber($number) {
    return preg_match("/^\+?[0-9]{7,15}$/", $number);
}

function validatePassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{6,}$/', $password);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle profile picture upload
    if ($_FILES['profilepicture']['name']) {
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["profilepicture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to the server
            if (move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFilePath)) {
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

    // validimi i te dhenave
    $valid = true;
    $errors = array();
    !empty($_POST['name']) ? $_SESSION["name"] = $_POST["name"] :  $nameErr = "Name is required";

    
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
        if (!validateNumber($_POST["number"])) {
            $valid = false;
            $errors["number"] = "Invalid phone number format";
        } else {
            $_SESSION["number"] = $_POST["number"];
        }
    }
    if (!empty($_POST["birthdate"])) {
        $_SESSION["birthdate"] = $_POST["birthdate"];
    }
    if (!empty($_POST["email"])) {
        if (!validateEmail($_POST["email"])) {
            $valid = false;
            $errors["email"] = "Invalid email format";
        } else {
            $_SESSION["email"] = $_POST["email"];
        }
    }
    if (!empty($_POST["new_password"])) {
        if (!validatePassword($_POST["new_password"])) {
            $valid = false;
            $errors["password"] = "Password must contain at least 6 characters with 1 uppercase letter, 1 lowercase letter, and 1 special character";
        } else {
            $hashed_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            $_SESSION["password"] = $hashed_password;
        }
    }

    if ($valid) {
        // Update the database
        $conn = mysqli_connect("localhost", "root", "", "users");

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
        $password = $_SESSION["password"];

        $sql = "UPDATE users SET name='$name', lastname='$lastname', address='$address', city='$city', number='$number', birthdate='$birthdate', email='$email',password='$password' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["success_message"] = 'Profile updated successfully';
        } else {
            $message = "Error updating record: " . $conn->error;
        }

        $conn->close();
    } else {
        // If validation fails, redirect back to the profile page with errors
        $_SESSION["errors"] = $errors;
        header("Location: profile.php");
        exit();
    }
}

header("Location: profile.php");
// Redirect back to the profile page after updating
exit();
?>
