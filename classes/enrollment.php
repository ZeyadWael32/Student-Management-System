<?php
require_once __DIR__ . '/../config/init.php';

class Enrollment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTotalEnrollments() {
        $query = "SELECT COUNT(*) AS total FROM enrollments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getEnrollmentCountLastMonth() {
        $query = "SELECT COUNT(*) AS total FROM enrollments WHERE enrollment_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>