<?php
session_start();
include '../../../database/connect.php';

// ==============================
// SECURITY HEADERS
// ==============================
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// ==============================
// REQUEST VALIDATION
// ==============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Invalid request.');
}

// CSRF CHECK
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit('Unauthorized request.');
}

// ==============================
// INPUT VALIDATION
// ==============================
$certificateType = $_POST['certificate_type'] ?? '';
$mobile          = $_POST['mobile'] ?? '';

$allowedTypes = ['AIML', 'CA'];

if (!in_array($certificateType, $allowedTypes, true)) {
    exit('Invalid request.');
}

if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    exit('Invalid request.');
}

// ==============================
// RATE LIMIT (IP + MOBILE)
// ==============================
$ip = $_SERVER['REMOTE_ADDR'];
$rateKey = md5($ip . $mobile);

$_SESSION['rate'][$rateKey] = $_SESSION['rate'][$rateKey] ?? ['count' => 0, 'time' => time()];

if (time() - $_SESSION['rate'][$rateKey]['time'] < 300) {
    $_SESSION['rate'][$rateKey]['count']++;
    if ($_SESSION['rate'][$rateKey]['count'] > 5) {
        http_response_code(429);
        exit('Too many attempts. Try later.');
    }
} else {
    $_SESSION['rate'][$rateKey] = ['count' => 1, 'time' => time()];
}

// ==============================
// DB QUERY (SAFE)
// ==============================
if ($certificateType === 'AIML') {
    $sql = "
        SELECT full_name 
        FROM tbl_promotional_form_data
        WHERE other_type = 'AIML'
          AND form_type = 1
          AND mobile = ?
        LIMIT 1
    ";
    $backgroundImage = __DIR__ . '/certificate_bg.jpg';
} else {
    $sql = "
        SELECT full_name 
        FROM tbl_promotional_form_data
        WHERE other_type = 'CA'
          AND form_type = 2
          AND mobile = ?
        LIMIT 1
    ";
    $backgroundImage = __DIR__ . '/ca_certificate_bg.jpg';
}

$stmt = $con->prepare($sql);
$stmt->bind_param('s', $mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    exit('No certificate found for given details.');
}

$row = $result->fetch_assoc();

// ==============================
// NAME SANITIZATION & FORMAT
// ==============================
function toProperCase($string)
{
    $string = preg_replace('/[^a-zA-Z\s]/', '', $string);
    return ucwords(strtolower(trim($string)));
}

$name = toProperCase($row['full_name']);

// ==============================
// IMAGE GENERATION
// ==============================
$fontPath = __DIR__ . '/fonts/GreatVibes-Regular.ttf';

$image = imagecreatefromjpeg($backgroundImage);
if (!$image) {
    exit('Certificate generation failed.');
}

$imgWidth = imagesx($image);

$fontSize  = 90;
$textColor = imagecolorallocate($image, 0, 0, 0);

// Measure text
$bbox = imagettfbbox($fontSize, 0, $fontPath, $name);
$textWidth = abs($bbox[2] - $bbox[0]);

// Right 70% alignment
$rightStartX = $imgWidth * 0.30;
$rightWidth  = $imgWidth * 0.70;

$x = $rightStartX + ($rightWidth - $textWidth) / 2;
$y = 780;

imagettftext(
    $image,
    $fontSize,
    0,
    (int)$x,
    (int)$y,
    $textColor,
    $fontPath,
    $name
);

// ==============================
// OUTPUT
// ==============================
header('Content-Type: image/jpeg');
header('Content-Disposition: attachment; filename="' . $certificateType . '_Certificate_' . str_replace(' ', '_', $name) . '.jpg"');

imagejpeg($image, null, 100);
imagedestroy($image);
exit;
