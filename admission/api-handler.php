<?php
header("Content-Type: application/json");

// Always return success
http_response_code(200);

echo json_encode([
    "success" => true,
    "message" => "API received the request successfully",
    "external_student_id" => uniqid("EXT_"),
    "synced_at" => date("Y-m-d H:i:s")
]);

exit;
