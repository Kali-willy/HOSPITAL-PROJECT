<?php
require_once 'includes/functions.php';
$page_title = "Our Doctors";
include_once 'includes/header.php';
?>

<!-- Doctors Hero Section -->
<section class="bg-primary text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Our Doctors</h1>
        <p class="lead">Meet our team of experienced and qualified medical professionals</p>
    </div>
</section>

<!-- Doctors Section -->
<section class="container my-5">
    <div class="row mb-5">
        <div class="col-lg-6 mx-auto text-center">
            <h2 class="section-title">Expert Medical Team</h2>
            <p class="text-muted">Our hospital is proud to have some of the best doctors in their respective fields</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Doctor 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. John Smith">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. John Smith</h5>
                    <p class="text-primary mb-3">Cardiologist</p>
                    <p class="card-text text-muted">Specializes in diagnosing and treating diseases of the cardiovascular system. Over 15 years of experience.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Doctor 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Maria Garcia">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Maria Garcia</h5>
                    <p class="text-primary mb-3">Neurologist</p>
                    <p class="card-text text-muted">Specializes in treating disorders of the nervous system, including the brain, spinal cord, and peripheral nerves.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Doctor 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Robert Johnson">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Robert Johnson</h5>
                    <p class="text-primary mb-3">Orthopedic Surgeon</p>
                    <p class="card-text text-muted">Specializes in the diagnosis and treatment of disorders of the bones, joints, ligaments, tendons, and muscles.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Doctor 4 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Sarah Lee">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Sarah Lee</h5>
                    <p class="text-primary mb-3">Pediatrician</p>
                    <p class="card-text text-muted">Specializes in the care of infants, children, and adolescents. Focuses on preventive health and treating childhood illnesses.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Doctor 5 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Michael Chen">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Michael Chen</h5>
                    <p class="text-primary mb-3">Dermatologist</p>
                    <p class="card-text text-muted">Specializes in conditions and diseases of the skin, hair, and nails. Expert in both medical and cosmetic dermatology.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Doctor 6 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card doctor-card border-0 shadow-sm h-100">
                <div class="doctor-img-container">
                    <img src="assets/images/Doctors.jpeg" class="card-img-top" alt="Dr. Emily Wilson">
                </div>
                <div class="card-body text-center p-4">
                    <h5 class="card-title mb-1">Dr. Emily Wilson</h5>
                    <p class="text-primary mb-3">Psychiatrist</p>
                    <p class="card-text text-muted">Specializes in the diagnosis, prevention, and treatment of mental disorders. Provides both therapy and medication management.</p>
                    <div class="doctor-social mt-3">
                        <a href="#" class="text-muted me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Doctor CTA Section -->
<section class="bg-light py-5 text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h3>Need a Specialist Consultation?</h3>
                <p class="lead text-muted mb-4">Our doctors are available for in-person and virtual consultations</p>
                <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-primary px-4 py-2">Book an Appointment</a>
            </div>
        </div>
    </div>
</section>

<!-- Add doctor card styles -->
<style>
.doctor-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.doctor-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

.doctor-img-container {
    height: 250px;
    overflow: hidden;
}

.doctor-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.doctor-card:hover .doctor-img-container img {
    transform: scale(1.1);
}

.doctor-social a {
    display: inline-block;
    width: 32px;
    height: 32px;
    line-height: 32px;
    border-radius: 50%;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.doctor-social a:hover {
    background-color: #0d6efd;
    color: white !important;
}
</style>

<?php include_once 'includes/footer.php'; ?> 