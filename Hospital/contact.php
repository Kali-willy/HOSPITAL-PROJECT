<?php
require_once 'includes/functions.php';
$page_title = "Contact Us";
include_once 'includes/header.php';
?>

<!-- Contact Section -->
<section class="container my-5">
    <div class="row mb-5">
        <div class="col-lg-6 mx-auto text-center">
            <h2 class="section-title">Contact Us</h2>
            <p class="text-muted">We're here to help with any questions you may have</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4">Get In Touch</h4>
                <div class="d-flex mb-3">
                    <div class="icon-box bg-primary-soft rounded-circle me-3">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Address</h6>
                        <p class="mb-0 text-muted">123 Hospital Street, City</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="icon-box bg-primary-soft rounded-circle me-3">
                        <i class="fas fa-phone text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Phone</h6>
                        <p class="mb-0 text-muted">(63+) 09122869920<br>(63+) 09703092060</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="icon-box bg-primary-soft rounded-circle me-3">
                        <i class="fas fa-envelope text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Email</h6>
                        <p class="mb-0 text-muted">willygailo@gmail.com</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="icon-box bg-primary-soft rounded-circle me-3">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Working Hours</h6>
                        <p class="mb-0 text-muted">Monday - Friday: 8:00 AM - 8:00 PM<br>Saturday: 9:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4">Send a Message</h4>
                <form action="#" method="post" id="contactForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="container my-5">
    <div class="card border-0 shadow-sm p-0">
        <div class="ratio ratio-21x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.802548850011!2d121.04882931744384!3d14.554743699999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8efd99aad53%3A0xb64b39847a866fde!2sMakati%20Medical%20Center!5e0!3m2!1sen!2sph!4v1651234567890!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?> 