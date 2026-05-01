<?php
include '../include/connect.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$response = [];

// Single optimized query with JOIN
$query = $con->query("
    SELECT 
        a.id AS academic_level_id,
        a.name AS academic_level_name,
        e.id AS education_level_id,
        e.name AS education_level_name
    FROM gallery_academic_level a
    LEFT JOIN gallery_education_level e 
        ON e.ac_level_id = a.id 
        AND e.is_active = 1 
        AND e.is_delete = 0
    WHERE 
        a.is_active = 1 
        AND a.is_delete = 0
    ORDER BY a.id ASC, e.id ASC
");

if ($query && $query->num_rows > 0) {

    while ($row = $query->fetch_assoc()) {

        $acLevelId = (int) $row['academic_level_id'];

        // Initialize academic level group if not exists
        if (!isset($response[$acLevelId])) {
            $response[$acLevelId] = [
                "academic_level_id" => $acLevelId,
                "academic_level_name" => $row['academic_level_name'],
                "education_levels" => []
            ];
        }

        // Add only if education level exists
        if (!empty($row['education_level_id'])) {
            $response[$acLevelId]["education_levels"][] = [
                "education_level_id" => (int) $row['education_level_id'],
                "education_level_name" => $row['education_level_name']
            ];
        }
    }

    echo json_encode([
        "status" => "success",
        "data" => array_values($response)
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "status" => "error",
        "message" => "No academic levels found."
    ]);
}

$con->close();
?>
