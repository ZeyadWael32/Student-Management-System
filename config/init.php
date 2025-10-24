<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "session_check.php";
class Database {
    private $host = "localhost";
    private $db_name = "student_management_db";
    private $username = "zeyadwael11";
    private $password = "zezowael11";
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            die("Connection error: " . $exception->getMessage());
        }
    }
}
?>