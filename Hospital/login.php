<?php
require_once 'includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(isAdmin() ? 'admin/dashboard.php' : 'user/dashboard.php');
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $error = '';
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect based on role
                redirect($user['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php', 'Login successful!', 'success');
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }
        
        $stmt->close();
        $conn->close();
    }
}

$page_title = "Login";
include_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="auth-form">
                    <h2 class="form-title text-center mb-4">Login to Your Account</h2>
                    
                    <?php if (isset($error) && !empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <p>Don't have an account? <a href="register.php">Register here</a></p>
                            <p><a href="forgot-password.php">Forgot your password?</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <img src="assets/images/nurs-helping.jpeg" alt="Nurse Helping" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?> 