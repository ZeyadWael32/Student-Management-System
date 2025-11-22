<?php
require_once 'student.php';
require_once 'course.php';
require_once 'grade.php';
require_once 'enrollment.php';

class AdminDashboard {

    private $student;
    private $course;
    private $grade;
    private $enrollment;

    public function __construct($db) {
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

    private function growth($current, $last) {
        if ($last == 0 || $last === null) return 0;
        return round((($current - $last) / $last) * 100, 1);
    }
}
?>