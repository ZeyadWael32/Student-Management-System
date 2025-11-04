<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/grade.php';

require_login();
required_role(["admin"]);

$db = new Database();
$grade = new Grade($db->conn);
$grades = $grade->getAllGrades();
$keyword = '';

$title = "Manage Grades";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Grades</h2>
            <form method="get" class="search-form d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search by student or course..." 
                    value="<?= htmlspecialchars($keyword); ?>" />
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGradeModal">
            <i class="bi bi-plus-lg"></i> Add Grade
        </button>
    </div>
    
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Course</th>
            <th>Teacher</th>
            <th>Grade</th>
            <th>Comments</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($grades) > 0): ?>
            <?php foreach ($grades as $grade): ?>
                <tr>
                    <td><?= htmlspecialchars($grade['grade_id']); ?></td>
                    <td><?= htmlspecialchars($grade['student_name']); ?></td>
                    <td><?= htmlspecialchars($grade['course_name']); ?></td>
                    <td><?= htmlspecialchars($grade['teacher_name']); ?></td>
                    <td><?= htmlspecialchars($grade['grade']); ?></td>
                    <td><?= htmlspecialchars($grade['comments']); ?></td>
                    <td>
                        <button
                            class="btn btn-sm btn-warning editBtn"
                            data-bs-toggle="modal" 
                            data-bs-target="#editGradeModal"
                            data-grade="<?= htmlspecialchars(json_encode($grade), ENT_QUOTES) ?>">
                            Edit
                        </button>
                        <a href="?delete=<?= $grade['grade_id']; ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this grade?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No grades found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</main>

<!-- Add Grade Modal -->
 <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGradeModalLabel">Add New Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                </div>

                <div class="mb-2">
                    <label class="form-label">Grade</label>
                    <input type="text" name="grade" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Comments</label>
                    <textarea name="comments" class="form-control" rows="3"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Grade</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Grade Modal -->
 <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="course_id" id="editCourseId">
    
                    <div class="mb-2">
                        <label class="form-label">Grade</label>
                        <input type="text" name="grade" id="editGrade" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Comments</label>
                        <input type="text" name="comments" id="editComments" class="form-control" required>
                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Grade</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', () => {
            const gradeData = JSON.parse(button.getAttribute('data-grade'));
            document.getElementById('editCourseId').value = gradeData.grade_id;
            document.getElementById('editGrade').value = gradeData.grade;
            document.getElementById('editComments').value = gradeData.comments;
        });
    });

    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000);
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
