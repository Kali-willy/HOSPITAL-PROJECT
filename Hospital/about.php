<?php
require_once 'includes/functions.php';
$page_title = "About Us";
include_once 'includes/header.php';
?>

<!-- About Hero Section -->
<section class="bg-primary text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">About Our Hospital</h1>
        <p class="lead">Providing quality healthcare services with compassion and care</p>
    </div>
</section>

<!-- About Content Section -->
<section class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="assets/images/Building.jpeg" alt="Hospital Building" class="img-fluid rounded-lg shadow-lg">
        </div>
        <div class="col-lg-6">
            <h2 class="mb-4">Our Story</h2>
            <p class="lead mb-4">Founded in 1998, our hospital has been serving the community for over 25 years with dedication and excellence.</p>
            <p>Our hospital started as a small clinic with just a handful of doctors and nurses. Over the years, we have grown into a comprehensive healthcare facility with state-of-the-art equipment and a team of experienced healthcare professionals.</p>
            <p>We are committed to providing the highest quality healthcare services to our patients. Our mission is to improve the health and well-being of the communities we serve through compassionate care, innovation, and education.</p>
        </div>
    </div>
    
    <!-- Mission, Vision, Values -->
    <div class="row my-5 py-5 border-top border-bottom">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="text-center">
                <div class="icon-box bg-primary-soft rounded-circle mb-4 mx-auto">
                    <i class="fas fa-bullseye text-primary fa-2x"></i>
                </div>
                <h3>Our Mission</h3>
                <p>To provide exceptional healthcare services that improve the health and well-being of our patients and community through compassionate care, innovation, and education.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="text-center">
                <div class="icon-box bg-primary-soft rounded-circle mb-4 mx-auto">
                    <i class="fas fa-eye text-primary fa-2x"></i>
                </div>
                <h3>Our Vision</h3>
                <p>To be the healthcare provider of choice, recognized for excellence in patient care, innovative treatments, and community engagement.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <div class="icon-box bg-primary-soft rounded-circle mb-4 mx-auto">
                    <i class="fas fa-heart text-primary fa-2x"></i>
                </div>
                <h3>Our Values</h3>
                <p>Compassion, Excellence, Integrity, Teamwork, Innovation, and Respect guide our actions and decisions in providing healthcare services.</p>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Us -->
    <div class="row my-5">
        <div class="col-lg-12 text-center mb-5">
            <h2 class="section-title">Why Choose Us</h2>
            <p class="text-muted">We are committed to providing the best healthcare experience for our patients</p>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="d-flex">
                <div class="icon-box bg-primary-soft rounded-circle me-4">
                    <i class="fas fa-user-md text-primary"></i>
                </div>
                <div>
                    <h4 class="mb-3">Expert Medical Team</h4>
                    <p class="text-muted">Our hospital is staffed by highly qualified and experienced healthcare professionals who are dedicated to providing the best care for our patients.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="d-flex">
                <div class="icon-box bg-primary-soft rounded-circle me-4">
                    <i class="fas fa-hospital text-primary"></i>
                </div>
                <div>
                    <h4 class="mb-3">State-of-the-Art Facilities</h4>
                    <p class="text-muted">We have invested in the latest medical technology and equipment to ensure accurate diagnosis and effective treatment for our patients.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="d-flex">
                <div class="icon-box bg-primary-soft rounded-circle me-4">
                    <i class="fas fa-heartbeat text-primary"></i>
                </div>
                <div>
                    <h4 class="mb-3">Patient-Centered Care</h4>
                    <p class="text-muted">We prioritize patient comfort, safety, and satisfaction in all our services. Our approach is tailored to meet the unique needs of each patient.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="d-flex">
                <div class="icon-box bg-primary-soft rounded-circle me-4">
                    <i class="fas fa-clock text-primary"></i>
                </div>
                <div>
                    <h4 class="mb-3">24/7 Emergency Services</h4>
                    <p class="text-muted">Our emergency department is open 24 hours a day, 7 days a week, to provide immediate care for patients with urgent medical needs.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Team -->
    <div class="row my-5 pt-5 border-top">
        <div class="col-lg-12 text-center mb-5">
            <h2 class="section-title">Our Leadership Team</h2>
            <p class="text-muted">Meet the dedicated professionals who lead our hospital</p>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card team-card border-0 shadow-sm h-100">
                <div class="team-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. James Wilson">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. James Wilson</h5>
                    <p class="text-primary mb-3">Chief Executive Officer</p>
                    <p class="card-text text-muted">With over 25 years of experience in healthcare management, Dr. Wilson leads our hospital with vision and dedication.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card team-card border-0 shadow-sm h-100">
                <div class="team-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Elena Rodriguez">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Elena Rodriguez</h5>
                    <p class="text-primary mb-3">Chief Medical Officer</p>
                    <p class="card-text text-muted">Dr. Rodriguez oversees all medical operations and ensures the highest standards of patient care across all departments.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card team-card border-0 shadow-sm h-100">
                <div class="team-img-container">
                    <img src="assets/images/nurs-helping.jpeg" class="card-img-top" alt="Sarah Thompson">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Sarah Thompson</h5>
                    <p class="text-primary mb-3">Chief Nursing Officer</p>
                    <p class="card-text text-muted">With her extensive nursing experience, Sarah leads our nursing staff and ensures excellent patient care and support.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card team-card border-0 shadow-sm h-100">
                <div class="team-img-container">
                    <img src="assets/images/man-walk.jpeg" class="card-img-top" alt="Michael Brown">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Michael Brown</h5>
                    <p class="text-primary mb-3">Chief Financial Officer</p>
                    <p class="card-text text-muted">Michael manages the financial operations of our hospital, ensuring we can continue to provide quality healthcare services.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add team card styles -->
<style>
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.team-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

.team-img-container {
    height: 250px;
    overflow: hidden;
}

.team-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.team-card:hover .team-img-container img {
    transform: scale(1.1);
}

.rounded-lg {
    border-radius: 15px !important;
}

.bg-primary-soft {
    background-color: rgba(13, 110, 253, 0.1);
}
</style>

<?php include_once 'includes/footer.php'; ?> 