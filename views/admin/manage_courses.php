<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/course.php';

require_login();
required_role(["admin"]);

$db = new Database();
$course = new Course($db->conn);
$courses = $course->getAllCourses();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $data = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
            'teacher_id' => $_POST['teacher_id']
        ];
        if ($course->addCourse($data)) {
            $_SESSION['success'] = "Course added successfully.";
        } else {
            $_SESSION['error'] = "Failed to add course.";
        }
        header("Location: manage_courses.php");
        exit();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = $_POST['course_id'];
        $data = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
            'teacher_id' => $_POST['teacher_id']
        ];
        if ($course->updateCourse($id, $data)) {
            $_SESSION['success'] = "Course updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update course.";
        }
        header("Location: manage_courses.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['delete'])) {
        $course_id = intval($_GET['delete']);

        if ($course->deleteCourse($course_id)) {
            $_SESSION['success'] = "Course deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete course.";
        }
        header("Location: manage_courses.php");
        exit();
    }

    if (isset($_GET['search'])) {
        $keyword = trim($_GET['search']);
        $courses = $course->searchCourses($keyword);
    } else {
        $keyword = '';
    }
}

$title = "Manage Courses";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Courses</h2>
            <form method="get" class="search-form d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name or subject..." 
                    value="<?= htmlspecialchars($keyword); ?>" />
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
            <i class="bi bi-plus-lg"></i> Add Course
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
                <th>Name</th>
                <th>Description</th>
                <th>Teacher</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($courses): ?>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['id']); ?></td>
                        <td><?= htmlspecialchars($course['name']); ?></td>
                        <td><?= htmlspecialchars($course['description']) ?? 'N/A'; ?></td>
                        <td><?= htmlspecialchars($course['teacher_name']) ?? 'N/A'; ?></td>
                        <td><?= htmlspecialchars($course['subject']) ?? 'N/A'; ?></td>
                        <td>
                            <button
                                class="btn btn-sm btn-warning editBtn"
                                data-bs-toggle="modal" 
                                data-bs-target="#editCourseModal"
                                data-course="<?= htmlspecialchars(json_encode($course), ENT_QUOTES) ?>">
                                Edit
                            </button>
                            <a href="?delete=<?= $course['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this course?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No courses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
    
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Teacher</label>
                        <input type="text" name="teacher" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Subject</label>
                        <input type="text" name="Subject" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="course_id" id="editCourseId">
    
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" id="editDescription" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Teacher</label>
                        <input type="text" name="teacher" id="editTeacher" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" id="editSubject" class="form-control" required>
                    </div>  
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', () => {
            const course = JSON.parse(button.getAttribute('data-course'));

            document.getElementById('editCourseId').value = course.id;
            document.getElementById('editName').value = course.name;
            document.getElementById('editDescription').value = course.description;
            document.getElementById('editTeacher').value = course.teacher_name;
            document.getElementById('editSubject').value = course.subject;
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
