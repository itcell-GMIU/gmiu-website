CREATE DATABASE IF NOT EXISTS tada;
USE tada;

-- 1. Main Table for TADA Form Data
CREATE TABLE IF NOT EXISTS tbl_tada_form_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
   
    -- Section 1: Personal & Professional Details
    full_name VARCHAR(255) DEFAULT NULL,
    form_date DATE DEFAULT NULL,
    designation VARCHAR(255) DEFAULT NULL,
    institute_name VARCHAR(255) DEFAULT NULL,
    institute_address TEXT DEFAULT NULL,
    phone_no VARCHAR(20) DEFAULT NULL,
    email_id VARCHAR(255) DEFAULT NULL,
    branch VARCHAR(150) DEFAULT NULL,
    subject_code VARCHAR(100) DEFAULT NULL,
    semester INT DEFAULT NULL,
    subject_name VARCHAR(255) DEFAULT NULL,
   
    -- Section 3: Daily Allowance (B)
    da_no_of_days INT DEFAULT 0,
    da_rate_per_day DOUBLE DEFAULT 0.0,
    total_da_amount_b DOUBLE DEFAULT 0.0,
   
    -- Section 4: Honorarium (C)
    honorarium_no_of_days INT DEFAULT 0,
    honorarium_rate_per_day DOUBLE DEFAULT 0.0,
    total_honorarium_amount_c DOUBLE DEFAULT 0.0,
   
    -- Section 5: Accommodation (D)
    accommodation_no_of_days INT DEFAULT 0,
    accommodation_rate_per_day DOUBLE DEFAULT 0.0,
    total_accommodation_amount_d DOUBLE DEFAULT 0.0,
   
    -- Section 6: Gross Total
    gross_total_amount DOUBLE DEFAULT 0.0,
   
    -- Trackers / Metadata
    created_by INT DEFAULT NULL,         -- Links to staff_id
    is_active TINYINT(1) DEFAULT 1,      -- For view filter
    is_delete TINYINT(1) DEFAULT 0,      -- Soft delete
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Child Table for Travelling Allowance Details (A)
CREATE TABLE IF NOT EXISTS tbl_tada_form_travelling_allowance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tada_form_id INT NOT NULL,           -- Foreign key linking to tbl_tada_form_data
    journey_date DATE DEFAULT NULL,
    journey_from VARCHAR(255) DEFAULT NULL,
    journey_to VARCHAR(255) DEFAULT NULL,
    distance_km DOUBLE DEFAULT 0.0,
    mode_of_journey VARCHAR(100) DEFAULT NULL,
    class_of_travel VARCHAR(100) DEFAULT NULL,
    fare_paid INT DEFAULT 0,             -- Integer according to bind param `i`
    remark TEXT DEFAULT NULL,
   
    -- Constraints & Trackers
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tada_form_id) REFERENCES tbl_tada_form_data(id) ON DELETE CASCADE
);

-- Basic tables for login as seen in login.php
CREATE TABLE IF NOT EXISTS tbl_role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    is_delete TINYINT(1) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS tbl_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    faculty_id INT DEFAULT NULL,
    level_id INT DEFAULT NULL,
    program_id INT DEFAULT NULL,
    under_staff_id INT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    is_delete TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tbl_login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default role and staff for testing login if they don't exist
INSERT INTO tbl_role (id, name) VALUES (8, 'Staff') ON DUPLICATE KEY UPDATE name=VALUES(name);
INSERT INTO tbl_staff (name, email, password, role_id) 
VALUES ('Admin', 'admin@example.com', 'admin123', 8) 
ON DUPLICATE KEY UPDATE email=VALUES(email);
