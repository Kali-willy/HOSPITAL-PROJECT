<?php
require_once 'includes/functions.php';
$page_title = "Our Departments";
include_once 'includes/header.php';
?>

<!-- Departments Hero Section -->
<section class="bg-primary text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Our Departments</h1>
        <p class="lead">Specialized medical care across multiple disciplines</p>
    </div>
</section>

<!-- Departments Section -->
<section class="container my-5">
    <div class="row mb-5">
        <div class="col-lg-6 mx-auto text-center">
            <h2 class="section-title">Medical Specialties</h2>
            <p class="text-muted">Our hospital offers comprehensive care across various medical specialties</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Department 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-danger-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-heartbeat text-danger"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">Cardiology</h4>
                    <p class="card-text text-muted">Our Cardiology Department specializes in diagnosing and treating diseases of the heart and blood vessels. Our team of experienced cardiologists uses the latest technology for accurate diagnosis and effective treatment.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Echocardiography</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Electrocardiogram (ECG)</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Cardiac Catheterization</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Coronary Angioplasty</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Pacemaker Implantation</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Department 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-info-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-brain text-info"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">Neurology</h4>
                    <p class="card-text text-muted">Our Neurology Department specializes in the diagnosis and treatment of disorders of the nervous system, including the brain, spinal cord, and peripheral nerves.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Electroencephalography (EEG)</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Electromyography (EMG)</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Nerve Conduction Studies</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Neuropsychological Testing</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Stroke Management</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Department 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-warning-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-bone text-warning"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">Orthopedics</h4>
                    <p class="card-text text-muted">Our Orthopedics Department specializes in the diagnosis and treatment of disorders of the bones, joints, ligaments, tendons, and muscles.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Joint Replacement Surgery</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Arthroscopy</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Fracture Care</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Sports Medicine</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Physical Therapy</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Department 4 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-success-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-baby text-success"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">Pediatrics</h4>
                    <p class="card-text text-muted">Our Pediatrics Department provides comprehensive healthcare services for infants, children, and adolescents, focusing on preventive care and treatment of childhood illnesses.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Well-Child Visits</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Immunizations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Growth and Development Monitoring</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Acute Illness Care</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Pediatric Specialist Referrals</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Department 5 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-primary-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-tooth text-primary"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">Dental</h4>
                    <p class="card-text text-muted">Our Dental Department offers comprehensive dental care services for patients of all ages, focusing on preventive care, restorative treatments, and cosmetic procedures.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Routine Dental Check-ups</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Teeth Cleaning</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Fillings and Restorations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Root Canal Treatment</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Cosmetic Dentistry</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
        
        <!-- Department 6 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card department-detail-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="department-icon bg-secondary-soft rounded-circle mb-4 mx-auto">
                        <i class="fas fa-stethoscope text-secondary"></i>
                    </div>
                    <h4 class="card-title text-center mb-3">General Medicine</h4>
                    <p class="card-text text-muted">Our General Medicine Department provides primary healthcare services for adults, including preventive care, diagnosis, and treatment of various medical conditions.</p>
                    <h6 class="mt-4 mb-3">Services:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Annual Physical Examinations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Chronic Disease Management</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Preventive Health Screenings</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Vaccinations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Minor Procedures</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="<?php echo isLoggedIn() ? 'user/book-appointment.php' : 'login.php'; ?>" class="btn btn-outline-primary">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add department card styles -->
<style>
.department-detail-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.department-detail-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

.department-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.department-icon i {
    font-size: 2rem;
}

.bg-success-soft {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-secondary-soft {
    background-color: rgba(108, 117, 125, 0.1);
}
</style>

<?php include_once 'includes/footer.php'; ?> 