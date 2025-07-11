<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to access your profile', 'warning');
}

// Get user data
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $error = '';
    $success = '';
    
    // Validate inputs
    if (empty($name)) {
        $error = "Name is required";
    } else {
        $conn = getConnection();
        
        // Check if password change is requested
        if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
            // Validate current password
            if (!password_verify($current_password, $user['password'])) {
                $error = "Current password is incorrect";
            } elseif (empty($new_password) || empty($confirm_password)) {
                $error = "New password and confirmation are required";
            } elseif ($new_password !== $confirm_password) {
                $error = "New passwords do not match";
            } elseif (strlen($new_password) < 6) {
                $error = "New password must be at least 6 characters";
            } else {
                // Hash new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update user with new password
                $stmt = $conn->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
                $stmt->bind_param("ssi", $name, $hashed_password, $user_id);
                
                if ($stmt->execute()) {
                    $success = "Profile updated successfully with new password";
                    $_SESSION['user_name'] = $name;
                } else {
                    $error = "Failed to update profile: " . $stmt->error;
                }
            }
        } else {
            // Update user without changing password
            $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
            $stmt->bind_param("si", $name, $user_id);
            
            if ($stmt->execute()) {
                $success = "Profile updated successfully";
                $_SESSION['user_name'] = $name;
            } else {
                $error = "Failed to update profile: " . $stmt->error;
            }
        }
        
        $conn->close();
    }
    
    // Refresh user data after update
    $user = getUserById($user_id);
}

$page_title = "My Profile";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">My Profile</h1>
        <p class="lead">View and update your profile information.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="../assets/images/man-walk.jpeg" alt="Profile Picture" class="profile-img">
                </div>
                <h4 class="mb-1"><?php echo htmlspecialchars($user['name']); ?></h4>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                <p>
                    <span class="badge bg-primary">Patient</span>
                </p>
                <p class="text-muted">
                    <small>Member since: <?php echo date('F d, Y', strtotime($user['created_at'])); ?></small>
                </p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <span>Account Actions</span>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="appointments.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i> My Appointments
                    </a>
                    <a href="notifications.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-bell me-2"></i> Notifications
                    </a>
                    <a href="#" class="list-group-item list-group-item-action text-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt me-2"></i> Delete Account
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span>Edit Profile</span>
            </div>
            <div class="card-body">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (isset($success) && !empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form action="profile.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        <div class="form-text">Email address cannot be changed.</div>
                    </div>
                    
                    <hr>
                    <h5>Change Password</h5>
                    <p class="text-muted">Leave blank if you don't want to change your password.</p>
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <div class="form-text">Password must be at least 6 characters long.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <p>All your appointments and personal information will be permanently removed from our system.</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> This action is irreversible!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="delete-account.php" class="btn btn-danger">Delete My Account</a>
            </div>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?> 