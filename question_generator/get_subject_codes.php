<?php
// Include your database connection file
include '../database/connect.php';

// Get the selected parameters from the AJAX request
$faculty_id = $_POST['faculty_id'];
$level_id = $_POST['level_id'];
$program_id = $_POST['program_id'];
$sem = $_POST['sem'];
$subject_code = $_POST['subject_code'];

// Prepare and execute the SQL query to fetch subject codes based on the provided parameters
$stmt = $con->prepare("SELECT id, subject_code,subject_name FROM tbl_std_corner_exam WHERE faculty_id = ? AND level_id = ? AND program_id = ? AND sem = ? and is_delete= '0' ");
$stmt->bind_param("iiii", $faculty_id, $level_id, $program_id, $sem);
$stmt->execute();
$result = $stmt->get_result();

// Build the dropdown options
$options = '<option value="">---Select subject Code---</option>';
while ($row = $result->fetch_assoc()) {
   // $options .= '<option value="' . $row['id'] . '">' . $row['subject_code'] . ' (' . $row['subject_name'] . ')</option>';
  
       $selected = ($row['id'] == $subject_code) ? 'selected' : ''; // Check if the option should be selected
       $options .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['subject_code'] . ' (' . $row['subject_name'] . ')</option>';
   
   

}

// Return the options
echo $options;
?>
