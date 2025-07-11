<?php
require_once '../includes/functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../login.php', 'Please login to book an appointment', 'warning');
}

// Check if user is patient (not admin)
if (isAdmin()) {
    redirect('../admin/dashboard.php', 'Admin users cannot book appointments', 'info');
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_name = sanitize($_POST['doctor_name']);
    $department = sanitize($_POST['department']);
    $appointment_date = sanitize($_POST['appointment_date']);
    $appointment_time = sanitize($_POST['appointment_time']);
    $reason = sanitize($_POST['reason']);
    $user_id = $_SESSION['user_id'];
    $error = '';
    
    // Validate inputs
    if (empty($doctor_name) || empty($department) || empty($appointment_date) || empty($appointment_time)) {
        $error = "All fields are required except reason";
    } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
        $error = "Appointment date cannot be in the past";
    } else {
        $conn = getConnection();
        
        // Check if the selected time slot is available
        $stmt = $conn->prepare("SELECT * FROM appointments WHERE doctor_name = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'");
        $stmt->bind_param("sss", $doctor_name, $appointment_date, $appointment_time);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "This time slot is already booked. Please select a different time.";
        } else {
            // Insert appointment
            $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_name, department, appointment_date, appointment_time, reason, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("isssss", $user_id, $doctor_name, $department, $appointment_date, $appointment_time, $reason);
            
            if ($stmt->execute()) {
                // Add notification
                $message = "Your appointment with Dr. $doctor_name on " . date('M d, Y', strtotime($appointment_date)) . " at " . date('h:i A', strtotime($appointment_time)) . " has been scheduled.";
                addNotification($user_id, $message);
                
                redirect('dashboard.php', 'Appointment booked successfully! You will be notified when it is confirmed.', 'success');
            } else {
                $error = "Failed to book appointment: " . $stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Define available departments and doctors
$departments = [
    'Cardiology' => ['Dr. John Smith', 'Dr. Maria Rodriguez'],
    'Neurology' => ['Dr. David Chen', 'Dr. Sarah Johnson'],
    'Orthopedics' => ['Dr. Michael Brown', 'Dr. Emily Davis'],
    'Pediatrics' => ['Dr. Robert Wilson', 'Dr. Lisa Thompson'],
    'Dermatology' => ['Dr. James Lee', 'Dr. Amanda White'],
    'Ophthalmology' => ['Dr. Thomas Garcia', 'Dr. Jessica Martinez'],
    'Dental' => ['Dr. William Taylor', 'Dr. Jennifer Anderson']
];

$page_title = "Book Appointment";
include_once '../includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Book an Appointment</h1>
        <p class="lead">Fill out the form below to schedule an appointment with one of our doctors.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="book-appointment.php" method="post" id="appointmentForm">
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departments as $dept => $doctors): ?>
                                <option value="<?php echo $dept; ?>" <?php echo (isset($_POST['department']) && $_POST['department'] == $dept) ? 'selected' : ''; ?>>
                                    <?php echo $dept; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="doctor_name" class="form-label">Doctor</label>
                        <select class="form-select" id="doctor_name" name="doctor_name" required>
                            <option value="">Select Doctor</option>
                            <!-- Options will be populated via JavaScript based on department selection -->
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date</label>
                                <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo isset($_POST['appointment_date']) ? $_POST['appointment_date'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="appointment_time" class="form-label">Appointment Time</label>
                                <select class="form-select" id="appointment_time" name="appointment_time" required>
                                    <option value="">Select Time</option>
                                    <?php
                                    // Generate time slots from 9 AM to 5 PM with 30-minute intervals
                                    $start = 9 * 60; // 9 AM in minutes
                                    $end = 17 * 60; // 5 PM in minutes
                                    $interval = 30; // 30 minutes
                                    
                                    for ($minutes = $start; $minutes < $end; $minutes += $interval) {
                                        $hour = floor($minutes / 60);
                                        $minute = $minutes % 60;
                                        $ampm = $hour >= 12 ? 'PM' : 'AM';
                                        $hour12 = $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour);
                                        
                                        $time_display = sprintf('%02d:%02d %s', $hour12, $minute, $ampm);
                                        $time_value = sprintf('%02d:%02d:00', $hour, $minute);
                                        
                                        $selected = (isset($_POST['appointment_time']) && $_POST['appointment_time'] == $time_value) ? 'selected' : '';
                                        echo "<option value=\"$time_value\" $selected>$time_display</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Visit (Optional)</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3"><?php echo isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : ''; ?></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span>Appointment Guidelines</span>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Appointments must be booked at least 24 hours in advance.
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        You can cancel appointments up to 4 hours before the scheduled time.
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Please arrive 15 minutes before your appointment time.
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Bring your ID and insurance information.
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        You will receive a confirmation email once your appointment is confirmed.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Populate doctors based on department selection
document.addEventListener('DOMContentLoaded', function() {
    const departments = <?php echo json_encode($departments); ?>;
    const departmentSelect = document.getElementById('department');
    const doctorSelect = document.getElementById('doctor_name');
    
    // Function to update doctors dropdown
    function updateDoctors() {
        const selectedDepartment = departmentSelect.value;
        
        // Clear current options
        doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
        
        // If a department is selected, add its doctors
        if (selectedDepartment && departments[selectedDepartment]) {
            departments[selectedDepartment].forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor;
                option.textContent = doctor;
                doctorSelect.appendChild(option);
            });
        }
    }
    
    // Update doctors when department changes
    departmentSelect.addEventListener('change', updateDoctors);
    
    // Initial update (in case of form resubmission)
    updateDoctors();
    
    <?php if (isset($_POST['doctor_name'])): ?>
    // Set the doctor if form was submitted
    setTimeout(() => {
        const doctorToSelect = "<?php echo $_POST['doctor_name']; ?>";
        for (let i = 0; i < doctorSelect.options.length; i++) {
            if (doctorSelect.options[i].value === doctorToSelect) {
                doctorSelect.options[i].selected = true;
                break;
            }
        }
    }, 100);
    <?php endif; ?>
});
</script>

<?php include_once '../includes/footer.php'; ?> 