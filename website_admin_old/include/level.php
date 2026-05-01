<?php

include '../database/connect.php';
// SELECT * FROM tbl_faculty_level F, tbl_level L WHERE F.faculty_id = 1 AND F.level_id = L.id;
// SELECT * FROM tbl_program where level_id=.$_POST['level_id']

$faculty_id =   $_POST['faculty_data'];
$level_id =  isset($_POST['level_id']) ? $_POST['level_id'] : "";
$api_for =  isset($_POST['api_for']) ? $_POST['api_for'] : "";
$api_type =  isset($_POST['api_type']) ? $_POST['api_type'] : "";
if ($api_type == "admission") {
   $query = "SELECT l.id,l.name
   FROM tbl_faculty_level fl
   LEFT JOIN tbl_level l
   ON fl.level_id = l.id WHERE fl.faculty_id = $faculty_id AND fl.level_id = l.id AND fl.is_active = 1 AND fl.is_delete=0 AND fl.level_id!=3";
} else {
   $query = "SELECT l.id,l.name
   FROM tbl_faculty_level fl
   LEFT JOIN tbl_level l
   ON fl.level_id = l.id WHERE fl.faculty_id = $faculty_id AND fl.level_id = l.id AND fl.is_active = 1 AND fl.is_delete=0";
}

/* $query = "SELECT F.id,L.name FROM tbl_faculty_level F, tbl_level L WHERE F.faculty_id = $faculty_id AND F.level_id = L.id AND F.is_active = 1 AND F.is_delete=0";
 */
// $state_qry = mysqli_query($con, $query);
$result = $con->query($query);
// $output="";
$output = '<option value="">--Please select--</option>';

if ($result->num_rows > 0) {
   if ($api_for == "dashboard" && !empty($level_id)) {
      // Only show the selected level (for edit mode, role_id==8)
      while ($row = $result->fetch_assoc()) {
         if ($row['id'] == $level_id) {
            $output .= '<option selected value="' . $row['id'] . '">' . $row['name'] . '</option>';
         }
      }
   } else {
      while ($row = $result->fetch_assoc()) {
         if ($row['id'] == $level_id) {
            $output .= '<option selected value="' . $row['id'] . '">' . $row['name'] . '</option>';
         } else {
            $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
         }
      }
   }
} else {
   $output = '<option value="">No Level Record found</option>';
}
echo $output;
