<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/student.php';

require_login();
required_role(["admin"]);

$db = new Database();
$student = new Student($db->conn);
$students = $student->getAllStudents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $data = [
            'username' => trim($_POST['username']),
            'password' => $_POST['password'],
            'email' => strtolower(trim($_POST['email'])),   
        ];
        if ($student->addStudent($data)) {
            $_SESSION['success'] = "Student added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add student. Please try again.";
        }
        header("Location: manage_students.php");
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $student_id = intval($_POST['student_id']);
        $data = [
            'username' => trim($_POST['username']),
            'email' => strtolower(trim($_POST['email'])),
            'full_name' => trim($_POST['full_name']),
            'gender' => $_POST['gender'],
            'birth_date' => $_POST['birth_date'],
            'phone' => trim($_POST['phone']),
            'address' => trim($_POST['address']),
        ];
        if ($student->updateStudent($student_id, $data)) {
            $_SESSION['success'] = "Student updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update student. Please try again.";
        }
        header("Location: manage_students.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $student_id = intval($_GET['delete']);

    if ($student->deleteStudent($student_id)) {
        $_SESSION['success'] = "Student deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete student. Please try again.";
    }
    header("Location: manage_students.php");
    exit;
    }

$title = "Manage Students";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Students</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            Add Student
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
                <th>Username</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($students): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td><?= htmlspecialchars($student['username']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['full_name']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($student['gender']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($student['birth_date']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($student['phone']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($student['address']) ?? 'N/A' ?></td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning editBtn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editStudentModal"
                                data-student="<?= htmlspecialchars(json_encode($student), ENT_QUOTES) ?>">
                                Edit
                            </button>
                            <a href="?delete=<?= $student['id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this student?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
     </table>
</main>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="student_id" id="editStudentId">
    
                    <div class="mb-2">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="editUsername" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="editFullName" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="editGender" class="form-select">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="editBirthDate" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="editPhone" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" id="editAddress" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        const student = JSON.parse(this.getAttribute('data-student'));
        
        document.getElementById('editStudentId').value = student.id;
        document.getElementById('editUsername').value = student.username;
        document.getElementById('editEmail').value = student.email;
        document.getElementById('editFullName').value = student.full_name || '';
        document.getElementById('editGender').value = student.gender || '';
        document.getElementById('editBirthDate').value = student.birth_date || '';
        document.getElementById('editPhone').value = student.phone || '';
        document.getElementById('editAddress').value = student.address || '';
    });
});

setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    }
}, 4000);
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
