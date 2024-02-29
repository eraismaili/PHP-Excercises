<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createUser($name, $lastname, $address, $city, $number, $birthdate, $email, $password)
    {
        $sql = "INSERT INTO users (name, lastname, address, city, number, birthdate, email, password) 
                VALUES ('$name', '$lastname', '$address', '$city', '$number', '$birthdate', '$email', '$password')";
        return mysqli_query($this->conn, $sql);
    }

    public function editUser($id, $name, $lastname, $address, $city, $number, $birthdate, $email, $password)
    {
        $sql = "UPDATE users 
                SET name='$name', lastname='$lastname', address='$address', city='$city', 
                number='$number', birthdate='$birthdate', email='$email', password='$password' 
                WHERE id='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id='$id'";
        return mysqli_query($this->conn, $sql);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function getActiveUsers()
    {
        $sql="SELECT * FROM users WHERE active=1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function getInactiveUsers()
    {
        $sql = "SELECT * FROM users WHERE active = 0";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function getSessionData()
    {
        session_start();
        $userData = array();
        if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
            $userData["id"] = $_SESSION["id"];
            $userData["name"] = $_SESSION["name"];
            $userData["lastname"] = $_SESSION ["lastname"];
            $userData["address"]= $_SESSION ["address"];
            $userData["city"]= $_SESSION ["city"];
            $userData["number"]=$_SESSION ["number"];
            $userData["birthdate"]=$_SESSION ["birthdate"];
            $userData["email"]=$_SESSION ["email"];
            $userData["password"]=$_SESSION ["password"];
        }
        return $userData;
    }
}

