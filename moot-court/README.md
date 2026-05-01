# GMIU Moot Court Competition Registration System

A secure PHP and MySQL-based registration and payment system for the Moot Court Competition at Gyanmanjari Institute of Law.

## Features

- **Secure Registration**: CSRF protection, input validation, and sanitization
- **Payment Integration**: Easebuzz payment gateway integration
- **Duplicate Prevention**: Email-based restriction for successful registrations
- **Receipt Generation**: Downloadable PDF receipts with print support
- **Audit Logging**: Comprehensive logging for security and monitoring
- **Email Confirmations**: Automatic HTML email notifications after successful payment
- **Clean Architecture**: Organized folder structure with MVC-like separation

## Requirements

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Apache/Nginx web server
- Composer (for dependencies)
- TCPDF library (for PDF generation)

---

# 📋 End-to-End Application Flow

## 1. **User Registration Process**

### Step 1: Access Registration Form

- User visits `index.php` (main registration page)
- System generates CSRF token for form security
- Form displays with validation rules

### Step 2: Form Submission & Validation

- User fills and submits the registration form
- **Server-side validation**:
  - CSRF token verification
  - Input sanitization and validation
  - Email format validation
  - Mobile number validation (10 digits, starts with 6-9)
  - Required field checks
- **Duplicate prevention**: Check if email already has successful registration

### Step 3: Database Storage

- Valid data inserted into `m_registrations` table
- Generates secure 64-character receipt token
- Sets initial status as 'PENDING'
- Audit log entry created

### Step 4: Payment Initiation

- Redirects to `controllers/process_payment.php`
- Creates payment request with Easebuzz gateway
- Includes registration ID in UDF1 field
- Redirects user to Easebuzz payment page

## 2. **Payment Processing Flow**

### Step 5: Payment Gateway Processing

- User completes payment on Easebuzz
- Easebuzz processes payment (test/prod mode)
- Payment response sent back via POST

### Step 6: Payment Response Handling

- **Success Response** (`controllers/payment_success.php`):
  - Verifies payment signature
  - Validates payment amount (₹300)
  - Updates registration status to 'SUCCESS'
  - Inserts transaction record in `m_transactions`
  - Sends confirmation email with receipt download link
  - Redirects to receipt page with secure token

- **Failure Response** (`controllers/payment_failure.php`):
  - Updates registration status to 'FAILED'
  - Logs failure reason
  - Displays user-friendly error message
  - Provides contact information for support

## 3. **Receipt Generation & Access**

### Step 7: Receipt Display

- User accesses `receipt.php?reg_id=X&token=Y`
- **Security validation**:
  - Token format validation (64-character hex)
  - Database verification of registration + token
  - Payment status check (must be SUCCESS)
- Displays receipt with team details, payment info, and actions

### Step 8: Receipt Actions

- **View Receipt**: HTML display with professional styling
- **Print Receipt**: Uses print-optimized CSS for single-page output
- **Download PDF**: Generates TCPDF document with Unicode support
- **Register Another Team**: Link back to registration form

## 4. **Email Notification Flow**

### Step 9: Confirmation Email

- Sent immediately after successful payment
- **HTML email template** includes:
  - Registration confirmation message
  - Complete team and payment details
  - Secure receipt download link
  - Contact information
  - Professional GMIU branding

---

# 🚀 Production Deployment Configuration

## Current Localhost Configuration

For development/localhost environment, your `config/config.php` should have:

```php
// Application Configuration
define('APP_NAME', 'GMIU Moot Court Registration');
define('APP_URL', 'http://localhost/gmiu/moot-court');
define('BASE_DOMAIN', 'https://gmiu.edu.in');

// Payment Gateway URLs
define('PAYMENT_SUCCESS_URL', 'http://localhost/gmiu/moot-court/controllers/payment_success.php');
define('PAYMENT_FAILURE_URL', 'http://localhost/gmiu/moot-court/controllers/payment_failure.php');
```

## Pre-Deployment Checklist

- [ ] Database server ready with MySQL 8.0+
- [ ] Web server (Apache/Nginx) configured
- [ ] SSL certificate installed
- [ ] Domain pointing to server
- [ ] Email SMTP service configured

## 1. **Database Configuration**

Update `config/config.php`:

```php
// Database Configuration
define('DB_HOST', 'localhost');           // Usually 'localhost' or server IP
define('DB_NAME', 'gmiu_moot_court');     // Production database name
define('DB_USER', 'prod_user');           // Production database user
define('DB_PASS', 'secure_password');     // Strong production password
define('DB_CHARSET', 'utf8mb4');
```

## 2. **Application URLs Configuration**

Update `config/config.php`:

```php
// Application Configuration
define('APP_NAME', 'GMIU Moot Court Registration');
define('APP_URL', 'https://yourdomain.com/moot-court');     // Production URL
define('BASE_DOMAIN', 'https://yourdomain.com');            // Production domain
```

## 2.1 **Payment Gateway URLs Configuration**

Update `config/config.php`:

```php
// Payment Gateway URLs
define('PAYMENT_SUCCESS_URL', 'https://yourdomain.com/moot-court/controllers/payment_success.php');
define('PAYMENT_FAILURE_URL', 'https://yourdomain.com/moot-court/controllers/payment_failure.php');
```

## 3. **Payment Gateway Configuration**

Update `config/config.php`:

```php
// Payment Gateway Configuration (Easebuzz)
define('EASEBUZZ_MERCHANT_KEY', 'YOUR_PRODUCTION_MERCHANT_KEY');
define('EASEBUZZ_SALT', 'YOUR_PRODUCTION_SALT');
define('EASEBUZZ_ENV', 'prod');  // Change from 'test' to 'prod'
```

## 4. **Email Configuration**

Update `config/config.php`:

```php
// Email Configuration
define('SMTP_HOST', 'smtp.your-email-provider.com');  // Production SMTP server
define('SMTP_PORT', 587);                             // Usually 587 for TLS
define('SMTP_USER', 'noreply@yourdomain.com');        // Production email
define('SMTP_PASS', 'production_email_password');     // Production password
define('FROM_EMAIL', 'noreply@yourdomain.com');       // Same as SMTP_USER
define('FROM_NAME', 'GMIU Moot Court Team');          // Professional sender name

// Contact Information
define('CONTACT_EMAIL', 'itcell@yourdomain.com');     // Support email
define('SUPPORT_EMAIL', 'support@yourdomain.com');    // Issue reporting email
```

## 5. **File Permissions & Security**

```bash
# Set proper permissions
chmod 755 /path/to/moot-court/
chmod 644 /path/to/moot-court/config/config.php
chmod 755 /path/to/moot-court/logs/
chmod 755 /path/to/moot-court/receipts/

# Secure sensitive files
chmod 600 /path/to/moot-court/config/config.php
```

## 6. **Web Server Configuration**

### Apache (.htaccess already included)

- Ensure `mod_rewrite` is enabled
- Configure virtual host to point to project root

### Nginx Configuration Example:

```nginx
server {
    listen 443 ssl;
    server_name yourdomain.com;

    root /path/to/moot-court;
    index index.php;

    # SSL Configuration
    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/private.key;

    # PHP Configuration
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
}
```

## 7. **Database Setup**

```bash
# Create production database
mysql -u root -p
CREATE DATABASE gmiu_moot_court CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON gmiu_moot_court.* TO 'prod_user'@'localhost' IDENTIFIED BY 'secure_password';
FLUSH PRIVILEGES;
EXIT;

# Import schema
mysql -u prod_user -p gmiu_moot_court < create_tables.sql
```

## 8. **Dependencies Installation**

```bash
# Install PHP dependencies
cd /path/to/moot-court
composer install --no-dev --optimize-autoloader

# Verify TCPDF installation
ls -la vendor/tecnickcom/tcpdf/
```

## 9. **Environment Configuration**

Update `config/config.php` for production environment:

```php
// Environment Settings
if (EASEBUZZ_ENV === 'prod') {
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_PARSE);
    ini_set('log_errors', 1);
    ini_set('error_log', LOGS_DIR . 'php_errors.log');
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
```

## 10. **Post-Deployment Testing**

### Functional Testing:

- [ ] Registration form loads correctly
- [ ] Form validation works
- [ ] Payment gateway redirects properly
- [ ] Success/failure handling works
- [ ] Email notifications sent
- [ ] Receipt generation (HTML/PDF/Print)
- [ ] Secure token-based access

### Security Testing:

- [ ] CSRF protection active
- [ ] Input validation working
- [ ] Direct file access blocked
- [ ] SQL injection prevention
- [ ] XSS protection

### Performance Testing:

- [ ] Page load times acceptable
- [ ] Database queries optimized
- [ ] Email sending works
- [ ] PDF generation fast

## 11. **Monitoring & Maintenance**

### Log Files to Monitor:

- `logs/audit.log` - User actions and security events
- `logs/email_errors.log` - Email delivery issues
- `logs/php_errors.log` - PHP errors (production only)

### Regular Maintenance:

- Monitor disk space for logs and receipts
- Review audit logs for suspicious activity
- Update PHP and dependencies regularly
- Backup database daily
- Test payment gateway periodically

---

# 📁 File Structure

```
moot-court/
├── config/
│   └── config.php              # Centralized configuration
├── controllers/
│   ├── process_payment.php     # Payment initiation
│   ├── payment_success.php     # Success handler
│   └── payment_failure.php     # Failure handler
├── helpers/
│   ├── database.php            # DB connection & utilities
│   ├── payment.php             # Payment verification
│   └── email.php               # Email functions
├── vendor/
│   └── tecnickcom/tcpdf/       # PDF library (installed via Composer)
├── easebuzz-lib/               # Payment gateway library
├── payment-config/             # Legacy config (keep for compatibility)
├── logs/                       # Application logs
├── receipts/                   # Generated receipts
├── create_tables.sql           # Database schema
├── index.php                   # Registration form
├── receipt.php                 # Receipt display/download
├── .htaccess                   # Security & URL rules
└── README.md                   # This file
```

---

# 🔒 Security Features

- CSRF token validation
- Input sanitization and validation
- Prepared statements for all database queries
- Payment signature verification
- Amount validation (strict ₹300 check)
- Direct access prevention for sensitive files
- Token-based receipt access (64-character secure tokens)
- Comprehensive audit logging
- XSS protection
- SQL injection prevention

---

# 📞 Support

For technical issues or deployment questions:

- Email: itcell@gmiu.edu.in
- Logs: Check `logs/` directory for detailed error information

---

# 📄 License

© 2026 Gyanmanjari Institute of Law. All rights reserved.
