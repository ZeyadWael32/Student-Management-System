<?php
require_once 'user.php'; 
class Student extends User {

    public function getAllStudents() {
        $query = "SELECT s.id, u.username, u.email, s.full_name, s.gender, s.birth_date, s.phone , s.address 
                  FROM students s 
                  JOIN users u ON s.user_id = u.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getStudentById($student_id) {
        $query = "SELECT s.id, u.username, u.email, s.full_name, s.gender, s.birth_date, s.phone, s.address 
                  FROM students s 
                  JOIN users u ON s.user_id = u.id 
                  WHERE s.id = ?
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addStudent($data) {
        $query = "INSERT INTO users (username, password, email, role) 
                  VALUES (?, ?, ?, 'student')";

        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt->bindParam(1, $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(3, $data['email'], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $user_id = $this->conn->lastInsertId();
            $studentQuery = "INSERT INTO students (user_id) VALUES (?)";

            $stmtStudent = $this->conn->prepare($studentQuery);
            $stmtStudent->bindParam(1, $user_id, PDO::PARAM_INT);

            return $stmtStudent->execute();
        } else {
            return false;
        }
    }
    
    public function updateStudent($id, $data) {
        $query = "UPDATE users u
                  JOIN students s ON u.id = s.user_id
                  SET u.username = ?, u.email = ?, s.full_name = ?, s.gender = ?, s.birth_date = ?, s.phone = ?, s.address = ?
                  WHERE s.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['full_name'], PDO::PARAM_STR);
        $stmt->bindParam(4, $data['gender'], PDO::PARAM_STR);
        $stmt->bindParam(5, $data['birth_date'], PDO::PARAM_STR);
        $stmt->bindParam(6, $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(7, $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(8, $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $query = "DELETE FROM users WHERE id = ? AND role = 'student'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* Student-Teacher Relations */

    public function assignTeacher($student_id, $teacher_id) {
        $query = "INSERT INTO teacher_student (teacher_id, student_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $student_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function unassignTeacher($student_id, $teacher_id) {
        $query = "DELETE FROM teacher_student WHERE teacher_id = ? AND student_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $student_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getTeachersByStudent($student_id) {
        $query = "SELECT t.id, u.username, u.email, t.full_name, t.subject, t.phone 
                  FROM teachers t 
                  JOIN users u ON t.user_id = u.id 
                  JOIN teacher_student ts ON t.id = ts.teacher_id 
                  WHERE ts.student_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $student_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Utilities */

    public function countStudents() {
        $query = "SELECT COUNT(*) AS total FROM students";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function searchStudents($keyword) {
        $query = "
            SELECT 
                s.id, u.username, u.email, 
                s.full_name, s.gender, s.birth_date, s.phone, s.address
            FROM students s
            JOIN users u ON s.user_id = u.id
            WHERE u.role = 'student'
            AND (u.username LIKE ? OR u.email LIKE ?)
        ";

        $stmt = $this->conn->prepare($query);
        $like = "%{$keyword}%";
        $stmt->bindParam(1, $like, PDO::PARAM_STR);
        $stmt->bindParam(2, $like, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentsByTeacher($teacher_id) {
        $query = "
        SELECT s.id, u.username, u.email, s.phone 
        FROM students s
        INNER JOIN users u ON s.user_id = u.id
        INNER JOIN teacher_student ts ON s.id = ts.student_id
        WHERE ts.teacher_id = ? AND u.role = 'student'
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>