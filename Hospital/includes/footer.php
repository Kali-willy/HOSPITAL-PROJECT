    </div> <!-- End of container -->
    
    <footer class="bg-primary text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-hospital me-2"></i>Hospital Management System</h5>
                    <p>A comprehensive solution for managing hospital operations, appointments, and patient records.</p>
                    <div class="mt-3 social-icons">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-link me-2"></i>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-white text-decoration-none"><i class="fas fa-angle-right me-2"></i>Home</a></li>
                        <?php if (!isLoggedIn()): ?>
                            <li class="mb-2"><a href="login.php" class="text-white text-decoration-none"><i class="fas fa-angle-right me-2"></i>Login</a></li>
                            <li class="mb-2"><a href="register.php" class="text-white text-decoration-none"><i class="fas fa-angle-right me-2"></i>Register</a></li>
                        <?php endif; ?>
                        <li class="mb-2"><a href="contact.php" class="text-white text-decoration-none"><i class="fas fa-angle-right me-2"></i>Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-address-card me-2"></i>Contact Information</h5>
                    <address>
                        <div class="d-flex mb-2">
                            <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                            <span>123 Hospital Street, City</span>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="fas fa-phone me-3 mt-1"></i>
                            <span>(63+) 09122869920<br>(63+) 09703092060</span>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="fas fa-envelope me-3 mt-1"></i>
                            <span>willygailo@gmail.com</span>
                        </div>
                    </address>
                </div>
            </div>
            <hr class="mt-0">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Hospital Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html> 