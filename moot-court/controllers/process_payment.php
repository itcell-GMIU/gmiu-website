<?php
// controllers/process_payment.php - Initiates payment gateway transaction

session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/database.php';
require_once __DIR__ . '/../helpers/payment.php';
require_once __DIR__ . '/../easebuzz-lib/easebuzz_payment_gateway.php';

// Prevent direct access
if (!isset($_GET['reg_id']) || !is_numeric($_GET['reg_id'])) {
    header("Location: ../index.php");
    exit;
}

$registration_id = (int) $_GET['reg_id'];

// Fetch registration details
$db = getDB();
$stmt = mysqli_prepare($db, "SELECT * FROM m_registrations WHERE id = ? AND status = 'PENDING'");
mysqli_stmt_bind_param($stmt, "i", $registration_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$registration = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$registration) {
    logActivity('invalid_registration_access', '', "Attempted access to registration ID: $registration_id");
    header("Location: ../index.php");
    exit;
}

// Check if already paid
if ($registration['status'] !== 'PENDING') {
    // Get receipt token for redirect
    $stmt = mysqli_prepare($db, "SELECT receipt_token FROM m_registrations WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $registration_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reg_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    header("Location: ../receipt.php?reg_id=" . $registration_id . "&token=" . urlencode($reg_data['receipt_token']));
    exit;
}

// Initialize payment gateway
$easebuzz = new Easebuzz(EASEBUZZ_MERCHANT_KEY, EASEBUZZ_SALT, EASEBUZZ_ENV);

// Prepare payment parameters
$paymentData = [
    'key' => EASEBUZZ_MERCHANT_KEY,
    'txnid' => 'TXN' . time() . $registration_id,
    'amount' => number_format(REGISTRATION_FEE, 2, '.', ''),  // Format as string with 2 decimals
    'productinfo' => 'Moot Court Registration Fee',
    'firstname' => $registration['team_member_1'],
    'email' => $registration['email'],
    'phone' => $registration['mobile'],
    'surl' => PAYMENT_SUCCESS_URL,
    'furl' => PAYMENT_FAILURE_URL,
    'udf1' => $registration_id,
    'udf2' => '',
    'udf3' => '',
    'udf4' => '',
    'udf5' => ''
];

// Generate hash
$hash = generatePaymentHash($paymentData);
$paymentData['hash'] = $hash;

// Log payment initiation
logActivity('payment_initiated', $registration['email'], "Transaction ID: {$paymentData['txnid']}, Registration ID: $registration_id");

// Redirect to payment gateway
try {
    $easebuzz->initiatePaymentAPI($paymentData);
} catch (Exception $e) {
    // Log the error and show a user-friendly message
    logActivity('payment_error', $registration['email'], "Payment initiation failed: " . $e->getMessage());
    echo "Payment gateway error. Please try again later.";
    exit;
}
?>