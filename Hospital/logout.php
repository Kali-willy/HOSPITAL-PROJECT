<?php
require_once 'includes/functions.php';

// Destroy session
session_start();
session_unset();
session_destroy();

// Redirect to login page
redirect('login.php', 'You have been logged out successfully.', 'info');
?> 