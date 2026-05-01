<?php

include 'include/checklogin.php';
$student_id = $_POST["student_id"];
$stmt = $con->prepare("SELECT stu_doc.* FROM `tbl_student_document` as stu_doc WHERE student_id = ? ");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 1)
{
     $row = $result->fetch_assoc();

     $response = [
          'status' => 200,
          'message' => 'Success',
          'data' => $row
     ]; 
}
else
{
     $response = [
          'status' => 400,
          'message' => 'No data Found',
          'data' => null
     ]; 
}

     
echo json_encode($response);
?>