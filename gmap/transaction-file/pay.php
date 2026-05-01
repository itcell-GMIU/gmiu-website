<?php
session_start();

include __DIR__ . '/../easebuzz-lib/easebuzz_payment_gateway.php';
include __DIR__ . '/config.php';
include __DIR__ . '/../../database/connect.php';

global $con;

$surl = 'http://localhost/gmiu/gmap/transaction-file/response.php';
$furl = 'http://localhost/gmiu/gmap/transaction-file/response.php';

// ✅ Check session
if (!isset($_SESSION['student_id'])) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Session Expired',
        'text' => 'Please login again to continue.',
        'redirect' => 'login.php'
    ];
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$student_email = $_SESSION['student_email'];

$stmt = $con->prepare("SELECT mobile FROM tbl_gmap_students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

$student_mobile = $data['mobile'] ?? '';
$stmt->close();

// ✅ Validate mobile
if (empty($student_mobile)) {
    $_SESSION['alert'] = [
        'type' => 'warning',
        'title' => 'Mobile Required',
        'text' => 'Please update your mobile number before making payment.',
        'redirect' => 'profile.php'
    ];
    header("Location: ../profile.php");
    exit();
}

// ✅ Check if already paid
$sql = "SELECT id FROM tbl_gmap_payments 
        WHERE student_id = ? AND payment_status = 'success' 
        LIMIT 1";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['alert'] = [
        'type' => 'success',
        'title' => 'Payment Completed',
        'text' => 'Your payment has already been completed.',
        'redirect' => 'payment.php'
    ];
    header("Location: ../payment.php");
    exit();
}

// ✅ Generate transaction ID
function generateTransactionID($prefix = 'GMAP')
{
    return $prefix . time() . rand(100, 999);
}
$txnid = generateTransactionID();

// ✅ FIXED amount (you can make dynamic later)
$amount = number_format(6000.00, 2, '.', '');

$productinfo = "GMAP Admission Token Fee";

// ✅ Insert pending payment
$insertSql = "INSERT INTO tbl_gmap_payments 
    (student_id, product_info, amount, transaction_id, payment_status) 
    VALUES (?, ?, ?, ?, 'pending')";

$stmt = $con->prepare($insertSql);
$stmt->bind_param(
    "isds",
    $student_id,
    $productinfo,
    $amount,
    $txnid
);

if (!$stmt->execute()) {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Database Error',
        'text' => 'Something went wrong while initiating payment.',
        'redirect' => 'dashboard.php'
    ];
    header("Location: ../dashboard.php");
    exit();
}
$stmt->close();

// ✅ Prepare Easebuzz data
$postData = [
    "txnid" => $txnid,
    "amount" => $amount,
    "productinfo" => $productinfo,
    "firstname" => $student_name,
    "email" => $student_email,
    "phone" => $student_mobile,
    "surl" => $surl,
    "furl" => $furl,
];

// ✅ Start payment
$easebuzzObj = new Easebuzz(EASEBUZZ_MERCHANT_KEY, EASEBUZZ_SALT, EASEBUZZ_ENV);
$response = $easebuzzObj->initiatePaymentAPI($postData);

echo $response;

// ✅ Auto-submit
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.forms[0];
        if (form) {
            form.submit();
        } else {
            alert('Payment form not generated!');
        }
    });
</script>";

exit();