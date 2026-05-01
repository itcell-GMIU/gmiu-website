<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); // Ensure JSON response format

include '../../database/connect.php';

if (!isset($_GET['branch_id']) || empty($_GET['branch_id'])) {
    echo json_encode(["success" => false, "message" => "Branch ID is required"]);
    exit;
}

$branchID = intval($_GET['branch_id']);

$query = "SELECT
            tbl_program.id AS program_id,
            tbl_program.name AS program_name,
            tbl_program.faculty_id,
            tbl_program.level_id,
            tbl_faculty.name AS faculty_name,
            tbl_level.name AS level_name
        FROM
            tbl_program
        JOIN tbl_faculty ON tbl_program.faculty_id = tbl_faculty.id
        JOIN tbl_level ON tbl_program.level_id = tbl_level.id
        WHERE
            tbl_program.is_active = 1 AND tbl_program.is_delete = 0 AND tbl_program.branch_code = ?";

$stmt = $con->prepare($query);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $con->error]);
    exit;
}

$stmt->bind_param("i", $branchID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "faculty_id" => $row['faculty_id'],
        "faculty_name" => $row['faculty_name'],
        "level_id" => $row['level_id'],
        "level_name" => $row['level_name'],
        "program_id" => $row['program_id'],
        "program_name" => $row['program_name']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No data found"]);
}

$stmt->close();
$con->close();
?>