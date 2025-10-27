<style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            margin-top: 60px;
            left: 0;
            width: 260px;
            height: 100vh;
            background: #2c3e50;
            padding: 20px 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            margin: 5px 15px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 15px 15px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .sidebar-link:hover {
            background: #34495e;
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: #3498db;
            color: #fff;
        }

        .sidebar-link i {
            margin-right: 15px;
            font-size: 1.2rem;
        }
</style> 
   <aside class="sidebar">
        <?php if ($_SESSION['user_role'] === 'admin'): ?>

            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="manage_students.php" class="sidebar-link">
                        <i class="bi bi-person-fill"></i>
                        <span>Manage Students</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="manage_teachers.php" class="sidebar-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Manage Teachers</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="manage_courses.php" class="sidebar-link">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>Manage Courses</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="manage_grades.php" class="sidebar-link">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Manage Grades</span>
                    </a>
                </li>
            </ul>

        <?php elseif ($_SESSION['user_role'] === 'teacher'): ?>

            <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="dashboard.php" class="sidebar-link">
                            <i class="bi bi-house-door-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="students.php" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Students</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="courses.php" class="sidebar-link">
                            <i class="bi bi-book-fill"></i>
                            <span>Courses</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a href="grades.php" class="sidebar-link">
                            <i class="bi bi-graph-up"></i>
                            <span>Grades</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a href="profile.php" class="sidebar-link">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                </ul>

        <?php elseif ($_SESSION['user_role'] === 'student'): ?>

            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="courses.php" class="sidebar-link">
                        <i class="bi bi-book-fill"></i>
                        <span>Courses</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="grades.php" class="sidebar-link">
                        <i class="bi bi-graph-up"></i>
                        <span>Grades</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="profile.php" class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </aside>
<script>
    // Highlight the active link in the sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const sidebarLinks = document.querySelectorAll('.sidebar-link');

        sidebarLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            if (linkPage === currentPage) {
                link.classList.add('active');
            }
        });
    });
</script>