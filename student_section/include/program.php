<?php
include '../../database/connect.php';

// echo $level_id = $_POST['level_data'];
$faculty_id = $_POST['faculty_data'];

$sprogram_id = isset($_POST['program_id']) ? $_POST['program_id'] : "";
$api_for = isset($_POST['api_for']) ? $_POST['api_for'] : "";
$level_id = $_POST['level_data'];

$query = "SELECT id,name, branch_code FROM tbl_program WHERE level_id = $level_id AND is_active = 1  AND faculty_id= $faculty_id  AND is_delete=0";
// echo $query = "SELECT id,name FROM tbl_program WHERE level_id IN ($level_id) AND is_active = 1  AND faculty_id= $faculty_id  AND is_delete=0";

$result = $con->query($query);
$output = '<option value="">--Please select--</option>';
if ($result->num_rows > 0) {


   if ($api_for == "dashboard") {
      while ($row = $result->fetch_assoc()) {
         if ($row['id'] == $sprogram_id) {
            $output .= '<option selected value="' . $row['id'] . '">' . $row['name'] . ' - ' . $row['branch_code'] . '</option>';
         } else {
            $output .= '<option value="' . $row['id'] . '">' . $row['name'] . ' - ' . $row['branch_code'] . '</option>';
         }
      }
   } else {
      while ($row = $result->fetch_assoc()) {
         $output .= '<option value="' . $row['id'] . '">' . $row['name'] . ' - ' . $row['branch_code'] . '</option>';
      }
   }
} else {
   $output = '<option value="">No Program Record found</option>';
}
echo $output;




?>