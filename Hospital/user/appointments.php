<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to view your appointments', 'warning');
}

// Check if user is patient (not admin)
if (isAdmin()) {
    redirect('../admin/appointments.php', 'Admin users should use the admin appointments page', 'info');
}

// Get user appointments
$user_id = $_SESSION['user_id'];
$appointments = getUserAppointments($user_id);

// Filter appointments by status if requested
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
if (!empty($status_filter) && in_array($status_filter, ['pending', 'confirmed', 'cancelled', 'completed'])) {
    $appointments = array_filter($appointments, function($appointment) use ($status_filter) {
        return $appointment['status'] == $status_filter;
    });
}

$page_title = "My Appointments";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">My Appointments</h1>
        <p class="lead">View and manage all your appointments.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="book-appointment.php" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Book New Appointment
                        </a>
                    </div>
                    <div>
                        <div class="btn-group" role="group">
                            <a href="appointments.php" class="btn btn-outline-primary <?php echo empty($status_filter) ? 'active' : ''; ?>">All</a>
                            <a href="appointments.php?status=pending" class="btn btn-outline-warning <?php echo $status_filter == 'pending' ? 'active' : ''; ?>">Pending</a>
                            <a href="appointments.php?status=confirmed" class="btn btn-outline-primary <?php echo $status_filter == 'confirmed' ? 'active' : ''; ?>">Confirmed</a>
                            <a href="appointments.php?status=completed" class="btn btn-outline-success <?php echo $status_filter == 'completed' ? 'active' : ''; ?>">Completed</a>
                            <a href="appointments.php?status=cancelled" class="btn btn-outline-danger <?php echo $status_filter == 'cancelled' ? 'active' : ''; ?>">Cancelled</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span>
                    <?php 
                    echo empty($status_filter) ? 'All Appointments' : ucfirst($status_filter) . ' Appointments'; 
                    echo ' (' . count($appointments) . ')';
                    ?>
                </span>
            </div>
            <div class="card-body">
                <?php if (count($appointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Booked On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
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
                                        <td><?php echo date('M d, Y', strtotime($appointment['created_at'])); ?></td>
                                        <td>
                                            <a href="view-appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($appointment['status'] == 'pending' || $appointment['status'] == 'confirmed'): ?>
                                                <?php if (strtotime($appointment['appointment_date']) > strtotime(date('Y-m-d')) || 
                                                          (strtotime($appointment['appointment_date']) == strtotime(date('Y-m-d')) && 
                                                           strtotime($appointment['appointment_time']) > strtotime(date('H:i:s')))): ?>
                                                    <a href="cancel-appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')" data-bs-toggle="tooltip" title="Cancel">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <?php 
                        echo empty($status_filter) ? 
                            "You don't have any appointments yet." : 
                            "You don't have any " . $status_filter . " appointments."; 
                        ?>
                        <a href="book-appointment.php" class="alert-link">Book an appointment now</a>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 