<?php
    class Validation {
    public $errors = [];

    public function validateName($name) {
        if (empty($name)) {
            $this->errors['name'] = "Name is required";
            return false;
        }
        return true;
    }

    public function validateLastName($lastname) {
        if (empty($lastname)) {
            $this->errors['lastname'] = "Lastname is required";
            return false;
        }
        return true; 
    }

    public function validateAddress($address) {
        if (empty($address)) {
            $this->errors['address'] = "Address is required";
            return false;
        }
        return true;
    }

    public function validateCity($city) {
        if (empty($city)) {
            $this->errors['city'] = "City is required";
            return false;
        }
        return true;
    }

    public function validatePassword($password) {
        if (empty($password) || (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{6,}$/', $password))) {
            $this->errors['password'] = "Password must contain at least 6 characters with 1 uppercase letter, 1 lowercase letter, and 1 special character";
            return false;
        }
        return true;
    }

    public function validateNumber($number) {
        if (empty($number)) {
            $this->errors['number'] = "Number is required";
            return false;
        } elseif (!preg_match("/^\+?[0-9]{7,15}$/", $number)) {
            $this->errors['number'] = "Invalid phone number format";
            return false;
        }
        return true;
    }

    public function validateBirthdate($birthdate) {
        if (empty($birthdate)) {
            $this->errors['birthdate'] = "BirthDate is required";
            return false;
        }
        return true;
    }

    public function validateEmail($email, $conn) {
        if (empty($email)) {
            $this->errors['email'] = "Email is required";
            return false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format";
            return false;
        } else {
            $email = mysqli_real_escape_string($conn, $email);

            // Check if email is already registered
            $check_query = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $check_query);
            if (mysqli_num_rows($result) > 0) {
                $this->errors['email'] = "This email is already registered.";
                return false;
            }
        }
        return true;
    }
    
    public function validateRole($role) {
        if (empty($role)) {
            $this->errors['role'] = "Role is required";
            return false;
        }
        return true;
    }
}
?>
