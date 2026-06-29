DROP DATABASE IF EXISTS clinic_appointment_crm;

CREATE DATABASE clinic_appointment_crm
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE clinic_appointment_crm;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_code VARCHAR(30) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    symptom VARCHAR(150) NOT NULL,
    status ENUM('new', 'contacted', 'scheduled', 'cancelled', 'treated')
        NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_patient_email ON patients(email);
CREATE INDEX idx_patient_status ON patients(status);
CREATE INDEX idx_patient_code ON patients(patient_code);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_code VARCHAR(30) NOT NULL UNIQUE,
    patient_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    department VARCHAR(100) NOT NULL,
    fee DECIMAL(12,2) NOT NULL,
    appointment_status ENUM('pending', 'confirmed', 'completed', 'cancelled')
        NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_appointments_patients
    FOREIGN KEY (patient_id)
    REFERENCES patients(id)
    ON DELETE CASCADE
);

CREATE INDEX idx_appointment_code ON appointments(appointment_code);
CREATE INDEX idx_appointment_status ON appointments(appointment_status);
CREATE INDEX idx_appointment_date ON appointments(appointment_date);