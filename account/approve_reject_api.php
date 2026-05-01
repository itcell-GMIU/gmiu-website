<?php
include "include/checklogin.php";


$col_name = $_POST['name'];
$updateId = $_POST['student_id'];

if ($col_name == 'approved') {

$cmd = "SELECT `payment_mode` FROM `tbl_admission_student` WHERE `id` = ?";
  $stmt = $con->prepare($cmd);
  $stmt->bind_param("i", $updateId);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $payment_mode = $row['payment_mode'];
    if ( $payment_mode == "online") {
        $update = $con->prepare(
            "UPDATE tbl_admission_student SET `payment_status` = ?,`account_office_status` = ?,`account_office_approve_reject_date` =?  WHERE id = ?"
        );
       
        $payment_status = 'success';
        $account_office_status = 'approved';
        $account_office_approve_reject_date = date('Y-m-d');
      
        $update->bind_param(
            "sssi",
            $payment_status,
            $account_office_status,
            $account_office_approve_reject_date,
            $updateId
        );
        $result = $update->execute();
        if ($result) {
            $response = [
                "status" => 200,
                "message" => "approved",
            ];
        } else {
            $response = [
                "status" => 400,
                "message" => $con->error,
            ];
        }
    } else{
        $update = $con->prepare(
            "UPDATE tbl_admission_student SET `payment_status` = ?,payment_date_time=?,`account_office_status` = ?,`account_office_approve_reject_date` =?  WHERE id = ?"
        );
        $payment_status = 'success';
        $account_office_status = 'approved';
        $account_office_approve_reject_date = date('Y-m-d');
        $payment_date_time = date('Y-m-d');
        $update->bind_param(
            "ssssi",
            $payment_status,
            $payment_date_time,
            $account_office_status,
            $account_office_approve_reject_date,
            $updateId
        );
        $result = $update->execute();
        if ($result) {
            $response = [
                "status" => 200,
                "message" => "approved",
            ];
        } else {
            $response = [
                "status" => 400,
                "message" => $con->error,
            ];
        }
    } 
  }
  else{
    $response = [
        "status" => 400,
        "message" => "no row found",
    ];
  }
}   
else {
    $update = $con->prepare(
        "UPDATE tbl_admission_student SET payment_mode = ?,`payment_status` = ?,`account_office_status` = ?,`account_office_approve_reject_date` =?  WHERE id = ?"
    );
    $payment_status = 'pending';
    $account_office_status = 'rejected';
    $account_office_approve_reject_date = date('Y-m-d');
    $payment_mode = '';
    $update->bind_param(
        "ssssi",
        $payment_mode,
        $payment_status,
        $account_office_status,
        $account_office_approve_reject_date,
        $updateId
    );
    $result = $update->execute();
    if ($result) {
        $response = [
            "status" => 200,
            "message" => "rejected",
        ];
    } else {
        $response = [
            "status" => 400,
            "message" => $con->error,
        ];
    }
}

echo json_encode($response);
?>