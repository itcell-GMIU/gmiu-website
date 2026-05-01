<?php
// config.php - Centralized configuration file

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'law_event'); // Changed from 'law_event' to match SQL file
define('DB_USER', 'root'); // Update with your MySQL username
define('DB_PASS', ''); // Update with your MySQL password
define('DB_CHARSET', 'utf8mb4');

// Payment Gateway Configuration (Easebuzz)
define('EASEBUZZ_MERCHANT_KEY', '2PBP7IABZ2');
define('EASEBUZZ_SALT', 'DAH88E3UWQ');
define('EASEBUZZ_ENV', 'test'); // 'test' or 'prod'

// Application Configuration
define('APP_NAME', 'GMIU Moot Court Registration');
define('APP_URL', 'http://localhost/gmiu/moot-court'); // Update for production
define('BASE_DOMAIN', 'https://gmiu.edu.in'); // Base domain for assets and links

// Payment Gateway URLs
define('PAYMENT_SUCCESS_URL', 'http://localhost/gmiu/moot-court/controllers/payment_success.php'); // Update for production
define('PAYMENT_FAILURE_URL', 'http://localhost/gmiu/moot-court/controllers/payment_failure.php'); // Update for production

define('CONTACT_EMAIL', 'itcell@gmiu.edu.in'); // Contact email for support
define('SUPPORT_EMAIL', 'support@gmiu.edu.in'); // Support email for issues
define('REGISTRATION_FEE', 300.00); // Amount in INR
define('CURRENCY', 'INR');

// Security Configuration
define('CSRF_TOKEN_LENGTH', 32);
define('SESSION_LIFETIME', 3600); // 1 hour

// File Paths
define('LOGS_DIR', __DIR__ . '/../logs/');
define('RECEIPTS_DIR', __DIR__ . '/../receipts/');

// Email Configuration - Simple SMTP Setup
define('SMTP_HOST', 'smtp.gmail.com'); // Your SMTP server (gmail, outlook, etc.)
define('SMTP_PORT', 587); // Usually 587 for TLS
define('SMTP_USER', 'adminlaw@gmiu.edu.in'); // Your email address
define('SMTP_PASS', 'jtti metl uguy nahe'); // Your password or app password
define('FROM_EMAIL', 'adminlaw@gmiu.edu.in'); // Same as SMTP_USER usually
define('FROM_NAME', 'GMIU Moot Court'); // Sender name

// Environment Check
if (EASEBUZZ_ENV === 'prod') {
    // Production settings
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_PARSE);
} else {
    // Development settings
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Timezone
date_default_timezone_set('Asia/Kolkata');
?>