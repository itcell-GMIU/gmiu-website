<?php

include_once('paywitheasebuzz-php-lib/easebuzz-lib/easebuzz_payment_gateway.php');
include_once('paywitheasebuzz-php-lib/easebuzz-lib/payment.php');
include 'include/checklogin.php';
//$SALT = "ABC55E8IBW"; 
$SALT = "N0YMYUUEXZ"; //Set $SALT
$easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
$result = $easebuzzObj->easebuzzResponse($_POST['response']);

$final_result = json_decode($result);
/* print_r($final_result);
exit(); */
if ($final_result->status == 1) {
    $payment_status = $final_result->data->status;
    $payment_id = $final_result->data->easepayid;
    $txnid = $final_result->data->txnid;
    $payment_detail_status = 1;
   /*  $account_office_status="submitted"; */
    $payment_date_time = date('Y-m-d');
    $gr_number = generate_gr_number($stu_faculty_shortname, $student_id);
    $stmt = $con->prepare("UPDATE `tbl_admission_student` SET account_office_status=?,payment_detail_status=?,payment_date_time=?, gr_number=?, payment_id = ?,payment_status = ? ,payment_response=?  WHERE transaction_id = ? ");
    $stmt->bind_param("sissssss",$account_office_status, $payment_detail_status, $payment_date_time, $gr_number, $payment_id, $payment_status, $result, $txnid);
    if ($stmt->execute()) {
        if($payment_status=="success")
        {
            $subject = "Successful  Payment";
            $message = "Dear Applicant, <br>
                        Your Payment is successfully done.Your GR number is <b>{$gr_number}</b> to know more,</br>please feel free to call us at 9099951160
                        or we will reach out to you shortly.
                        Keep visiting our website regularly for updates.
                        <br>
                        <b>Note::Online Application does not guarantee Admission.</b><br>
                        <br>
                        <br>
                        -GMIU
                        ";
            $to = $stu_email;
            send_mail($to, $subject, $message);
        }
      
     
        echo "success";
    }
} else {
    echo "error";
    exit();
}