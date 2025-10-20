<?php
require_once 'database.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function existsByEmail($email) {
        $query = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $email);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function register($username, $password, $email, $role) {
        if ($this->existsbyEmail($email)) {
            return false; // User already exists
        } else {

            $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $hashed_password);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $role);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
}
?>