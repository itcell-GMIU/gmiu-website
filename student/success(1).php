<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Modify your database connection details
$dbuser = "u977112581_gmiutest";
$dbpass = "Test@123?";
$host = "localhost";
$db = "u977112581_gmiutest";

// Create a new mysqli connection and set collation to utf8mb4
$con = new mysqli($host, $dbuser, $dbpass, $db);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$con->set_charset("utf8mb4");

    $payment_response = json_encode($_POST);
    $payment_status = $_POST['status'];
    $er_number = $_POST['udf2'];
    $ex_id = $_POST['udf1'];
    $payment_id = $_POST['easepayid'];
    $form_status = '3';
    
if (!isset($_SESSION['student_id'])) {
    $cmd = $con->prepare("SELECT stu.id as student_id, stu.enrollnment_no as enrollnment_no from tbl_students_2023 as stu
      LEFT JOIN tbl_exam_student as es ON stu.enrollnment_no = es.enrollnment_no WHERE es.enrollnment_no = ? AND es.exam_id = ?");
    
    if ($cmd) {
        $cmd->bind_param("si", $er_number, $ex_id);
        $cmd->execute();
        $ex = $cmd->get_result();
    
        if ($ex->num_rows == 1) {
            $row = mysqli_fetch_array($ex);
            $student_id = $row['student_id'];
            $enrollnment_no = $row['enrollnment_no'];
            $_SESSION['student_id'] = $student_id;
            $_SESSION['secretkey'] = "secret";
        }
    } else {
        die("Prepare statement failed: " . $con->error);
    }
}

$stmt = $con->prepare("UPDATE `tbl_exam_student` SET `status` = ?, `payment_status` = ?, `payment_response` = ?, `payment_date` = CURRENT_TIMESTAMP, `payment_id` = ? WHERE `exam_id` = ? AND `enrollnment_no` = ?");

if ($stmt) {
    $stmt->bind_param("isssis", $form_status, $payment_status, $payment_response, $payment_id, $ex_id, $er_number);
    $result1 = $stmt->execute();
    
    if ($result1 && $payment_status = "success") {
        // if ($result1) {
        $_SESSION['status'] = "Payment Successful!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='examform_payment.php'},1000)</script>";
    } else {
        echo "Error";
    }
} else {
    die("Prepare statement failed: " . $con->error);
}
?>
