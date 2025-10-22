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
            background: #fff;
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
            color: #2c3e50;
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
            color: #2c3e50;
        }
    </style>
    <nav class="top-navbar">
        <a href="#" class="navbar-brand">
            <i class="bi bi-mortarboard-fill"></i> Student Dashboard
        </a>
        
        <div class="user-profile">
            <span class="user-name">John Smith</span>
            <div class="user-avatar">JS</div>
        </div>
    </nav>