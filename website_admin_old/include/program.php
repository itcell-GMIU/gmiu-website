<?php
include '../../database/connect.php';

// Support both form-encoded and JSON requests
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $data = json_decode(file_get_contents('php://input'), true);
} else {
    $data = $_POST;
}

// Extract values safely
$level_id = isset($data['level_id']) ? $data['level_id'] : 0;
$faculty_id = isset($data['faculty_id']) ? $data['faculty_id'] : 0;
$staff_id = isset($data['staff_id']) ? $data['staff_id'] : 0;
$sprogram_id = isset($data['program_id']) ? $data['program_id'] : "";
$api_for = isset($data['api_for']) ? $data['api_for'] : "";

// Check if staff role is 8
$staff_query = "SELECT role_id, program_id FROM tbl_staff WHERE id = $staff_id LIMIT 1";
$staff_result = $con->query($staff_query);

$role_id = 0;
$staff_program_id = 0;

if ($staff_result->num_rows > 0) {
    $staff_data = $staff_result->fetch_assoc();
    $role_id = $staff_data['role_id'];
    $staff_program_id = $staff_data['program_id'];
}

$output = '<option value="">--Please select--</option>';

if ($role_id == 8) {
    // Only show the staff's assigned program if role is 8
   $query = "SELECT tblp.id, tblp.name, tbll.name as level_name 
          FROM tbl_program as tblp 
          JOIN tbl_level AS tbll ON tblp.level_id = tbll.id 
          WHERE tblp.id IN($staff_program_id) 
            AND tblp.level_id = $level_id 
            AND tblp.is_active = 1 
            AND tblp.is_delete = 0";
} else {
    // Show all programs based on level and faculty
    $query = "SELECT id, name FROM tbl_program WHERE level_id = $level_id  AND faculty_id = $faculty_id AND is_active = 1 AND is_delete = 0";
}

$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $selected = ($row['id'] == $sprogram_id) ? "selected" : "";
        $output .= '<option ' . $selected . ' value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['level_name'].') ' .'</option>';
    }
} else {
    $output = '<option value="">No Program Record found</option>';
}

echo $output;
