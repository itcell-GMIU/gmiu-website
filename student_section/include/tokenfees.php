<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../database/connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$program_id = isset($data['program_id']) ? (int) $data['program_id'] : 0; // Ensure it's an integer

$query = "SELECT 
  token, 
  sem1, 
  sem2, 
  sem3,
  CASE 
    WHEN sem1 IS NULL AND sem2 IS NULL THEN sem3 
    ELSE sem1 
  END AS selected_sem
FROM tbl_program 
WHERE id = $program_id;
";
$result = $con->query($query);

if (!$result) {
  echo json_encode(["error" => $con->error]); // Return SQL error
  exit;
}

$tokenfees = null; // Initialize variable

if ($row = $result->fetch_assoc()) {
  $tokenfees = $row['token'];
  $semFees = $row['selected_sem'];
}

$response = isset($tokenfees)
  ? ["tokenfees" => $tokenfees, "semfees" => $semFees]
  : ["error" => "No data found"]; // Handle no results case

echo json_encode($response);
$con->close();
