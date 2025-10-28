<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>  
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-navbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background: #2c3e50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ecf0f1;
            text-decoration: none;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #3498db;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-name {
            font-weight: 500;
            color: #ecf0f1;
        }
</style>

<nav class="top-navbar">
    <a href="#" class="navbar-brand">
        <i class="bi bi-mortarboard-fill"></i> Student Management System
    </a>
        
    <div class="user-profile">
        <span class="user-name">
            <?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?>
        </span>
        <div class="user-avatar">
            <?= isset($_SESSION['user_name']) ? strtoupper(substr(htmlspecialchars($_SESSION['user_name']), 0, 2)) : 'NA'; ?>
        </div>
    </div>
</nav>