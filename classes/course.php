<?php
require_once __DIR__ . '/../config/init.php';

class Course {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCourses() {
        $query = "SELECT c.id, c.name, c.description, u.username AS teacher_name, t.subject 
                  FROM courses c 
                  LEFT JOIN teachers t ON c.teacher_id = t.id 
                  LEFT JOIN users u ON t.user_id = u.id
                  ORDER BY c.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCourse($data) {
        $query = "INSERT INTO courses (name, description, teacher_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['teacher_id'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCourse($id, $data) {
        $query = "UPDATE courses SET name = ?, description = ?, teacher_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['teacher_id'], PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCourse($id) {
        $query = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function searchCourses($keyword) {
        $query = "SELECT c.id, c.name, c.description, u.username AS teacher_name, t.subject 
                  FROM courses c 
                  LEFT JOIN teachers t ON c.teacher_id = t.id 
                  LEFT JOIN users u ON t.user_id = u.id
                  WHERE c.name LIKE ? OR t.subject LIKE ?
                  ORDER BY c.id DESC";
        $stmt = $this->conn->prepare($query);
        $like = "%{$keyword}%";
        $stmt->bindParam(1, $like, PDO::PARAM_STR);
        $stmt->bindParam(2, $like, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCourse() {
        $query = "SELECT COUNT(*) AS total FROM courses";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getCourseCountLastMonth() {
        $query = "SELECT COUNT(*) AS total FROM courses WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
?>