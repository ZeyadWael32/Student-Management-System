<?php 
require_once __DIR__ . '/../../config/init.php';
require_once __DIR__ . '/../../classes/dashboard.php';

require_login();
required_role(["admin"]);

$db = new Database();
$dashboard = new AdminDashboard($db->conn);

$reportData = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['report_type']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $report_type = $_GET['report_type'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        $reportData = $dashboard->generateReport($report_type, $start_date, $end_date);
    }
}

$title = "Generated Report";
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../../includes/navbar.php';
include_once __DIR__ . '/../../includes/sidebar.php';
?>

<main class="container">
    <h2 class="mt-3"><?= htmlspecialchars(ucfirst($report_type)) ?> Report</h2>
    <p>From <?= htmlspecialchars($start_date) ?> to <?= htmlspecialchars($end_date) ?></p>

    <?php if (!empty($reportData)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <?php foreach (array_keys($reportData[0]) as $column): ?>
                        <th><?= htmlspecialchars((str_replace('_', ' ', $column))) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportData as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?= htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" onclick="window.print();">Print Report</button>
    <?php else: ?>
        <p class="text-muted">No data available for the selected criteria.</p>
    <?php endif; ?>
</main>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>