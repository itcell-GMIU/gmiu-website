<?php
include 'include/checklogin.php';
include_once('paywitheasebuzz-php-lib/easebuzz-lib/easebuzz_payment_gateway.php');
include_once('paywitheasebuzz-php-lib/easebuzz-lib/payment.php');


    // $amount = $_POST['fees_amount'];
    $exam_id = $_POST['ex_id'];
    $pay_mode = "online";
    
        // get actual fee amount 
    $cmd2 = $con->prepare("SELECT `fee_amount` FROM `tbl_exam_student` WHERE `exam_id` = ? AND `enrollnment_no` = ?");
    $cmd2->bind_param("is",$exam_id, $er_no);
    $cmd2->execute();
    $result2 = $cmd2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $amount = $row2['fee_amount'];
    }
    
    //test keys
    // $MERCHANT_KEY = "2PBP7IABZ2";
    // $SALT = "DAH88E3UWQ";
    // $ENV = "test";
    
    $MERCHANT_KEY = "CRGPBR3D4U";
    $SALT = "N0YMYUUEXZ";
    $ENV = "prod";

    $easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);

    function generateUniqueTransactionID($prefix = 'GMIUEXAM') {
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
    $stmt = $con->prepare("UPDATE `tbl_exam_student` SET `payment_mode` =?,`fee_amount` = ?, `transaction_id` = ? WHERE `exam_id` =? AND `enrollnment_no` = ?");
    $stmt->bind_param("sisis", $pay_mode, $amount, $tr_id, $exam_id, $er_no);
    $result1 = $stmt->execute();

    $postData = array(
        "txnid" => $tr_id,
        "amount" => $amount . ".0",
        "firstname" => $first_name.' '.$middle_name.' '.$last_name,
        "email" => $email,
        "phone" => $mobile_number,
        "productinfo" => "GMIU Exam",
        "surl" => "https://gmiu.edu.in/gmiu/student/success.php",
        "furl" => "https://gmiu.edu.in/gmiu/student/success.php",
        "udf1" => $exam_id, 
        "udf2" => $er_no,
        // "udf5" => $faculty_name,
        // "udf6" => $level_name,
        "udf7" => $sem." semester",

    );

    $data = _payment($postData, false, $MERCHANT_KEY, $SALT, $ENV);

    echo json_encode($data);
