<?php
require_once 'student.php';
require_once 'course.php';
require_once 'grade.php';
require_once 'enrollment.php';

class Dashboard {
    protected $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    protected function growth($current, $last) {
        if ($last == 0 || $last === null) return 0;
        return round((($current - $last) / $last) * 100, 1);
    }

    public function getAnnouncement($audience) {
        $query = "SELECT * FROM announcements WHERE audience IN ('all', ?) ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $audience, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
class AdminDashboard extends Dashboard {

    private $student;
    private $course;
    private $grade;
    private $enrollment;

    public function __construct($db) {
        parent::__construct($db);

        $this->student = new Student($db);
        $this->course = new Course($db);
        $this->grade = new Grade($db);
        $this->enrollment = new Enrollment($db);
    }

    public function getStats() {
            $studentCount = $this->student->countStudents();
            $courseCount = $this->course->getTotalCourse();
            $gradeCount = $this->grade->getAverageGrade();
            $enrollmentCount = $this->enrollment->getTotalEnrollments();

            $studentCountLastMonth = $this->student->getStudentCountLastMonth();
            $courseCountLastMonth = $this->course->getCourseCountLastMonth();
            $gradeAverageLastMonth = $this->grade->getAverageGradeLastMonth();
            $enrollmentCountLastMonth = $this->enrollment->getEnrollmentCountLastMonth();

            return [
                'studentCount' => $studentCount,
                'studentGrowth' => $this->growth($studentCount, $studentCountLastMonth),

                'courseCount' => $courseCount,
                'courseGrowth' => $this->growth($courseCount, $courseCountLastMonth),

                'averageGrade' => $gradeCount,
                'gradeChange' => $this->growth($gradeCount, $gradeAverageLastMonth),

                'enrollmentCount' => $enrollmentCount,
                'enrollmentGrowth' => $this->growth($enrollmentCount, $enrollmentCountLastMonth),
            ];
    }

    public function getEnrollmentChartData() {
        $query = "SELECT DATE_FORMAT(enrollment_date, '%b') AS month, COUNT(*) AS count
                  FROM enrollments
                  WHERE enrollment_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                  GROUP BY month
                  ORDER BY MIN(enrollment_date)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $months = [];
        $counts = [];

        foreach ($data as $row) {
            $months[] = $row['month'];
            $counts[] = $row['count'];
        }

        return ['months' => $months, 'counts' => $counts];
    }

    public function generateReport($type, $startDate, $endDate) {
        $startDate = date('Y-m-d', strtotime($startDate, PDO::PARAM_STR));
        $endDate = date('Y-m-d', strtotime($endDate, PDO::PARAM_STR));

        switch ($type) {
            case 'students':
                $query = "SELECT * FROM students WHERE created_at BETWEEN ? AND ?";
                $stmt = $this->conn->prepare($query);
                break;
            case 'courses':
                $query = "SELECT * FROM courses WHERE created_at BETWEEN ? AND ?";
                $stmt = $this->conn->prepare($query);
                break;
            case 'grades':
                $query = "SELECT * FROM grades WHERE created_at BETWEEN ? AND ?";
                $stmt = $this->conn->prepare($query);
                break;
            case 'enrollments':
                $query = "SELECT * FROM enrollments WHERE enrollment_date BETWEEN ? AND ?";
                $stmt = $this->conn->prepare($query);
                break;
            default:
                return [];
        }

        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAttendance($studentId, $date, $status) {
        $query = "INSERT INTO attendance (student_id, attendance_date, status)
                  VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $studentId, PDO::PARAM_INT);
        $stmt->bindParam(2, $date, PDO::PARAM_STR);
        $stmt->bindParam(3, $status, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function sendAnnouncement($title, $message, $audience) {
        $query = "INSERT INTO announcements (title, message, audience, created_at)
                  VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $message, PDO::PARAM_STR);
        $stmt->bindParam(3, $audience, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>