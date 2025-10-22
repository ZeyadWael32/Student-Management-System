<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/user.php';

$db = new Database();
$user = new User($db->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    $loggedInUser = $user->login($email, $password);
    if ($loggedInUser) {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['user_name'] = $loggedInUser['name'];
        $_SESSION['user_email'] = $loggedInUser['email'];
        $_SESSION['user_role'] = $loggedInUser['role'];
        // echo "Login successful! Welcome, " . htmlspecialchars($loggedInUser['name']) . ".";

        switch ($loggedInUser['role']) {
            case 'student':
                header("Location: ../../views/student/dashboard.php");
                break;
            case 'teacher':
                header("Location: ../../views/teacher/dashboard.php");
                break;
            case 'admin':
                header("Location: ../../views/admin/dashboard.php");
                break;
            default:
                header("Location: ../../public/index.php");
                break;
        }
    } else {
        echo "Invalid email or password.";
    }
}

$title = "Login";
include __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <form method="POST">
        <div class="mb-2">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email..." required autofocus>
        </div>
        <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password..." required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</main>


<?php include __DIR__ . '/../../includes/footer.php'; ?>