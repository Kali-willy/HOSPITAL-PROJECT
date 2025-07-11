<?php
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(isAdmin() ? 'admin/dashboard.php' : 'user/dashboard.php');
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $error = '';
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        $conn = getConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'patient')");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                // Get the new user ID
                $user_id = $stmt->insert_id;
                
                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'patient';
                
                // Add welcome notification
                addNotification($user_id, "Welcome to Hospital Management System! You can now book appointments with our doctors.");
                
                redirect('user/dashboard.php', 'Registration successful! Welcome to Hospital Management System.', 'success');
            } else {
                $error = "Registration failed: " . $stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

$page_title = "Register";
include_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="auth-form">
                    <h2 class="form-title text-center mb-4">Create an Account</h2>
                    
                    <?php if (isset($error) && !empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form action="register.php" method="post" id="registrationForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">Password must be at least 6 characters long.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="terms.php">Terms and Conditions</a></label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <p>Already have an account? <a href="login.php">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <img src="assets/images/Doctors.jpeg" alt="Doctors" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?> 