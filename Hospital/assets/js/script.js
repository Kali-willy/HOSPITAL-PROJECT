// Hospital Management System - Main JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Handle appointment form submission
    const appointmentForm = document.getElementById('appointment-form');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            // Form validation can be added here
            const appointmentDate = document.getElementById('appointment-date');
            const appointmentTime = document.getElementById('appointment-time');
            
            if (appointmentDate && appointmentTime) {
                const selectedDate = new Date(appointmentDate.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    e.preventDefault();
                    alert('Please select a future date for your appointment.');
                }
            }
        });
    }
    
    // Handle profile form submission
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');
            
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    }
    
    // Handle appointment status updates (admin)
    const statusSelects = document.querySelectorAll('.appointment-status');
    if (statusSelects.length > 0) {
        statusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const appointmentId = this.getAttribute('data-appointment-id');
                const newStatus = this.value;
                
                // You can use AJAX to update the status
                if (appointmentId && newStatus) {
                    updateAppointmentStatus(appointmentId, newStatus);
                }
            });
        });
    }
    
    // Function to update appointment status via AJAX
    function updateAppointmentStatus(appointmentId, status) {
        fetch('update_appointment_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `appointment_id=${appointmentId}&status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Appointment status updated successfully!');
                
                // Update UI if needed
                const statusCell = document.querySelector(`.status-cell-${appointmentId}`);
                if (statusCell) {
                    statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    
                    // Update status class
                    statusCell.className = 'status-cell-' + appointmentId;
                    statusCell.classList.add('status-' + status);
                }
            } else {
                alert('Failed to update appointment status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the appointment status.');
        });
    }
    
    // Handle delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    }
}); 