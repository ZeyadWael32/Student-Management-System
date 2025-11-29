<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/teacher.php';

require_login();
required_role(["admin"]);

$db = new Database();
$teacher = new Teacher($db->conn);
$teachers = $teacher->getAllTeachers();
$keyword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $data = [
            'username' => trim($_POST['username']),
            'password' => $_POST['password'],
            'email' => strtolower(trim($_POST['email'])),   
        ];
        if ($teacher->addTeacher($data)) {
            $_SESSION['success'] = "Teacher added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add teacher. Please try again.";
        }
        header("Location: manage_teachers.php");
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $teacher_id = intval($_POST['teacher_id']);
        $data = [
            'username' => trim($_POST['username']),
            'email' => strtolower(trim($_POST['email'])),
            'subject' => trim($_POST['subject']),
            'full_name' => trim($_POST['full_name']),
            'gender' => $_POST['gender'],
            'birth_date' => !empty($_POST['birth_date']) ? $_POST['birth_date'] : null,
            'phone' => trim($_POST['phone']),
            'address' => trim($_POST['address']),
        ];
        if ($teacher->updateTeacher($teacher_id, $data)) {
            $_SESSION['success'] = "Teacher updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update teacher. Please try again.";
        }
        header("Location: manage_teachers.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['delete'])) {
        $teacher_id = intval($_GET['delete']);

        if ($teacher->deleteTeacher($teacher_id)) {
            $_SESSION['success'] = "Teacher deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete teacher. Please try again.";
        }
        header("Location: manage_teachers.php");
        exit;
    }

    if (isset($_GET['search'])) {
        $keyword = trim($_GET['search']);
        $teachers = $teacher->searchTeachers($keyword);
    } else {
        $keyword = '';
    }
}

$title = "Manage Teachers";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Teachers</h2>        
            <form method="get" class="search-form d-flex align-items-center gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." 
                    value="<?= htmlspecialchars($keyword); ?>" />
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
           <i class="bi bi-plus-lg"></i> Add Teacher
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
                <th>Subject</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($teachers): ?>
                <?php foreach ($teachers as $teacher): ?>
                    <tr>
                        <td><?= htmlspecialchars($teacher['teacher_id']) ?></td>
                        <td><?= htmlspecialchars($teacher['username']) ?></td>
                        <td><?= htmlspecialchars($teacher['email']) ?></td>
                        <td><?= htmlspecialchars($teacher['subject']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($teacher['full_name']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($teacher['gender']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($teacher['birth_date']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($teacher['phone']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($teacher['address']) ?? 'N/A' ?></td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning editBtn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editTeacherModal"
                                data-teacher="<?= htmlspecialchars(json_encode($teacher), ENT_QUOTES) ?>">
                                Edit
                            </button>
                            <a href="?delete=<?= $teacher['user_id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this teacher?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No teachers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
     </table>
</main>

<?php include_once __DIR__ . '/../../includes/modals.php'; ?>

<script>
document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', function() {
        const teacher = JSON.parse(this.getAttribute('data-teacher'));
        
        document.getElementById('editTeacherId').value = teacher.user_id;
        document.getElementById('editUsername').value = teacher.username;
        document.getElementById('editEmail').value = teacher.email;
        document.getElementById('editFullName').value = teacher.full_name || '';
        document.getElementById('editGender').value = teacher.gender || '';
        document.getElementById('editBirthDate').value = teacher.birth_date || '';
        document.getElementById('editPhone').value = teacher.phone || '';
        document.getElementById('editAddress').value = teacher.address || '';
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