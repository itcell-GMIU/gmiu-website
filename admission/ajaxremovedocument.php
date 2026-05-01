<?php
include 'include/checklogin.php';
$set="";
$col_name= $_POST['col_name'];
$update = $con->prepare(
     "UPDATE tbl_student_document SET $col_name = ? WHERE student_id = ?"
 );
 $update->bind_param("si",$set, $student_id);
 $result = $update->execute();
 if ($result) {
     $response = [
         "status" => 200,
         "message" => "Record Updated Successfully!",
     ];
 } else {
     $response = [
         "status" => 400,
         "message" => $con->error,
     ];
 }
echo json_encode($response);
?>