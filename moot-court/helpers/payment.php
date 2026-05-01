<?php
// helpers/payment.php - Payment gateway utilities

require_once __DIR__ . '/../config/config.php';

function generatePaymentHash($params)
{
    // Hash sequence for payment initiation: key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10|salt
    $hashSequence = ['key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5'];

    $hashString = '';
    foreach ($hashSequence as $key) {
        $hashString .= (isset($params[$key]) ? $params[$key] : '') . '|';
    }
    $hashString .= EASEBUZZ_SALT;

    return hash('sha512', $hashString);
}

function verifyPaymentResponse($response)
{
    if (!isset($response['hash'])) {
        return false;
    }

    // Reverse hash sequence for response verification: salt|status|udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key
    $reverseHashSequence = ['udf10', 'udf9', 'udf8', 'udf7', 'udf6', 'udf5', 'udf4', 'udf3', 'udf2', 'udf1', 'email', 'firstname', 'productinfo', 'amount', 'txnid', 'key'];

    $hashString = EASEBUZZ_SALT . '|' . ($response['status'] ?? '');
    foreach ($reverseHashSequence as $key) {
        $hashString .= '|' . (isset($response[$key]) ? $response[$key] : '');
    }

    $generatedHash = hash('sha512', $hashString);
    return hash_equals($generatedHash, $response['hash']);
}

function validatePaymentAmount($amount)
{
    return abs(floatval($amount) - REGISTRATION_FEE) < 0.01;
}

function getPaymentStatus($status)
{
    $statusMap = [
        'success' => 'SUCCESS',
        'failure' => 'FAILED',
        'pending' => 'PENDING',
        'cancel' => 'FAILED'
    ];
    return $statusMap[strtolower($status)] ?? 'FAILED';
}
?>