<?php
require_once __DIR__ . '/../config/init.php';

class Grade {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllGrades() {
        $query = "SELECT
                      g.id AS grade_id,
                      g.grade,
                      g.comments,
                      e.id AS enrollment_id,
                      s.id AS student_id,
                      st.username AS student_name,
                      c.id AS course_id,
                      c.name AS course_name,
                      te.username AS teacher_name
                  FROM grades g
                  LEFT JOIN enrollments e ON g.enrollment_id = e.id
                  LEFT JOIN students s ON e.student_id = s.id
                  LEFT JOIN users st ON s.user_id = st.id
                  LEFT JOIN courses c ON e.course_id = c.id
                  LEFT JOIN teachers t ON c.teacher_id = t.id
                  LEFT JOIN users te ON t.user_id = te.id
                  ORDER BY g.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addGrade($data) {
        $query = "INSERT INTO grades (enrollment_id, grade, comments) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['enrollment_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['grade'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['comments'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateGrade($id, $data) {
        $query = "UPDATE grades SET enrollment_id = ?, grade = ?, comments = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['enrollment_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['grade'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['comments'], PDO::PARAM_STR);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteGrade($id) {
        $query = "DELETE FROM grades WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function searchGrades($keyword) {
        $query = "SELECT
                      g.id AS grade_id,
                      g.grade,
                      g.comments,
                      e.id AS enrollment_id,
                      s.id AS student_id,
                      st.username AS student_name,
                      c.id AS course_id,
                      c.name AS course_name,
                      te.username AS teacher_name
                  FROM grades g
                  LEFT JOIN enrollments e ON g.enrollment_id = e.id
                  LEFT JOIN students s ON e.student_id = s.id
                  LEFT JOIN users st ON s.user_id = st.id
                  LEFT JOIN courses c ON e.course_id = c.id
                  LEFT JOIN teachers t ON c.teacher_id = t.id
                  LEFT JOIN users te ON t.user_id = te.id
                  WHERE st.username LIKE ? OR c.name LIKE ?
                  ORDER BY g.id DESC";
        $stmt = $this->conn->prepare($query);
        $like = "%{$keyword}%";
        $stmt->bindParam(1, $like, PDO::PARAM_STR);
        $stmt->bindParam(2, $like, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageGrade() {
        $query = "SELECT AVG(grade) AS average_grade FROM grades";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['average_grade'];
    }

    public function getAverageGradeLastMonth() {
        $query = "SELECT AVG(grade) AS average_grade
                  FROM grades
                  WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['average_grade'];
    }
}
?>