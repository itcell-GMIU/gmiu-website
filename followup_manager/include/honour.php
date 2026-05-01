<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$faculty_id = isset($data['faculty_id']) ? $data['faculty_id'] : 0;
$level_id = isset($data['level_id']) ? $data['level_id'] : 0;

$query = "SELECT id, name FROM tbl_program WHERE is_active = 1 AND is_delete = 0 AND level_id = 17 AND faculty_id = $faculty_id";

$result = $con->query($query);

if (!$result) {
    echo json_encode(["error" => $con->error]); // Show SQL error
    exit;
}

$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = ["id" => $row['id'], "text" => $row['name']];
}

echo json_encode(["options" => $options]);
$con->close();

?>