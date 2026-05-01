<?php
session_start();

include __DIR__ . '/../easebuzz-lib/easebuzz_payment_gateway.php';
include __DIR__ . '/config.php';
include __DIR__ . '/../../database/connect.php';

global $con;

// ✅ Get response
$easebuzzObj = new Easebuzz(EASEBUZZ_MERCHANT_KEY, EASEBUZZ_SALT, EASEBUZZ_ENV);
$response = $easebuzzObj->easebuzzResponse($_POST);

$responseData = json_decode($response);

// ❌ Invalid response
if (!$responseData) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Invalid Response',
        'text' => 'Invalid response from payment gateway.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}

// ✅ Determine status
$txnDataStatus = '';
if (isset($responseData->data->status)) {
    $txnDataStatus = strtolower(trim($responseData->data->status));
} elseif (isset($responseData->status)) {
    $txnDataStatus = ($responseData->status == 1) ? 'success' : 'failed';
} else {
    $txnDataStatus = 'failed';
}

$successStates = ['success', 'captured', 'completed'];
$isSuccess = in_array($txnDataStatus, $successStates, true);

$status = $isSuccess ? 'success' : 'failed';

// ✅ Message
$paymentMsg = $isSuccess
    ? "Your payment has been completed successfully."
    : (!empty($responseData->data->error_Message)
        ? $responseData->data->error_Message
        : "Payment failed. Please try again.");

// ✅ Extract data
$txnid = $responseData->data->txnid ?? '';
$easepayid = $responseData->data->easepayid ?? '';
$hash = $responseData->data->hash ?? '';
$mode = $responseData->data->mode ?? '';
$rawResponse = $response;

// ❌ Invalid txn
if (empty($txnid)) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Invalid Transaction',
        'text' => 'Transaction ID is missing.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}

// ✅ Get payment record
$stmt = $con->prepare("
    SELECT id, student_id, payment_status 
    FROM tbl_gmap_payments 
    WHERE transaction_id = ? 
    LIMIT 1
");
$stmt->bind_param("s", $txnid);
$stmt->execute();
$result = $stmt->get_result();

if (!$row = $result->fetch_assoc()) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Transaction Not Found',
        'text' => 'No matching payment record found.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}

$student_id = $row['student_id'];
$current_status = $row['payment_status'];

$stmt->close();

// 🔒 Already processed
if ($current_status === 'success') {
    $_SESSION['alert'] = [
        'type' => 'info',
        'title' => 'Already Processed',
        'text' => 'This payment has already been processed.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}

// ✅ Update payment
$stmt = $con->prepare("
    UPDATE tbl_gmap_payments
    SET payment_status = ?, easepay_id = ?, hash = ?, mode = ?, gateway_response = ?, payment_date = NOW()
    WHERE transaction_id = ?
");

$stmt->bind_param(
    "ssssss",
    $status,
    $easepayid,
    $hash,
    $mode,
    $rawResponse,
    $txnid
);

if (!$stmt->execute()) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Database Error',
        'text' => 'Failed to update payment status.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}
$stmt->close();

// ✅ (Optional) Update student table if success
// if ($isSuccess) {
//     $stmt = $con->prepare("
//         UPDATE tbl_gmap_students 
//         SET is_pay = 1, payment_status = 1 
//         WHERE id = ?
//     ");
//     $stmt->bind_param("i", $student_id);
//     $stmt->execute();
//     $stmt->close();
// }

// ✅ Set session
// ✅ Restore full student session
$stmt = $con->prepare("
    SELECT surname, student_name, email 
    FROM tbl_gmap_students 
    WHERE id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

$_SESSION['student_id'] = $student_id;
$_SESSION['student_name'] = $user['surname'] . ' ' . $user['student_name'];
$_SESSION['student_email'] = $user['email'];

// ✅ Final alert
$_SESSION['alert'] = [
    'type' => $isSuccess ? 'success' : 'error',
    'title' => $isSuccess ? 'Payment Successful' : 'Payment Failed',
    'text' => $paymentMsg,
    'redirect' => 'payment.php'
];

header("Location: ../payment.php");
exit();