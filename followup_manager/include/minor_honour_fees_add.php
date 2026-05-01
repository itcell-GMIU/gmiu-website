<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$program_id = isset($data['program_id']) ? (int)$data['program_id'] : 0;

$response = [];

if ($program_id > 0) {
    $query = "SELECT sem1 FROM tbl_program WHERE is_active = 1 AND is_delete = 0 AND id = $program_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = [
            "status" => "success",
            "data" => $row
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "No program found with the given ID"
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "Invalid program ID"
    ];
}

echo json_encode($response);
