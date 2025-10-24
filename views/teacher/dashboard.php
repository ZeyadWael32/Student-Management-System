<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/teacher.php';

require_login();
required_role(["teacher","admin"]);

$db = new Database();
$teacher = new Teacher($db->conn);

$students = $teacher->getAssignedStudents();

$title = "Dashboard";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container" style="margin-left: 250px; margin-top: 50px; padding: 20px;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
    <p>Your email: <?= htmlspecialchars($_SESSION['user_email']); ?></p>
    <p>Your role: <?= htmlspecialchars($_SESSION['user_role']); ?></p>

<div>
    <h2>Your Students</h2>
        <?php if (!empty($students)): ?>
            <table border="1" cellpadding="10">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= $s['id'] ?></td>
                        <td><?= htmlspecialchars($s['username']) ?></td>
                        <td><?= htmlspecialchars($s['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No students assigned yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
