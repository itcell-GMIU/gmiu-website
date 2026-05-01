<?php
include "include/checklogin.php";

$col_name = $_POST['name'];
$updateId = $_POST['student_id'];
$stu_email = $_POST['student_email'];

if ($col_name == 'approved') {
    $update = $con->prepare(
        "UPDATE tbl_admission_student SET `status` = ? WHERE id = ?"
    );
    $status_ans = 'approved';
    $update->bind_param(
        "si",
        $status_ans,
        $updateId
    );
    $result = $update->execute();
    if ($result) {
        $response = [
            "status" => 200,
            "message" => "approved",$stu_email,
        ];
    } else {
        $response = [
            "status" => 400,
            "message" => $con->error,
        ];
    }
} else {
    $update = $con->prepare(
        "UPDATE tbl_admission_student SET admission_status=?,`status` = ? WHERE id = ?"
    );
    $status_ans = 'rejected';
    $admission_status = 'pending';
    $update->bind_param(
        "ssi",
        $admission_status,
        $status_ans,
        $updateId
    );
    $result = $update->execute();
    if ($result) {
        $response = [
            "status" => 200,
            "message" => "rejected",$stu_email,
        ];
    } else {
        $response = [
            "status" => 400,
            "message" => $con->error,
        ];
    }

    $subject = "Application Rejected";
    $message = "Dear Applicant, <br>
                Your Application is rejected by Admission Officer.<br>Please login in portal https://gmiu.edu.in/gmiu/admission/ to check the reason for rejection and resubmit the application by doing the necessary changes,to know more,</br>please feel free to call us at 9099951160
                or we will reach out to you shortly.<br>
                Keep visiting our website regularly for updates.
                <br>
                <br>
                -GMIU
                ";
    $to = $stu_email;
    send_mail($to, $subject, $message);
    //echo "success";
}

echo json_encode($response);
?>