<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Function to sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
}

// Function to redirect with message
function redirect($url, $message = '', $type = 'info') {
    if (!empty($message)) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
    header("Location: $url");
    exit();
}

// Function to display message
function displayMessage() {
    if (isset($_SESSION['message'])) {
        $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
        $message = $_SESSION['message'];
        
        echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                $message
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}

// Function to get user details by ID
function getUserById($id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

// Function to get all appointments for a user
function getUserAppointments($user_id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC, appointment_time DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $appointments;
}

// Function to get all appointments (admin)
function getAllAppointments() {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT a.*, u.name as patient_name, u.email 
                           FROM appointments a 
                           JOIN users u ON a.user_id = u.id 
                           ORDER BY a.appointment_date DESC, a.appointment_time DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $appointments;
}

// Function to get all users (admin)
function getAllUsers() {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM users ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $users;
}

// Function to add notification
function addNotification($user_id, $message) {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Function to get user notifications
function getUserNotifications($user_id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $notifications;
}

// Function to mark notification as read
function markNotificationAsRead($notification_id) {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE notifications SET is_read = TRUE WHERE id = ?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?> 