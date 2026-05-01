-- Moot Court Competition Registration and Payment System Database Schema
-- This file creates the necessary tables for storing registration and transaction data

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS law_event;
USE law_event;

-- Registration table to store team registration details
CREATE TABLE IF NOT EXISTS m_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_member_1 VARCHAR(255) NOT NULL,
    team_member_2 VARCHAR(255) NOT NULL,
    team_member_3 VARCHAR(255) NOT NULL,
    college_name VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    side ENUM('plaintiff', 'defendant') NOT NULL,
    status ENUM('PENDING', 'SUCCESS', 'FAILED') DEFAULT 'PENDING',
    csrf_token VARCHAR(64) NOT NULL,
    receipt_token VARCHAR(64) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Transaction table to store payment details
CREATE TABLE IF NOT EXISTS m_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    transaction_id VARCHAR(100) UNIQUE,
    easepay_id VARCHAR(100),  -- Added missing column for Easebuzz payment ID
    payment_status VARCHAR(50) NOT NULL,
    payment_amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_time DATETIME,
    payment_raw_response JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES m_registrations(id) ON DELETE CASCADE,
    INDEX idx_registration_id (registration_id),
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created_at (created_at)
);

-- Audit log table for security and monitoring
CREATE TABLE IF NOT EXISTS m_audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent TEXT,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_action (action),
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
);

-- Insert sample data for testing (optional)
-- INSERT INTO m_registrations (team_member_1, team_member_2, team_member_3, college_name, mobile, email, side, status, csrf_token) VALUES
-- ('John Doe', 'Jane Smith', 'Bob Johnson', 'Sample University', '9876543210', 'test@example.com', 'plaintiff', 'PENDING', 'sample_token');

-- Add missing column to existing m_transactions table (run this if table already exists)
-- ALTER TABLE m_transactions ADD COLUMN easepay_id VARCHAR(100) AFTER transaction_id;