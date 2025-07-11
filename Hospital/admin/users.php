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

// Process search
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Get users
$conn = getConnection();

if (!empty($search)) {
    // Search users
    $stmt = $conn->prepare("SELECT * FROM users WHERE (name LIKE ? OR email LIKE ?) ORDER BY created_at DESC");
    $search_param = "%$search%";
    $stmt->bind_param("ss", $search_param, $search_param);
} else {
    // Get all users
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();

$page_title = "Manage Users";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Manage Users</h1>
        <p class="lead">View and manage all users in the system.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="add-user.php" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Add New User
                        </a>
                    </div>
                    <div>
                        <form action="users.php" method="get" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or email" value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                            <?php if (!empty($search)): ?>
                                <a href="users.php" class="btn btn-outline-secondary ms-2">Clear</a>
                            <?php endif; ?>
                        </form>
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
                <span>Users (<?php echo count($users); ?>)</span>
            </div>
            <div class="card-body">
                <?php if (count($users) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $user['role'] == 'admin' ? 'danger' : 'primary'; ?>">
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($user['id'] != $_SESSION['user_id'] && $user['role'] != 'admin'): ?>
                                                <a href="delete-user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-bs-toggle="tooltip" title="Delete User">
                                                    <i class="fas fa-trash"></i>
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
                        <?php echo !empty($search) ? "No users found matching '$search'." : "No users found."; ?>
                    </div>
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
    
    // Confirm delete
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this user? This will also delete all their appointments and data.')) {
                event.preventDefault();
            }
        });
    });
});
</script>

<?php include_once '../includes/footer.php'; ?> 