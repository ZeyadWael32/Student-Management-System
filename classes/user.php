<?php
require_once __DIR__ . '/../config/init.php';

class User {
    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function existsByEmail($email) {
        $query = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function register($username, $password, $email, $role) {
        if ($this->existsByEmail($email)) {
            return false; // User already exists
        } else {

            $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(3, $email, PDO::PARAM_STR);
            $stmt->bindParam(4, $role, PDO::PARAM_STR);


            if ($stmt->execute()) {
                $user_id = $this->conn->lastInsertId();

                // Insert into role-specific table
                if ($role === 'teacher') {
                    $roleQuery = "INSERT INTO teachers (user_id) VALUES (:user_id)";
                } elseif ($role === 'student') {
                    $roleQuery = "INSERT INTO students (user_id) VALUES (:user_id)";
                } else {
                    $roleQuery = null;
                }

                if ($roleQuery) {
                    $stmtRole = $this->conn->prepare($roleQuery);
                    $stmtRole->bindParam(":user_id", $user_id);
                    $stmtRole->execute();
                }

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