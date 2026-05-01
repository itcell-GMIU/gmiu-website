<?php
// controllers/payment_success.php - Handles successful payment response

session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/database.php';
require_once __DIR__ . '/../helpers/payment.php';
require_once __DIR__ . '/../helpers/email.php';

// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

// Get payment response
$response = $_POST;

// Log the raw response
logActivity('payment_response_received', $response['email'] ?? '', json_encode($response));

// Verify payment signature
if (!verifyPaymentResponse($response)) {
    logActivity('payment_verification_failed', $response['email'] ?? '', 'Hash verification failed');
    // DEV: Payment signature verification failed - check merchant key/salt or environment config
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                html: '<div class=\"text-center\"><p>We could not verify your payment at this time.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again or contact support if the problem persists.</p></div>',
                confirmButtonText: 'Try Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Payment%20Verification%20Issue&body=Payment%20verification%20failed.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

// Validate payment amount
if (!validatePaymentAmount($response['amount'])) {
    logActivity('payment_amount_mismatch', $response['email'] ?? '', "Amount: {$response['amount']}, Expected: " . REGISTRATION_FEE);
    // DEV: Payment amount validation failed - check REGISTRATION_FEE constant
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                html: '<div class=\"text-center\"><p>There was an issue with your payment amount.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again or contact support if the problem persists.</p></div>',
                confirmButtonText: 'Try Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Payment%20Amount%20Issue&body=Payment%20amount%20validation%20failed.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

// Get registration ID from UDF1
$registration_id = (int) ($response['udf1'] ?? 0);
if (!$registration_id) {
    logActivity('invalid_registration_id', $response['email'] ?? '', 'UDF1 missing or invalid');
    // DEV: Registration ID (UDF1) missing or invalid from payment response
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Payment Failed',
                html: '<div class=\"text-center\"><p>We could not process your payment due to missing information.</p><p class=\"text-sm text-gray-600 mt-2\">Please try registering again or contact support.</p></div>',
                confirmButtonText: 'Register Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Payment%20Processing%20Issue&body=Registration%20ID%20missing%20during%20payment.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

// Fetch registration
$db = getDB();
$stmt = mysqli_prepare($db, "SELECT * FROM m_registrations WHERE id = ?");
if (!$stmt) {
    logActivity('database_error', '', "Failed to prepare registration fetch statement: " . mysqli_error($db));
    // DEV: Database error - failed to prepare registration fetch statement
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Service Temporarily Unavailable',
                html: '<div class=\"text-center\"><p>Our payment processing service is temporarily unavailable.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again in a few minutes or contact support.</p></div>',
                confirmButtonText: 'Try Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Service%20Unavailable&body=Payment%20processing%20service%20is%20temporarily%20unavailable.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}
mysqli_stmt_bind_param($stmt, "i", $registration_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$registration = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$registration) {
    logActivity('registration_not_found', $response['email'] ?? '', "Registration ID: $registration_id");
    // DEV: Registration record not found in database
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Not Found',
                html: '<div class=\"text-center\"><p>We could not find your registration record.</p><p class=\"text-sm text-gray-600 mt-2\">Please check your registration details or contact support.</p></div>',
                confirmButtonText: 'Check Registration',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Registration%20Not%20Found&body=Cannot%20find%20registration%20record%20during%20payment.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

// Check if already processed
$stmt = mysqli_prepare($db, "SELECT id FROM m_transactions WHERE transaction_id = ?");
if (!$stmt) {
    logActivity('database_error', $registration['email'], "Failed to prepare transaction check statement: " . mysqli_error($db));
    // DEV: Database error - failed to prepare transaction duplicate check statement
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Service Temporarily Unavailable',
                html: '<div class=\"text-center\"><p>Our payment processing service is temporarily unavailable.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again in a few minutes or contact support.</p></div>',
                confirmButtonText: 'Try Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Service%20Unavailable&body=Payment%20processing%20service%20is%20temporarily%20unavailable.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}
mysqli_stmt_bind_param($stmt, "s", $response['txnid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$existing_transaction = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($existing_transaction) {
    logActivity('duplicate_transaction', $registration['email'], "Transaction ID: {$response['txnid']}");
    // Get receipt token for redirect
    $stmt = mysqli_prepare($db, "SELECT receipt_token FROM m_registrations WHERE id = ?");
    if (!$stmt) {
        logActivity('database_error', $registration['email'], "Failed to prepare receipt token fetch statement: " . mysqli_error($db));
        // DEV: Database error - failed to prepare receipt token fetch for duplicate transaction
        echo "<!DOCTYPE html>
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Payment Already Processed',
                    html: '<div class=\"text-center\"><p>This payment has already been processed.</p><p class=\"text-sm text-gray-600 mt-2\">Please check your email for the receipt or contact support if you need assistance.</p></div>',
                    confirmButtonText: 'Check Email',
                    cancelButtonText: 'Contact Support',
                    confirmButtonColor: '#1e3a8a',
                    cancelButtonColor: '#6b7280',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'mailto:' + encodeURIComponent('$registration[email]') + '?subject=Check%20My%20Receipt&body=Please%20resend%20my%20receipt.';
                    } else {
                        window.location.href = 'mailto:support@gmiu.edu.in?subject=Duplicate%20Payment%20Issue&body=Received%20duplicate%20payment%20notification.%20Please%20help.';
                    }
                });
            </script>
        </body>
        </html>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $registration_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reg_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    header("Location: ../receipt.php?reg_id=" . $registration_id . "&token=" . urlencode($reg_data['receipt_token']));
    exit;
}

// Insert transaction record
$payment_status = getPaymentStatus($response['status']);
$payment_time = isset($response['addedon']) ? date('Y-m-d H:i:s', strtotime($response['addedon'])) : date('Y-m-d H:i:s');
$payment_method = $response['mode'] ?? 'Unknown';
$easepay_id = $response['easepayid'] ?? '';
$raw_response = json_encode($response);

$sql = "INSERT INTO m_transactions (registration_id, transaction_id, easepay_id, payment_status, payment_amount, payment_method, payment_time, payment_raw_response) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($db, $sql);

if (!$stmt) {
    logActivity('database_error', $registration['email'], "Failed to prepare transaction insert statement: " . mysqli_error($db));
    // DEV: Database error - failed to prepare transaction insert statement (check m_transactions table schema)
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Payment Processing Failed',
                html: '<div class=\"text-center\"><p>We encountered an issue while processing your payment.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again or contact support if the problem persists.</p></div>',
                confirmButtonText: 'Try Again',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Payment%20Processing%20Failed&body=Payment%20processing%20encountered%20an%20issue.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

mysqli_stmt_bind_param($stmt, "isssdsss", $registration_id, $response['txnid'], $easepay_id, $payment_status, $response['amount'], $payment_method, $payment_time, $raw_response);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Update registration status
if ($payment_status === 'SUCCESS') {
    $stmt = mysqli_prepare($db, "UPDATE m_registrations SET status = 'SUCCESS' WHERE id = ?");
    if (!$stmt) {
        logActivity('database_error', $registration['email'], "Failed to prepare registration update statement: " . mysqli_error($db));
        // DEV: Database error - failed to prepare registration status update to SUCCESS
        echo "<!DOCTYPE html>
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Processing Failed',
                    html: '<div class=\"text-center\"><p>Your payment was successful but we encountered an issue updating your registration.</p><p class=\"text-sm text-gray-600 mt-2\">Please contact support immediately with your transaction details.</p></div>',
                    confirmButtonText: 'Contact Support',
                    confirmButtonColor: '#b91c1c'
                }).then(() => {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Registration%20Update%20Failed&body=Payment%20successful%20but%20registration%20status%20update%20failed.%20Transaction%20ID:%20{$response['txnid']}%20Please%20help.';
                });
            </script>
        </body>
        </html>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $registration_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Send confirmation email
    sendConfirmationEmail($registration['email'], $registration, [
        'transaction_id' => $response['txnid'],
        'payment_amount' => $response['amount'],
        'payment_method' => $response['mode'] ?? 'Unknown',
        'payment_time' => $payment_time
    ]);

    logActivity('payment_success', $registration['email'], "Transaction ID: {$response['txnid']}");
} else {
    $stmt = mysqli_prepare($db, "UPDATE m_registrations SET status = 'FAILED' WHERE id = ?");
    if (!$stmt) {
        logActivity('database_error', $registration['email'], "Failed to prepare registration failed update statement: " . mysqli_error($db));
        // DEV: Database error - failed to prepare registration status update to FAILED
        echo "<!DOCTYPE html>
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    html: '<div class=\"text-center\"><p>Your payment could not be processed.</p><p class=\"text-sm text-gray-600 mt-2\">Please try again or contact support if the problem persists.</p></div>',
                    confirmButtonText: 'Try Again',
                    cancelButtonText: 'Contact Support',
                    confirmButtonColor: '#1e3a8a',
                    cancelButtonColor: '#6b7280',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../index.php';
                    } else {
                        window.location.href = 'mailto:support@gmiu.edu.in?subject=Payment%20Failed&body=Payment%20processing%20failed.%20Please%20help.';
                    }
                });
            </script>
        </body>
        </html>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $registration_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    logActivity('payment_failed', $registration['email'], "Status: $payment_status, Transaction ID: {$response['txnid']}");
}

// Redirect to receipt
$_SESSION['payment_success'] = true;
$_SESSION['success_message'] = 'Payment successful! Your registration has been confirmed.';

// Get receipt token for redirect
$stmt = mysqli_prepare($db, "SELECT receipt_token FROM m_registrations WHERE id = ?");
if (!$stmt) {
    logActivity('database_error', $registration['email'], "Failed to prepare receipt token fetch statement: " . mysqli_error($db));
    // DEV: Database error - failed to prepare receipt token fetch statement
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                html: '<div class=\"text-center\"><p>Your payment has been processed successfully.</p><p class=\"text-sm text-gray-600 mt-2\">Please check your email for the receipt or contact support if you need assistance.</p></div>',
                confirmButtonText: 'Check Email',
                cancelButtonText: 'Contact Support',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'mailto:' + encodeURIComponent('$registration[email]') + '?subject=Check%20My%20Receipt&body=Please%20resend%20my%20receipt.';
                } else {
                    window.location.href = 'mailto:support@gmiu.edu.in?subject=Receipt%20Access%20Issue&body=Payment%20successful%20but%20cannot%20access%20receipt.%20Please%20help.';
                }
            });
        </script>
    </body>
    </html>";
    exit;
}
mysqli_stmt_bind_param($stmt, "i", $registration_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$reg_data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

header("Location: ../receipt.php?reg_id=" . $registration_id . "&token=" . urlencode($reg_data['receipt_token']));
exit;
?>