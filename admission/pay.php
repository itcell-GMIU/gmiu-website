<?php

include_once('paywitheasebuzz-php-lib/easebuzz-lib/easebuzz_payment_gateway.php');
include_once('paywitheasebuzz-php-lib/easebuzz-lib/payment.php');
include 'include/checklogin.php';

$faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
$level_id = mysqli_real_escape_string($con, $_POST['level_id']);
$program_id = mysqli_real_escape_string($con, $_POST['program_id']);
$mode = mysqli_real_escape_string($con, $_POST['mode']);
$payment_mode = "online";

// new fields from form
$feedback_source = mysqli_real_escape_string($con, $_POST['feedback_source']);
$referral_code = !empty($_POST['referral_code']) ? mysqli_real_escape_string($con, $_POST['referral_code']) : null;
$admission_year = mysqli_real_escape_string($con, $_POST['admission_year']);
$method = mysqli_real_escape_string($con, $_POST['method']);


// $MERCHANT_KEY = "CRGPBR3D4U";
// $SALT = "N0YMYUUEXZ";
// $ENV = "prod";

$MERCHANT_KEY = "10PBP71ABZ2";
$SALT = "ABC55E8IBW";
$ENV = "test";

$easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);
$is_active = 1;
$is_delete = 0;
if ($mode == "regular") {
    $cmd = "Select pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
} else if ($mode == "genius") {
    $cmd = "Select pro.token_genius as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
} else if ($mode == "minor") {
    $cmd = "Select pro.token_minor as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
} else {
    $cmd = "Select pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
}

//$query = "SELECT token FROM tbl_program WHERE id = $program_id AND is_active = ?  AND is_delete=0";

$stmt = $con->prepare($cmd);
$stmt->bind_param("iii", $program_id, $is_active, $is_delete);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fetch = $result->fetch_assoc();
    $token_amount = $fetch['token'];
} else {
    echo "error";
    exit();
}

$transaction_id = 'Gmiu' . rand(1, 10000000);

$payment_id = "";
$stmt = $con->prepare("UPDATE `tbl_admission_student` SET payment_mode=?, mode = ? ,token_amount = ?,faculty_id = ?,level_id = ?,program_id= ? ,transaction_id= ? WHERE id = $student_id ");
$stmt->bind_param("ssdiiis", $payment_mode, $mode, $token_amount, $faculty_id, $level_id, $program_id, $transaction_id, );
if ($stmt->execute()) {

    // Step 1: Soft delete old feedback if exists
    $stmt_check = $con->prepare("SELECT id, feedback_source, referral_code FROM tbl_admission_feedback WHERE student_id = ? AND is_active = 1 AND is_delete = 0 LIMIT 1");
    $stmt_check->bind_param("i", $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    $skip_insert = false;

    if ($result_check->num_rows > 0) {
        // ✅ If feedback_source and referral_code are the same, skip update/insert
        if ($row['feedback_source'] === $feedback_source && $row['referral_code'] === $referral_code) {
            $skip_insert = true;
        } else {
            // Otherwise soft delete the old one

            $stmt_update = $con->prepare("UPDATE tbl_admission_feedback 
                                  SET is_active = 0, is_delete = 1 
                                  WHERE student_id = ?");
            $stmt_update->bind_param("i", $student_id);
            $stmt_update->execute();
            $stmt_update->close();
        }
    }
    $stmt_check->close();

    // Step 2: Insert fresh feedback entry only if not skipping
    if (!$skip_insert) {
        // Step 2: Insert fresh feedback entry

        $stmt_fb = $con->prepare("INSERT INTO tbl_admission_feedback 
        (student_id, method, feedback_source, referral_code, admission_year) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt_fb->bind_param(
            "issss",
            $student_id,
            $method,
            $feedback_source,
            $referral_code,
            $admission_year
        );
        $stmt_fb->execute();
    }

    $postData = array(
        "txnid" => $transaction_id,
        "amount" => $token_amount . '.0',
        "firstname" => $stu_first_name . " " . $stu_middle_name . " " . $stu_last_name,
        "email" => $stu_email,
        "phone" => $stu_number,
        "productinfo" => "For Admission in GMIU",
        "surl" => "https://gmiu.edu.in/gmiu/api/easebuzz/success.php",
        "furl" => "https://gmiu.edu.in/gmiu/api/easebuzz/failed.php",
    );

    $data = $easebuzzObj->initiatePaymentAPI($postData);

    $response = [
        'status' => 200,
        'message' => 'Success',
        'data' => $data
    ];


} else {

    $response = [
        'status' => 400,
        'message' => 'error',
        'data' => null
    ];

}
echo json_encode($response);