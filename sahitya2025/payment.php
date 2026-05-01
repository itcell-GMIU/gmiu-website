<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include './dbconnect.php';
include './operations.php';

include_once('easebuzz-lib/easebuzz_payment_gateway.php');
include_once('easebuzz-lib/payment.php');
function send_mail($to, $subject, $message)
{
    $from = "info@gmiu.edu.in";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $check = mail($to, $subject, $message, $headers);

    if ($check) {
        return true;
    } else {
        $error = error_get_last();
        $error_message = $error['message'];
        //echo "An error occurred while sending the email: $error_message";
        return $error_message;
    }
}
// echo "<pre>";
// print_r($_POST);

// $amount = 50;
$pay_mode = "online";
$contact_no = isset($_POST['contact']) ? preg_replace('/\D/', '', $_POST['contact']) : null; // Remove non-numeric characters
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : null;
$name = isset($_POST['name']) ? htmlspecialchars(strip_tags($_POST['name']), ENT_QUOTES, 'UTF-8') : null;
$competitions = isset($_POST['games']) && is_array($_POST['games']) ? array_map('htmlspecialchars', $_POST['games']) : array();
$deptname = isset($_POST['deptname']) ? htmlspecialchars(strip_tags($_POST['deptname']), ENT_QUOTES, 'UTF-8') : null;
$clgname = isset($_POST['clgname']) ? htmlspecialchars(strip_tags($_POST['clgname']), ENT_QUOTES, 'UTF-8') : null;
$title = isset($_POST['title']) ? htmlspecialchars(strip_tags($_POST['title']), ENT_QUOTES, 'UTF-8') : null;

// Validation
$errors = [];

// Validate Contact Number (must be 10-15 digits)
if (empty($contact_no) || !preg_match('/^\d{10,15}$/', $contact_no)) {
    $errors[] = "Invalid contact number!";
}

// Validate Email
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format!";
}

// Validate Name (only letters & spaces, max 100 chars)
if (empty($name) || !preg_match('/^[a-zA-Z\s.]+$/', $name) || strlen($name) > 100) {
    $errors[] = "Invalid name!";
}

// Validate Competitions
if (!is_array($competitions) || count($competitions) === 0) {
    $errors[] = "Please select at least one competition!";
}

// // Validate Department Name (only letters & spaces, max 100 chars)
// if (!preg_match('/^[a-zA-Z\s.]+$/', $deptname) || strlen($deptname) > 100) {
//     $errors[] = "Invalid Designation name!";
// }

// // Validate College Name (only letters, spaces, and special chars, max 150 chars)
// if (empty($clgname) || strlen($clgname) > 150) {
//     $errors[] = "Invalid Institute name!";
// }

// // Validate Title (only letters, spaces, and special chars, max 150 chars)
// if (!preg_match('/^[a-zA-Z\s.]+$/', $title)  || strlen($title) > 150) {
//     $errors[] = "Invalid title!";
// }

// If there are errors, show them and stop execution
if (!empty($errors)) {
    echo "<script>alert('" . implode("\\n", $errors) . "'); window.location.href='index.php';</script>";
    exit();
}


$compSerialized = serialize($competitions);
$competitionsCS = implode(',', $competitions);

// $MERCHANT_KEY = "2PBP7IABZ2";
// $SALT = "DAH88E3UWQ";
// $ENV = "test";

$MERCHANT_KEY = "CRGPBR3D4U";
$SALT = "N0YMYUUEXZ";
$ENV = "prod";

$easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);

function generateUniqueTransactionID($prefix = 'exhgmiu')
{
    // Generate a timestamp
    $timestamp = date('YmdHis');

    // Generate a unique identifier (you can customize this part)
    $uniqueIdentifier = strtoupper(uniqid());

    // Generate a random number to add to the ID
    $randomNumber = rand(1000, 9999);

    // Combine the elements to create a unique ID
    $transactionID = $prefix . $timestamp . $uniqueIdentifier . $randomNumber;

    return $transactionID;
}

// Usage
$uniqueTransactionID = generateUniqueTransactionID();

$tr_id = $uniqueTransactionID;

$success = "success";

$title = preg_replace('/[^a-zA-Z0-9 ]/', '', $title);
$contact_no = preg_replace('/[^a-zA-Z0-9 ]/', '', $contact_no);
$name = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
$deptname = preg_replace('/[^a-zA-Z0-9 ]/', '', $deptname);
$title = preg_replace('/[^a-zA-Z0-9 ]/', '', $title);

// Check if the record already exists
$checkStmt = $con->prepare("SELECT * FROM `tbl_registers` WHERE `mobile` = ? AND `payment_status` = ?");
$checkStmt->bind_param("ss", $contact_no, $success);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    while ($row2 = $checkResult->fetch_assoc()) {
        $rid = $row2['payment_id'];
    }
    $rid = md5($rid);
    // Record with the same name and number already exists
    // echo "<script>alert('You are already Registered.'); window.location.href='index.php';</script>";
    echo "<script>alert('You are already Registered.'); window.location.href='reciept.php?rid=$rid';</script>";
    exit;
}
// echo $competitions;
$total_fees = 0;
foreach ($competitions as $comp) {
    $crud->readSingleRecordColumn("tbl_competetion", "fees", ["id" => $comp, "is_active" => 1], $comp_fees);
    $total_fees = $total_fees + $comp_fees;
    // echo $comp.' - Rs.'.$total_fees;
    // echo "<br>";
}
$total_fees = number_format(floatval($total_fees), 2);

$stmt_check = $con->prepare("SELECT * FROM `tbl_registers` WHERE `mobile` = ?");
$stmt_check->bind_param("s", $contact_no);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$insertedId = 0;
if ($result_check->num_rows == 0) {
    // Record doesn't exist, so insert it
    // If no existing record, proceed with the insertion
    $stmt = $con->prepare("INSERT INTO `tbl_registers`(`name`, `email`, `mobile`, `payment_mode`, `fee_amount`, `transaction_id`, `competitions`, `deptname`, `clg_name`, `title`) VALUES(?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $name, $email, $contact_no, $pay_mode, $total_fees, $tr_id, $compSerialized, $deptname, $clgname, $title);

    $result1 = $stmt->execute();

    if ($result1) {
        // Get the ID of the last inserted row
        $insertedId = $con->insert_id;
        // echo "The inserted row ID is: " . $insertedId;
    } else {
        echo "Error: " . $stmt->error;
    }
}

if ($total_fees > 0) {
    $postData = array(
        "txnid" => $tr_id,
        "amount" => $total_fees,
        "firstname" => $name,
        "email" => $email,
        "phone" => $contact_no,
        "productinfo" => "sahitya2025",
        "surl" => $baseUrl . "success.php",
        "furl" => $baseUrl . "fail.php",
        "udf1" => $competitionsCS
    );

    $data = $easebuzzObj->initiatePaymentAPI($postData);
    $data = json_decode($data);

    echo "<script>alert('{$data->data}'); window.location.href='index.php';</script>";
} else {
    $updateConditions = array("mobile" => $contact_no, "is_active" => 1);
    $updateData = array("payment_status" => "success");
    $updateResult = $crud->updateRecords("tbl_registers", $updateConditions, $updateData);

    if ($updateResult) {
        echo "<script>alert('Registration Successfull!'); window.location.href='index.php';</script>";
    }
}
exit;
