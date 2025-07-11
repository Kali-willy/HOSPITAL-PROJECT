<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to access the admin dashboard', 'warning');
}

// Check if user is admin
if (!isAdmin()) {
    redirect('../user/dashboard.php', 'You do not have permission to access the admin area', 'danger');
}

// Get statistics
$conn = getConnection();

// Total users
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'patient'");
$stmt->execute();
$result = $stmt->get_result();
$total_patients = $result->fetch_assoc()['total'];

// Total appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments");
$stmt->execute();
$result = $stmt->get_result();
$total_appointments = $result->fetch_assoc()['total'];

// Pending appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();
$pending_appointments = $result->fetch_assoc()['total'];

// Confirmed appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = 'confirmed'");
$stmt->execute();
$result = $stmt->get_result();
$confirmed_appointments = $result->fetch_assoc()['total'];

// Completed appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = 'completed'");
$stmt->execute();
$result = $stmt->get_result();
$completed_appointments = $result->fetch_assoc()['total'];

// Cancelled appointments
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = 'cancelled'");
$stmt->execute();
$result = $stmt->get_result();
$cancelled_appointments = $result->fetch_assoc()['total'];

// Recent appointments
$stmt = $conn->prepare("SELECT a.*, u.name as patient_name, u.email 
                       FROM appointments a 
                       JOIN users u ON a.user_id = u.id 
                       ORDER BY a.created_at DESC LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();
$recent_appointments = [];
while ($row = $result->fetch_assoc()) {
    $recent_appointments[] = $row;
}

// Recent users
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'patient' ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();
$recent_users = [];
while ($row = $result->fetch_assoc()) {
    $recent_users[] = $row;
}

$conn->close();

$page_title = "Admin Dashboard";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Admin Dashboard</h1>
        <p class="lead">Welcome back, <?php echo $_SESSION['user_name']; ?>!</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-users"></i>
                <div class="stats-number"><?php echo $total_patients; ?></div>
                <div class="stats-text">Total Patients</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-calendar-check"></i>
                <div class="stats-number"><?php echo $total_appointments; ?></div>
                <div class="stats-text">Total Appointments</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-clock"></i>
                <div class="stats-number"><?php echo $pending_appointments; ?></div>
                <div class="stats-text">Pending Appointments</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-check-circle"></i>
                <div class="stats-number"><?php echo $confirmed_appointments; ?></div>
                <div class="stats-text">Confirmed Appointments</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Data -->
<div class="row mt-4">
    <!-- Appointment Status Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span>Appointment Status</span>
            </div>
            <div class="card-body">
                <canvas id="appointmentChart" 
                        data-pending="<?php echo $pending_appointments; ?>" 
                        data-confirmed="<?php echo $confirmed_appointments; ?>" 
                        data-completed="<?php echo $completed_appointments; ?>" 
                        data-cancelled="<?php echo $cancelled_appointments; ?>"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Appointments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Appointments</span>
                <a href="appointments.php" class="btn btn-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                <?php if (count($recent_appointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $appointment['status'] == 'pending' ? 'warning' : 
                                                    ($appointment['status'] == 'confirmed' ? 'primary' : 
                                                    ($appointment['status'] == 'completed' ? 'success' : 'danger')); 
                                            ?>">
                                                <?php echo ucfirst($appointment['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="view-appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No appointments found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Users -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Patients</span>
                <a href="users.php" class="btn btn-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                <?php if (count($recent_users) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No patients found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span>Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="appointments.php?status=pending" class="btn btn-outline-warning">
                                <i class="fas fa-clock me-2"></i>Pending Appointments
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="users.php" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="reports.php" class="btn btn-outline-success">
                                <i class="fas fa-chart-bar me-2"></i>Generate Reports
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="settings.php" class="btn btn-outline-secondary">
                                <i class="fas fa-cog me-2"></i>System Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="card mt-4">
            <div class="card-header">
                <span>System Information</span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP Version
                        <span class="badge bg-primary"><?php echo phpversion(); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        MySQL Version
                        <span class="badge bg-primary"><?php 
                            $conn = getConnection();
                            echo $conn->server_info;
                            $conn->close();
                        ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Server Time
                        <span class="badge bg-primary"><?php echo date('Y-m-d H:i:s'); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include_once '../includes/footer.php'; ?> 