<?php
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/dashboard.php';

require_login();
required_role(["admin"]);

$db = new Database();
$dashboard = new AdminDashboard($db->conn);
$stats = $dashboard->getStats();

$studentCount = $stats['studentCount'];
$courseCount = $stats['courseCount'];
$averageGrade = $stats['averageGrade'];
$enrollmentCount = $stats['enrollmentCount'];

$studentGrowth = $stats['studentGrowth'];
$courseGrowth = $stats['courseGrowth'];
$gradeChange = $stats['gradeChange'];
$enrollmentGrowth = $stats['enrollmentGrowth'];

$title = "Dashboard";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>
<style>
            .stats-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .stats-title {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stats-change {
            font-size: 0.85rem;
        }

        /* Chart Cards */
        .chart-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 100%;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Recent Activity */
        .activity-item {
            padding: 15px;
            border-left: 3px solid #3498db;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        /* Quick Actions */
        .quick-action-btn {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: 2px dashed #cbd5e0;
            background: white;
            color: #2c3e50;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
        }

        .quick-action-btn:hover {
            border-color: #3498db;
            background: #e3f2fd;
            color: #3498db;
        }

        .quick-action-btn i {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 8px;
        }

        /* Upcoming Classes */
        .class-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid #3498db;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .class-time {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .class-name {
            font-weight: 600;
            color: #2c3e50;
        }
</style>
<main class="container">
    <div class="mt-4">

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Students -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #e3f2fd; color: #2196f3;">
                <i class="bi bi-people-fill"></i>
                </div>
                <div class="stats-title">Total Students</div>
                <div class="stats-value"><?= number_format($studentCount ?? 0) ?></div>
                <div class="stats-change text-success">
                <i class="bi bi-arrow-<?= ($studentGrowth ?? 0) >= 0 ? 'up' : 'down' ?>"></i>
                <?= $studentGrowth ?? '0' ?>% since last month
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #e3f2fd; color: #2196f3;">
                <i class="bi bi-book-fill"></i>
                </div>
                <div class="stats-title">Total Courses</div>
                <div class="stats-value"><?= number_format($courseCount ?? 0) ?></div>
                <div class="stats-change text-success">
                <i class="bi bi-arrow-<?= ($courseGrowth ?? 0) >= 0 ? 'up' : 'down' ?>"></i>
                <?= $courseGrowth ?? '0' ?>% since last month
                </div>
            </div>
        </div>

        <!-- Average Grade -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #e3f2fd; color: #2196f3;">
                <i class="bi bi-star-fill"></i>
                </div>
                <div class="stats-title">Average Grade</div>
                <div class="stats-value"><?= $averageGrade ?? '-' ?></div>
                <div class="stats-change text-success">
                <i class="bi bi-arrow-<?= ($gradeChange ?? 0) >= 0 ? 'up' : 'down' ?>"></i>
                <?= $gradeChange ?? '0' ?>% since last month
                </div>
            </div>
        </div>

        <!-- Active Enrollments -->
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: #e3f2fd; color: #2196f3;">
                <i class="bi bi-person-fill"></i>
                </div>
                <div class="stats-title">Active Enrollments</div>
                <div class="stats-value"><?= number_format($enrollmentCount ?? 0) ?></div>
                <div class="stats-change text-success">
                <i class="bi bi-arrow-<?= ($enrollmentGrowth ?? 0) >= 0 ? 'up' : 'down' ?>"></i>
                <?= $enrollmentGrowth ?? '0' ?>% since last month
                </div>
            </div>
        </div>
    </div>
    </div>

        <!-- Charts and Activity -->
    <div class="row g-4 mb-4">
        <!-- Enrollment Chart -->
        <div class="col-md-8">
            <div class="chart-card">
                <h3 class="chart-title">Student Enrollment Overview</h3>
                <canvas id="enrollmentChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

         <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="chart-card">
                <h3 class="chart-title">Quick Actions</h3>
                <div class="d-grid gap-3">
                    <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="bi bi-person-plus-fill"></i>
                        Add New Student
                    </button>
                    <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                        <i class="bi bi-file-earmark-text"></i>
                        Generate Report
                    </button>
                    <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                        <i class="bi bi-calendar-check"></i>
                        Mark Attendance
                    </button>
                    <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#announcementModal">
                        <i class="bi bi-envelope"></i>
                        Send Announcement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Upcoming Classes -->
     <div class="row g-4">
        <!-- Recent Activites -->
        <div class="col-md-6">
            <div class="chart-card">
                <h3 class="chart-title">Recent Activity</h3>

                <?php if (!empty($recentActivities)): ?>
                    <?php foreach ($recentActivities as $activity): ?>
                        <div class="activity-item">
                            <div><strong><?= htmlspecialchars($activity['title']) ?></strong></div>
                            <div><?= htmlspecialchars($activity['description']) ?></div>
                            <div class="activity-time">
                                <?= date('M d, Y • h:i A', strtotime($activity['created_at'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No recent activity.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Classes -->
        <div class="col-md-6">
            <div class="chart-card">
                <h3 class="chart-title">Today's Schedule</h3>

                <?php if (!empty($todayClasses)): ?>
                    <?php foreach ($todayClasses as $class): ?>
                        <div class="class-item">
                            <div class="class-time"><?= htmlspecialchars($class['time']) ?></div>
                            <div class="class-name"><?= htmlspecialchars($class['name']) ?></div>
                            <div class="text-muted small">
                                <?= htmlspecialchars($class['location']) ?> • <?= htmlspecialchars($class['teacher']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-muted text-center">No classes scheduled for today.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($enrollmentChartData['months'] ?? []) ?>,
            datasets: [{
                label: 'Enrollments',
                data: <?= json_encode($enrollmentChartData['counts'] ?? []) ?>,
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: 'rgba(41, 128, 185, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
