<?php
// Allow requests from your frontend (CORS)
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../../common/importwebsitefile.php';

// Enable error reporting (DEV ONLY)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

// 1️⃣ Guard clause
if (empty($data->mobile)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Mobile number is required."
    ]);
    exit;
}

// 2️⃣ Prepare query
$query = "
    INSERT INTO tbl_promotional_form_data 
    (form_type, full_name, email, mobile) 
    VALUES (8, '---', '---', ?)
";

$stmt = $con->prepare($query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed",
        "error" => $con->error
    ]);
    exit;
}

// 3️⃣ Bind parameter (REQUIRED for mysqli)
$mobile = strip_tags($data->mobile);
$stmt->bind_param("s", $mobile);

// 4️⃣ Execute
if ($stmt->execute()) {

    http_response_code(201);
    echo json_encode([
        "status" => "success",
        "message" => "Data saved."
    ]);

} else {

    http_response_code(500);
    echo json_encode([
        "status"  => "error",
        "message" => "Save failed.",
        "error"   => $stmt->error
    ]);
}

$stmt->close();
