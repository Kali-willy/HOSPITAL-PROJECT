-- Hospital Management System Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'patient', 'doctor', 'nurse') NOT NULL DEFAULT 'patient',
    phone VARCHAR(20),
    address TEXT,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE IF NOT EXISTS departments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctors table
CREATE TABLE IF NOT EXISTS doctors (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    department_id INT(11) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    qualification VARCHAR(255) NOT NULL,
    experience INT(3),
    consultation_fee DECIMAL(10,2),
    availability_schedule TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    doctor_id INT(11) NOT NULL,
    department_id INT(11) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- Medical Records table
CREATE TABLE IF NOT EXISTS medical_records (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(11) NOT NULL,
    doctor_id INT(11) NOT NULL,
    appointment_id INT(11),
    diagnosis TEXT,
    treatment TEXT,
    prescription TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
);

-- Medications table
CREATE TABLE IF NOT EXISTS medications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    dosage VARCHAR(100),
    price DECIMAL(10,2),
    stock INT(11) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Prescriptions table
CREATE TABLE IF NOT EXISTS prescriptions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    medical_record_id INT(11) NOT NULL,
    medication_id INT(11) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequency VARCHAR(100) NOT NULL,
    duration VARCHAR(100) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medical_record_id) REFERENCES medical_records(id) ON DELETE CASCADE,
    FOREIGN KEY (medication_id) REFERENCES medications(id) ON DELETE CASCADE
);

-- Billing table
CREATE TABLE IF NOT EXISTS billing (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(11) NOT NULL,
    appointment_id INT(11),
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    invoice_number VARCHAR(50),
    billing_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
);

-- Notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    type VARCHAR(50),
    related_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Schedules table
CREATE TABLE IF NOT EXISTS schedules (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT(11) NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    max_appointments INT(3) DEFAULT 10,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Insert default departments
INSERT INTO departments (name, description) VALUES
('Cardiology', 'Deals with disorders of the heart and blood vessels'),
('Neurology', 'Deals with disorders of the nervous system'),
('Orthopedics', 'Deals with conditions involving the musculoskeletal system'),
('Pediatrics', 'Deals with the medical care of infants, children, and adolescents'),
('Dermatology', 'Deals with the skin and its diseases'),
('Ophthalmology', 'Deals with the anatomy, physiology and diseases of the eye'),
('Gynecology', 'Deals with the health of the female reproductive systems'),
('Psychiatry', 'Deals with the diagnosis, prevention, and treatment of mental disorders');

-- Insert default admin user
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@hospital.com', '$2y$10$8jnT5.ZKmvqNKMWNfHkZIOoEXZXFrA5BF3XNRpAG/4J8mKjVVlsAe', 'admin');
-- Note: Password is 'admin123' hashed with PASSWORD_DEFAULT

-- Insert sample medications
INSERT INTO medications (name, description, dosage, price, stock) VALUES
('Paracetamol', 'Pain reliever and fever reducer', '500mg', 5.00, 1000),
('Amoxicillin', 'Antibiotic medication', '250mg', 10.00, 500),
('Omeprazole', 'Proton pump inhibitor that decreases stomach acid production', '20mg', 15.00, 300),
('Lisinopril', 'ACE inhibitor medication used to treat high blood pressure', '10mg', 20.00, 400),
('Metformin', 'Oral diabetes medicine that helps control blood sugar levels', '500mg', 12.00, 600); 