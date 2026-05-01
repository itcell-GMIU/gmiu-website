<?php
include "include/checklogin.php";


$col_name = $_POST['name'];
$updateId = $_POST['student_id'];

if ($col_name == '1') {

$cmd = "SELECT id FROM `tbl_admission_student` WHERE `id` = ?";
  $stmt = $con->prepare($cmd);
  $stmt->bind_param("i", $updateId);
  $stmt->execute();
  $result = $stmt->get_result(); // get the mysqli result

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
        $update = $con->prepare(
            "UPDATE tbl_admission_student SET `uniform_status` = ? , `uniform_approve_date` = ? WHERE id = ?"
        );

        $uniform_status = '1';
        $update->bind_param(
            "ii",
            $uniform_status,
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
  else{
    $response = [
        "status" => 400,
        "message" => "no row found",
    ];
  }
}   

echo json_encode($response);
?>