<?php
require_once __DIR__ . '/../../config/init.php';

require_login();
required_role(["admin"]);


$title = "Manage Courses";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main>

</main>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
