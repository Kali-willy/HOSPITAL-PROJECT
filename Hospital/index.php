<?php
require_once 'includes/functions.php';
$page_title = "Home";
include_once 'includes/header.php';
?>

<!-- Hero Section with Carousel -->
<section class="hero-section position-relative">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/Building.jpeg" class="d-block w-100" alt="Hospital Building">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Welcome to Our Hospital</h2>
                    <p>Providing quality healthcare services</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/Doctors.jpeg" class="d-block w-100" alt="Our Doctors">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Expert Medical Staff</h2>
                    <p>Dedicated to your health and wellbeing</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/nurs-helping.jpeg" class="d-block w-100" alt="Patient Care">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Patient-Centered Care</h2>
                    <p>Your health is our priority</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <div class="hero-overlay">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white mb-4">Welcome to Hospital Management System</h1>
            <p class="lead text-white mb-5">A comprehensive solution for managing hospital operations, appointments, and patient records.</p>
            <?php if (!isLoggedIn()): ?>
                <div class="d-flex justify-content-center">
                    <a href="login.php" class="btn btn-primary btn-lg me-3 px-4 py-2">Login</a>
                    <a href="register.php" class="btn btn-outline-light btn-lg px-4 py-2">Register</a>
                </div>
            <?php else: ?>
                <div>
                    <?php if (isAdmin()): ?>
                        <a href="admin/dashboard.php" class="btn btn-primary btn-lg px-4 py-2">Go to Dashboard</a>
                    <?php else: ?>
                        <a href="user/book-appointment.php" class="btn btn-primary btn-lg px-4 py-2">Book an Appointment</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-light py-5 border-bottom">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-item">
                    <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                    <h2 class="counter">50+</h2>
                    <p class="text-muted">Doctors</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-item">
                    <i class="fas fa-procedures fa-3x text-primary mb-3"></i>
                    <h2 class="counter">200+</h2>
                    <p class="text-muted">Beds</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <i class="fas fa-hospital-user fa-3x text-primary mb-3"></i>
                    <h2 class="counter">10K+</h2>
                    <p class="text-muted">Happy Patients</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <i class="fas fa-award fa-3x text-primary mb-3"></i>
                    <h2 class="counter">15+</h2>
                    <p class="text-muted">Awards</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container my-5 py-5">
    <div class="row mb-5">
        <div class="col-lg-6 mx-auto text-center">
            <h2 class="section-title">Our Services</h2>
            <p class="text-muted">We provide a wide range of medical services to meet all your healthcare needs</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-primary text-white rounded-circle mb-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="card-title">Easy Appointment Booking</h4>
                    <p class="card-text">Schedule appointments with your preferred doctors at your convenience. Manage and track your appointments effortlessly.</p>
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary mt-3">Book Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-primary text-white rounded-circle mb-4">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h4 class="card-title">Expert Doctors</h4>
                    <p class="card-text">Access to a network of experienced and qualified doctors across various medical specialties for the best healthcare service.</p>
                    <a href="doctors.php" class="btn btn-outline-primary mt-3">Our Doctors</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-primary text-white rounded-circle mb-4">
                        <i class="fas fa-file-medical-alt"></i>
                    </div>
                    <h4 class="card-title">Medical Records</h4>
                    <p class="card-text">Secure storage and easy access to your medical history, prescriptions, and test results whenever you need them.</p>
                    <a href="<?php echo isLoggedIn() ? 'user/dashboard.php' : 'login.php'; ?>" class="btn btn-outline-primary mt-3">View Records</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section with Improved Layout -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="position-relative">
                    <img src="assets/images/Building.jpeg" alt="Hospital Building" class="img-fluid rounded-lg shadow-lg">
                    <div class="experience-badge">
                        <span class="years">25+</span>
                        <span class="text">Years of Excellence</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ps-md-5">
                <h6 class="text-primary text-uppercase mb-3">About Us</h6>
                <h2 class="mb-4">Providing Quality Healthcare Services</h2>
                <p class="lead mb-4">We are dedicated to providing the highest quality healthcare services to our patients with compassion and care.</p>
                <div class="mb-4">
                    <div class="d-flex mb-3">
                        <div class="icon-box me-3">
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">State-of-the-art Facilities</h5>
                            <p class="mb-0 text-muted">Our hospital is equipped with the latest medical technology and facilities.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="icon-box me-3">
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Experienced Medical Professionals</h5>
                            <p class="mb-0 text-muted">Our team consists of highly qualified and experienced healthcare providers.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="icon-box me-3">
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Patient-Centered Approach</h5>
                            <p class="mb-0 text-muted">We prioritize patient comfort, safety, and satisfaction in all our services.</p>
                        </div>
                    </div>
                </div>
                <a href="about.php" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Departments Section with Improved Cards -->
<section class="container my-5 py-5">
    <div class="row mb-5">
        <div class="col-lg-6 mx-auto text-center">
            <h2 class="section-title">Our Departments</h2>
            <p class="text-muted">Specialized care across multiple medical disciplines</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-6 mb-4">
            <div class="card department-card text-center h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="department-icon bg-danger-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-heartbeat text-danger"></i>
                    </div>
                    <h5>Cardiology</h5>
                    <p class="small text-muted mb-0">Heart care specialists</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card department-card text-center h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="department-icon bg-info-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-brain text-info"></i>
                    </div>
                    <h5>Neurology</h5>
                    <p class="small text-muted mb-0">Brain & nerve specialists</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card department-card text-center h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="department-icon bg-warning-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-bone text-warning"></i>
                    </div>
                    <h5>Orthopedics</h5>
                    <p class="small text-muted mb-0">Bone & joint specialists</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="card department-card text-center h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="department-icon bg-primary-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-tooth text-primary"></i>
                    </div>
                    <h5>Dental</h5>
                    <p class="small text-muted mb-0">Complete dental care</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="departments.php" class="btn btn-outline-primary">View All Departments</a>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto text-center">
                <h2 class="section-title">Patient Testimonials</h2>
                <p class="text-muted">What our patients say about us</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="testimonial-rating text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text mb-3">"The doctors and staff were extremely professional and caring. I received excellent treatment and follow-up care."</p>
                        <div class="d-flex align-items-center">
                            <div class="testimonial-avatar me-3">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Maria Santos</h6>
                                <small class="text-muted">Cardiology Patient</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="testimonial-rating text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text mb-3">"The online appointment booking system is very convenient. I could easily schedule my visits and access my medical records."</p>
                        <div class="d-flex align-items-center">
                            <div class="testimonial-avatar me-3">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">John Reyes</h6>
                                <small class="text-muted">Regular Patient</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="testimonial-rating text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-text mb-3">"I'm impressed with the cleanliness and modern facilities. The doctors took time to explain my condition and treatment options."</p>
                        <div class="d-flex align-items-center">
                            <div class="testimonial-avatar me-3">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Anna Cruz</h6>
                                <small class="text-muted">Surgery Patient</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action with Better Design -->
<section class="bg-primary text-white py-5 position-relative cta-section">
    <div class="container text-center py-4">
        <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
        <p class="lead mb-4 mx-auto" style="max-width: 700px;">Join our hospital management system today and experience healthcare like never before. Easy appointments, digital records, and expert care.</p>
        <?php if (!isLoggedIn()): ?>
            <a href="register.php" class="btn btn-light btn-lg px-5 py-3 fw-bold">Register Now</a>
        <?php else: ?>
            <a href="<?php echo isAdmin() ? 'admin/dashboard.php' : 'user/dashboard.php'; ?>" class="btn btn-light btn-lg px-5 py-3 fw-bold">Go to Dashboard</a>
        <?php endif; ?>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?> 