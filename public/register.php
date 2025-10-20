<?php
require_once __DIR__ . '/../classes/user.php';
require_once __DIR__ . '/../config/database.php';

$db = new Database();
$user = new User($db->conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($user->existsByEmail($email)) {
        echo "Email already registered.";
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        if ($user->register($name, $password, $email, $role)) {
            $loggedInUser = $user->login($email, $password);
            if ($loggedInUser) {
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['user_name'] = $loggedInUser['name'];
                $_SESSION['user_email'] = $loggedInUser['email'];
                $_SESSION['user_role'] = $loggedInUser['role'];
            }
            //echo "Registration successful!";

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
?>

<form method="POST">
    <input type="text" name="name" placeholder="Enter your name..." required>
    <input type="email" name="email" placeholder="Enter your email..." required>
    <input type="password" name="password" placeholder="Enter your password..." required>
    <select name="role" required>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>
    <button type="submit">Register</button>
</form>