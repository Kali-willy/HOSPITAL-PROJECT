<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to access the dashboard', 'warning');
}

// Check if user is patient (not admin)
if (isAdmin()) {
    redirect('../admin/dashboard.php', 'Admin users should use the admin dashboard', 'info');
}

// Get user data
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);

// Get user appointments
$appointments = getUserAppointments($user_id);

// Get upcoming appointments (filter for future dates)
$upcoming_appointments = array_filter($appointments, function($appointment) {
    return $appointment['appointment_date'] >= date('Y-m-d') || 
           ($appointment['appointment_date'] == date('Y-m-d') && $appointment['appointment_time'] > date('H:i:s'));
});

// Get notifications
$notifications = getUserNotifications($user_id);
$unread_notifications = array_filter($notifications, function($notification) {
    return !$notification['is_read'];
});

$page_title = "Dashboard";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Patient Dashboard</h1>
        <p class="lead">Welcome back, <?php echo $_SESSION['user_name']; ?>!</p>
    </div>
</div>

<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-4">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-calendar-check"></i>
                <div class="stats-number"><?php echo count($appointments); ?></div>
                <div class="stats-text">Total Appointments</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-clock"></i>
                <div class="stats-number"><?php echo count($upcoming_appointments); ?></div>
                <div class="stats-text">Upcoming Appointments</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card">
            <div class="card-body">
                <i class="fas fa-bell"></i>
                <div class="stats-number"><?php echo count($unread_notifications); ?></div>
                <div class="stats-text">Unread Notifications</div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Upcoming Appointments -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Upcoming Appointments</span>
                <a href="book-appointment.php" class="btn btn-primary btn-sm">Book New Appointment</a>
            </div>
            <div class="card-body">
                <?php if (count($upcoming_appointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($upcoming_appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['department']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></td>
                                        <td><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></td>
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
                                            <?php if ($appointment['status'] == 'pending'): ?>
                                                <a href="cancel-appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        You don't have any upcoming appointments. 
                        <a href="book-appointment.php" class="alert-link">Book an appointment now</a>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Notifications -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span>Recent Notifications</span>
            </div>
            <div class="card-body">
                <?php if (count($notifications) > 0): ?>
                    <div class="list-group">
                        <?php foreach (array_slice($notifications, 0, 5) as $notification): ?>
                            <div class="list-group-item list-group-item-action <?php echo $notification['is_read'] ? '' : 'bg-light'; ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo substr($notification['message'], 0, 30) . (strlen($notification['message']) > 30 ? '...' : ''); ?></h6>
                                    <small><?php echo date('M d', strtotime($notification['created_at'])); ?></small>
                                </div>
                                <p class="mb-1"><?php echo htmlspecialchars($notification['message']); ?></p>
                                <?php if (!$notification['is_read']): ?>
                                    <a href="mark-notification.php?id=<?php echo $notification['id']; ?>" class="btn btn-sm btn-link p-0">Mark as read</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($notifications) > 5): ?>
                        <div class="text-center mt-3">
                            <a href="notifications.php" class="btn btn-sm btn-outline-primary">View All Notifications</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">You don't have any notifications.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 