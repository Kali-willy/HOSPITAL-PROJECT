# HOSPITAL-PROJECT

# Hospital Management System

A comprehensive web-based Hospital Management System built with PHP and MySQL. This system allows patients to book appointments with doctors and administrators to manage users, appointments, and generate reports.

## Features

### For Patients
- User registration and login
- Book appointments with doctors
- View appointment history
- Update profile information
- Receive notifications

### For Administrators
- Manage registered users/patients
- Update or delete appointment records
- Generate reports of patients and appointment history
- Manage system settings

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Clone or download the repository to your web server directory
2. Create a MySQL database named `hospital_db`
3. Import the database schema (optional - the system will create tables automatically on first run)
4. Configure the database connection in `config/database.php` if needed
5. Access the system through your web browser

## Default Admin Login

- Email: admin@hospital.com
- Password: admin123

## Directory Structure

```
Hospital/
├── admin/               # Admin area files
├── assets/              # CSS, JS, and image files
│   ├── css/
│   ├── js/
│   └── images/
├── config/              # Configuration files
├── includes/            # Common PHP includes
├── user/                # Patient/user area files
└── vendor/              # Third-party libraries
```

## Future Enhancements

- Email notifications for appointments
- Dashboard statistics with Chart.js
- Advanced search and filtering
- Medical history logs
- Live chat with doctors
- Export to PDF functionality

## Security Features

- SQL injection protection using prepared statements
- Password hashing
- Session management
- Input sanitization

## Credits

Developed by [Your Name]

## License

This project is licensed under the MIT License - see the LICENSE file for details. 
