<?php

include_once('paywitheasebuzz-php-lib/easebuzz-lib/easebuzz_payment_gateway.php');
include_once('paywitheasebuzz-php-lib/easebuzz-lib/payment.php');
include 'include/checklogin.php';
/* $SALT = "ABC55E8IBW";  */
// $SALT = "DAH88E3UWQ"; //Set $SALT
$SALT = "N0YMYUUEXZ";
$easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
$result = $easebuzzObj->easebuzzResponse($_POST['response']);

$final_result = json_decode($result);
/* print_r($final_result);
exit(); */
if ($final_result->status == 1) {
    $payment_status = $final_result->data->status;
    $payment_id = $final_result->data->easepayid;
    $txnid = $final_result->data->txnid;
    $ex_id = $final_result->data->udf1;
    $er_num = $final_result->data->udf2;

    if ($payment_status == "success") {
        $form_status = 3;
    } else {
        $form_status = 1;
    }

    $payment_response = json_encode($result);

    $stmt = $con->prepare("UPDATE `tbl_exam_student` SET `status` =? , `payment_status` = ? , `payment_response` = ?, `payment_date` = CURRENT_TIMESTAMP , `payment_id` = ? WHERE `exam_id` =? AND `enrollnment_no` = ?");
    $stmt->bind_param("isssis", $form_status, $payment_status, $payment_response, $payment_id, $ex_id, $er_num);
    $result1 = $stmt->execute();

    if ($result1 && $payment_status == "success") {
        $_SESSION['status'] = "Payment Successfull!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='examform.php'},1000)</script>";
    } else if ($result1 && $payment_status == "failure") {
        $_SESSION['status'] = "Payment Failed!";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='examform.php'},1000)</script>";
    } else {
        echo "error";
    }
} else {
    echo "error 2";
    exit();
}
