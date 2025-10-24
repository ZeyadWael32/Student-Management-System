<?php
function check_login() {
    return isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]);
}

function require_login() {
    if (!check_login()) {
        header("Location: ../../public/auth/login.php");
        exit();
    }
}

function required_role($allowed_roles = []) {
    require_login();

    if (!in_array($_SESSION["user_role"], $allowed_roles)) {
        header("Location: ../../public/index.php");
        exit();
    }
}
?>