<?php
// helpers/database.php - Database connection and utilities

require_once __DIR__ . '/../config/config.php';

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->connection) {
            $this->logError("Database connection failed: " . mysqli_connect_error());
            die("Database connection error. Please try again later.");
        }

        // Set charset
        if (!mysqli_set_charset($this->connection, 'utf8mb4')) {
            $this->logError("Error setting charset: " . mysqli_error($this->connection));
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function prepare($sql)
    {
        $stmt = mysqli_prepare($this->connection, $sql);
        if (!$stmt) {
            $this->logError("Prepare failed: " . mysqli_error($this->connection));
        }
        return $stmt;
    }

    public function lastInsertId()
    {
        return mysqli_insert_id($this->connection);
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);
        if (!$result) {
            $this->logError("Query failed: " . mysqli_error($this->connection));
        }
        return $result;
    }

    private function logError($message)
    {
        $logFile = LOGS_DIR . 'db_errors.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }
}

// Helper functions
function getDB()
{
    return Database::getInstance()->getConnection();
}

function sanitize($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateMobile($mobile)
{
    return preg_match('/^[6-9]\d{9}$/', $mobile);
}

function generateCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH / 2));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function logActivity($action, $email = null, $details = null)
{
    $db = getDB();
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    $stmt = mysqli_prepare($db, "INSERT INTO m_audit_logs (action, email, ip_address, user_agent, details) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $action, $email, $ip, $userAgent, $details);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function checkDuplicateEmail($email)
{
    $db = getDB();
    $stmt = mysqli_prepare($db, "SELECT id, status FROM m_registrations WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$row) {
            return false; // No registration found, allow registration
        }

        // If status is SUCCESS, block registration
        if ($row['status'] === 'SUCCESS') {
            return true; // Duplicate found
        }

        // If status is PENDING or FAILED, allow re-registration
        return false;
    }
    return false;
}

function checkExistingRegistration($email)
{
    $db = getDB();
    $stmt = mysqli_prepare($db, "SELECT id, status, created_at FROM m_registrations WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    }
    return null;
}
?>