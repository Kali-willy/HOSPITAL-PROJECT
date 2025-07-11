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

// Process filters
$status_filter = isset($_GET['status']) ? sanitize($_GET['status']) : '';
$date_filter = isset($_GET['date']) ? sanitize($_GET['date']) : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Get appointments
$conn = getConnection();

// Build query based on filters
$query = "SELECT a.*, u.name as patient_name, u.email 
          FROM appointments a 
          JOIN users u ON a.user_id = u.id 
          WHERE 1=1";
$params = [];
$types = "";

if (!empty($status_filter) && in_array($status_filter, ['pending', 'confirmed', 'cancelled', 'completed'])) {
    $query .= " AND a.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($date_filter)) {
    $query .= " AND a.appointment_date = ?";
    $params[] = $date_filter;
    $types .= "s";
}

if (!empty($search)) {
    $query .= " AND (u.name LIKE ? OR u.email LIKE ? OR a.doctor_name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$query .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$conn->close();

$page_title = "Manage Appointments";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Manage Appointments</h1>
        <p class="lead">View and manage all appointments in the system.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="appointments.php" method="get" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $status_filter == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $date_filter; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by patient, email or doctor" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <?php if (!empty($status_filter) || !empty($date_filter) || !empty($search)): ?>
                                <a href="appointments.php" class="btn btn-outline-secondary">Clear</a>
                            <?php endif; ?>
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
                <span>Appointments (<?php echo count($appointments); ?>)</span>
                <div class="btn-group" role="group">
                    <a href="export-appointments.php" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-file-export me-1"></i>Export
                    </a>
                    <a href="print-appointments.php" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="fas fa-print me-1"></i>Print
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (count($appointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?php echo $appointment['id']; ?></td>
                                        <td>
                                            <a href="view-user.php?id=<?php echo $appointment['user_id']; ?>" data-bs-toggle="tooltip" title="View Patient">
                                                <?php echo htmlspecialchars($appointment['patient_name']); ?>
                                            </a>
                                        </td>
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
                                            <a href="edit-appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit Appointment">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Status
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if ($appointment['status'] != 'confirmed'): ?>
                                                        <li><a class="dropdown-item" href="update-status.php?id=<?php echo $appointment['id']; ?>&status=confirmed">Confirm</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($appointment['status'] != 'completed'): ?>
                                                        <li><a class="dropdown-item" href="update-status.php?id=<?php echo $appointment['id']; ?>&status=completed">Complete</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($appointment['status'] != 'cancelled'): ?>
                                                        <li><a class="dropdown-item" href="update-status.php?id=<?php echo $appointment['id']; ?>&status=cancelled">Cancel</a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No appointments found matching your criteria.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include_once '../includes/footer.php'; ?> 