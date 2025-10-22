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
            top: 1;
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
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-book-fill"></i>
                    <span>Courses</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Grades</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </aside>