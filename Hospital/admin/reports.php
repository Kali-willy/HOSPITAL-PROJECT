<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to access the admin area', 'warning');
}

// Check if user is admin
if (!isAdmin()) {
    redirect('../user/dashboard.php', 'You do not have permission to access the admin area', 'danger');
}

// Process report type and date range
$report_type = isset($_GET['report_type']) ? sanitize($_GET['report_type']) : 'appointments';
$start_date = isset($_GET['start_date']) ? sanitize($_GET['start_date']) : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? sanitize($_GET['end_date']) : date('Y-m-d');

// Get report data
$conn = getConnection();

// Report data based on type
$report_data = [];
$chart_labels = [];
$chart_values = [];

if ($report_type == 'appointments') {
    // Appointments by date
    $stmt = $conn->prepare("SELECT appointment_date, COUNT(*) as count 
                          FROM appointments 
                          WHERE appointment_date BETWEEN ? AND ? 
                          GROUP BY appointment_date 
                          ORDER BY appointment_date");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $report_data[] = $row;
        $chart_labels[] = date('M d', strtotime($row['appointment_date']));
        $chart_values[] = $row['count'];
    }
    
    // Get total appointments
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE appointment_date BETWEEN ? AND ?");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_appointments = $result->fetch_assoc()['total'];
    
    // Get appointments by status
    $stmt = $conn->prepare("SELECT status, COUNT(*) as count FROM appointments WHERE appointment_date BETWEEN ? AND ? GROUP BY status");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $status_data = [];
    while ($row = $result->fetch_assoc()) {
        $status_data[$row['status']] = $row['count'];
    }
    
    // Calculate percentages
    $pending_percent = isset($status_data['pending']) ? round(($status_data['pending'] / $total_appointments) * 100) : 0;
    $confirmed_percent = isset($status_data['confirmed']) ? round(($status_data['confirmed'] / $total_appointments) * 100) : 0;
    $completed_percent = isset($status_data['completed']) ? round(($status_data['completed'] / $total_appointments) * 100) : 0;
    $cancelled_percent = isset($status_data['cancelled']) ? round(($status_data['cancelled'] / $total_appointments) * 100) : 0;
    
} elseif ($report_type == 'patients') {
    // New patients by date
    $stmt = $conn->prepare("SELECT DATE(created_at) as registration_date, COUNT(*) as count 
                          FROM users 
                          WHERE role = 'patient' AND DATE(created_at) BETWEEN ? AND ? 
                          GROUP BY DATE(created_at) 
                          ORDER BY DATE(created_at)");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $report_data[] = $row;
        $chart_labels[] = date('M d', strtotime($row['registration_date']));
        $chart_values[] = $row['count'];
    }
    
    // Get total new patients
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'patient' AND DATE(created_at) BETWEEN ? AND ?");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_new_patients = $result->fetch_assoc()['total'];
    
} elseif ($report_type == 'departments') {
    // Appointments by department
    $stmt = $conn->prepare("SELECT department, COUNT(*) as count 
                          FROM appointments 
                          WHERE appointment_date BETWEEN ? AND ? 
                          GROUP BY department 
                          ORDER BY count DESC");
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $report_data[] = $row;
        $chart_labels[] = $row['department'];
        $chart_values[] = $row['count'];
    }
}

$conn->close();

$page_title = "Reports";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Reports</h1>
        <p class="lead">Generate and view reports for the hospital management system.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="reports.php" method="get" class="row g-3">
                    <div class="col-md-3">
                        <label for="report_type" class="form-label">Report Type</label>
                        <select class="form-select" id="report_type" name="report_type">
                            <option value="appointments" <?php echo $report_type == 'appointments' ? 'selected' : ''; ?>>Appointments</option>
                            <option value="patients" <?php echo $report_type == 'patients' ? 'selected' : ''; ?>>New Patients</option>
                            <option value="departments" <?php echo $report_type == 'departments' ? 'selected' : ''; ?>>Departments</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <?php 
                    if ($report_type == 'appointments') {
                        echo 'Appointment Report';
                    } elseif ($report_type == 'patients') {
                        echo 'New Patients Report';
                    } elseif ($report_type == 'departments') {
                        echo 'Department Report';
                    }
                    ?> 
                    (<?php echo date('M d, Y', strtotime($start_date)); ?> - <?php echo date('M d, Y', strtotime($end_date)); ?>)
                </span>
                <div class="btn-group" role="group">
                    <a href="export-report.php?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-file-export me-1"></i>Export
                    </a>
                    <a href="print-report.php?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="fas fa-print me-1"></i>Print
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (count($report_data) > 0): ?>
                    <!-- Summary Cards -->
                    <?php if ($report_type == 'appointments'): ?>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total Appointments</h5>
                                        <h2 class="mb-0"><?php echo $total_appointments; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Status Distribution</h5>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="progress mb-2" style="height: 20px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pending_percent; ?>%" aria-valuenow="<?php echo $pending_percent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pending_percent; ?>%</div>
                                                </div>
                                                <p class="small mb-0">Pending: <?php echo isset($status_data['pending']) ? $status_data['pending'] : 0; ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="progress mb-2" style="height: 20px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $confirmed_percent; ?>%" aria-valuenow="<?php echo $confirmed_percent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $confirmed_percent; ?>%</div>
                                                </div>
                                                <p class="small mb-0">Confirmed: <?php echo isset($status_data['confirmed']) ? $status_data['confirmed'] : 0; ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="progress mb-2" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $completed_percent; ?>%" aria-valuenow="<?php echo $completed_percent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $completed_percent; ?>%</div>
                                                </div>
                                                <p class="small mb-0">Completed: <?php echo isset($status_data['completed']) ? $status_data['completed'] : 0; ?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="progress mb-2" style="height: 20px;">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $cancelled_percent; ?>%" aria-valuenow="<?php echo $cancelled_percent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $cancelled_percent; ?>%</div>
                                                </div>
                                                <p class="small mb-0">Cancelled: <?php echo isset($status_data['cancelled']) ? $status_data['cancelled'] : 0; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($report_type == 'patients'): ?>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total New Patients</h5>
                                        <h2 class="mb-0"><?php echo $total_new_patients; ?></h2>
                                        <p class="text-muted">From <?php echo date('M d, Y', strtotime($start_date)); ?> to <?php echo date('M d, Y', strtotime($end_date)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Chart -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <canvas id="reportChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <?php if ($report_type == 'appointments'): ?>
                                        <th>Date</th>
                                        <th>Number of Appointments</th>
                                    <?php elseif ($report_type == 'patients'): ?>
                                        <th>Date</th>
                                        <th>Number of New Patients</th>
                                    <?php elseif ($report_type == 'departments'): ?>
                                        <th>Department</th>
                                        <th>Number of Appointments</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($report_data as $row): ?>
                                    <tr>
                                        <?php if ($report_type == 'appointments'): ?>
                                            <td><?php echo date('M d, Y', strtotime($row['appointment_date'])); ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                        <?php elseif ($report_type == 'patients'): ?>
                                            <td><?php echo date('M d, Y', strtotime($row['registration_date'])); ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                        <?php elseif ($report_type == 'departments'): ?>
                                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No data available for the selected report type and date range.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (count($report_data) > 0): ?>
    // Initialize chart
    const ctx = document.getElementById('reportChart').getContext('2d');
    const chartType = '<?php echo $report_type == 'departments' ? 'pie' : 'bar'; ?>';
    
    const chartData = {
        labels: <?php echo json_encode($chart_labels); ?>,
        datasets: [{
            label: '<?php 
                if ($report_type == 'appointments') {
                    echo 'Appointments';
                } elseif ($report_type == 'patients') {
                    echo 'New Patients';
                } elseif ($report_type == 'departments') {
                    echo 'Appointments by Department';
                }
            ?>',
            data: <?php echo json_encode($chart_values); ?>,
            backgroundColor: <?php echo $report_type == 'departments' ? 
                "['#0d6efd', '#fd7e14', '#20c997', '#dc3545', '#6f42c1', '#0dcaf0', '#198754', '#6c757d']" : 
                "'rgba(13, 110, 253, 0.7)'"; ?>,
            borderColor: <?php echo $report_type == 'departments' ? 
                "['#0d6efd', '#fd7e14', '#20c997', '#dc3545', '#6f42c1', '#0dcaf0', '#198754', '#6c757d']" : 
                "'rgba(13, 110, 253, 1)'"; ?>,
            borderWidth: 1
        }]
    };
    
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: <?php echo $report_type == 'departments' ? 'true' : 'false'; ?>
            },
            title: {
                display: true,
                text: '<?php 
                    if ($report_type == 'appointments') {
                        echo 'Appointments by Date';
                    } elseif ($report_type == 'patients') {
                        echo 'New Patient Registrations by Date';
                    } elseif ($report_type == 'departments') {
                        echo 'Appointments by Department';
                    }
                ?>'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                },
                display: <?php echo $report_type == 'departments' ? 'false' : 'true'; ?>
            }
        }
    };
    
    new Chart(ctx, {
        type: chartType,
        data: chartData,
        options: chartOptions
    });
    <?php endif; ?>
    
    // Validate date range
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    endDateInput.addEventListener('change', function() {
        if (startDateInput.value > endDateInput.value) {
            alert('End date cannot be earlier than start date');
            endDateInput.value = startDateInput.value;
        }
    });
    
    startDateInput.addEventListener('change', function() {
        if (startDateInput.value > endDateInput.value) {
            alert('Start date cannot be later than end date');
            startDateInput.value = endDateInput.value;
        }
    });
});
</script>

<?php include_once '../includes/footer.php'; ?> 