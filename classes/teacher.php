<?php 
require_once 'user.php';

class Teacher extends User {
    public function getAssignedStudents() {
        $query = "
            SELECT u.id, u.username, u.email
            FROM users u
            INNER JOIN teacher_student ts ON ts.student_id = u.id
            WHERE ts.teacher_id = ? AND u.role = 'student' 
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignStudent($student_id) {
        $query = "INSERT INTO teacher_student (teacher_id, student_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->bindParam(2, $student_id);
        return $stmt->execute();
    }
}
?>