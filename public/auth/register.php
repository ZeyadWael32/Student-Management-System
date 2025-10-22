<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/user.php';

$db = new Database();
$user = new User($db->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match";
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
    } elseif ($user->existsByEmail($email)) {
        echo "Email already registered.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        if ($user->register($name, $password, $email, $role)) {
            $loggedInUser = $user->login($email, $password); // Auto-login
            if ($loggedInUser) {
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['user_name'] = $loggedInUser['name'];
                $_SESSION['user_email'] = $loggedInUser['email'];
                $_SESSION['user_role'] = $loggedInUser['role'];
            }
            // echo "Registration successful!";

            switch ($loggedInUser['role']) {
                case 'student':
                    header("Location: ../views/student/dashboard.php");
                    break;
                case 'teacher':
                    header("Location: ../views/teacher/dashboard.php");
                    break;
                case 'admin':
                    header("Location: ../views/admin/dashboard.php");
                    break;
                default:
                    header("Location: ../public/index.php");
                    break;
            }

        } else {
            echo "Registration failed. Please try again.";
        }
    }
}

$title = "Register";
include __DIR__ . '/../../includes/header.php';
?>

<main class="container">
    <form method="POST">
        <div class="mb-2">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name..." required autofocus>
        </div>
        <div class="mb-2">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email..." required>
        </div>
        <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password..." required>
            <div class="form-text">Password must be at least 6 characters long.</div>
        </div>
        <div class="mb-2">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password..." required>
        </div>
        <div class="mb-2">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>