<?php
require_once __DIR__ . '/../../config/session_check.php';
$title = "Dashboard";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container" style="margin-left: 250px; margin-top: 50px; padding: 20px;">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
    <p>Your email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
    <p>Your role: <?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
</main>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
