<?php
require_once __DIR__ . '/../../config/init.php';

require_login();
required_role(["admin"]);


$title = "Dashboard";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container" style="margin-left: 250px; margin-top: 50px; padding: 20px;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
    <p>Your email: <?= htmlspecialchars($_SESSION['user_email']); ?></p>
    <p>Your role: <?= htmlspecialchars($_SESSION['user_role']); ?></p>
</main>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
