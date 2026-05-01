<?php
header('Content-Type: application/json');

$targetDir = __DIR__ . "/uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (!isset($_FILES['upload'])) {
    echo json_encode([
        "uploaded" => 0,
        "error" => ["message" => "No file uploaded."]
    ]);
    exit;
}

$originalName = $_FILES['upload']['name'];
$cleanName = preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $originalName);
$fileName = time() . '-' . $cleanName;
$targetFile = $targetDir . $fileName;

if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFile)) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // ✅ detects /gmiu/question_generator/question_bank

    $url = $protocol . $host . $scriptPath . "/uploads/" . $fileName;

    echo json_encode([
        "uploaded" => 1,
        "fileName" => $fileName,
        "url" => $url
    ]);
    exit;
}

echo json_encode([
    "uploaded" => 0,
    "error" => ["message" => "Upload failed."]
]);
