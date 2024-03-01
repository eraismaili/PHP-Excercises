<?php 
class Validation {
    public $errors = [];

    public function validateName($name) {
        if (empty($name)) {
            return false;
        }
        return true;
    }

    public function validateLastName($lastname) {
        if (empty($lastname)) {
            return false;
        }
        return true; 
    }

    public function validateAddress($address) {
        if (empty($address)) {
            return false;
        }
        return true;
    }

    public function validateCity($city) {
        if (empty($city)) {
            return false;
        }
        return true;
    }

    public function validatePassword($password) {
        if (empty($password) || (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{6,}$/', $password))) {
            return false;
        }
        return true;
    }

    public function validateNumber($number) {
        if (empty($number) || !preg_match("/^\+?[0-9]{7,15}$/", $number)) {
            return false;
        }
        return true;
    }

    public function validateBirthdate($birthdate) {
        if (empty($birthdate)) {
            return false;
        }
        return true;
    }

    public function validateEmail($email, $conn) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            $email = mysqli_real_escape_string($conn, $email);
            $check_query = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $check_query);
            if (mysqli_num_rows($result) > 0) {
                return false;
            }
        }
        return true;
    }
    
    public function validateRole($role) {
        if (empty($role)) {
            return false;
        }
        return true;
    }

    public function validateFormData($name, $lastname, $address, $city, $number, $birthdate, $email, $password, $role, $conn) {
        $valid = true; 
        $errors = [];

        if (!$this->validateName($name)) {
            $errors['nameErr'] = "Name is required";
            $valid = false;
        }

        if (!$this->validateLastName($lastname)) {
            $errors['lastnameErr'] = "Lastname is required";
            $valid = false;
        }

        if (!$this->validateAddress($address)) {
            $errors['addressErr'] = "Address is required";
            $valid = false;
        }

        if (!$this->validateCity($city)) {
            $errors['cityErr'] = "City is required";
            $valid = false;
        }

        if (!$this->validatePassword($password)) {
            $errors['passwordErr'] = "Password must contain at least 6 characters with 1 uppercase letter, 1 lowercase letter, and 1 special character";
            $valid = false;
        }

        if (!$this->validateNumber($number)) {
            $errors['numberErr'] = "Invalid phone number format";
            $valid = false;
        }

        if (!$this->validateBirthdate($birthdate)) {
            $errors['birthdateErr'] = "BirthDate is required";
            $valid = false;
        }

        if (!$this->validateEmail($email, $conn)) {
            $errors['emailErr'] = "Invalid email or already registered";
            $valid = false;
        }

        if (!$this->validateRole($role)) {
            $errors['roleErr'] = "Role is required";
            $valid = false;
        }

        return array($valid, $errors);
    }
   
}
?>
