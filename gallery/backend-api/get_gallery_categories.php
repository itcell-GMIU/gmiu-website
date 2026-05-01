<?php
include '../include/connect.php';

// JSON response headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$isMain = isset($_GET['is_main']) ? intval($_GET['is_main']) : 1;

$acId = isset($_GET['ac_level_id']) ? intval($_GET['ac_level_id']) : null;
$edId = isset($_GET['ed_lvel_id']) ? intval($_GET['ed_lvel_id']) : null;
$brId = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : null;

// ===============================
// BASE QUERY
// ===============================
$query = "
    SELECT c.id, c.title
    FROM gallery_images_category c
    INNER JOIN gallery_images i 
        ON i.category = c.id
        AND i.is_active = 1
        AND i.is_delete = 0
    WHERE c.is_active = 1
      AND c.is_delete = 0
";

// ===============================
// CASE 1: MAIN GALLERY (show ALL categories with images)
// ===============================
if ($isMain == 1) {
    // No extra filters
}

// ===============================
// CASE 2: FILTERED GALLERY (apply required filters)
// ===============================
elseif ($isMain == 0) {

    // Require ALL 3 filters just like your image API
    if (!empty($acId) && !empty($edId) && !empty($brId)) {

        $query .= "
            AND i.ac_level_id = $acId
            AND i.ed_level_id = $edId
            AND FIND_IN_SET($brId, i.branch_id)
        ";

    } else {
        echo json_encode([
            "status" => "success",
            "categories" => []
        ]);
        exit;
    }
}

$query .= "
    GROUP BY c.id
    ORDER BY c.title ASC
";

$q = $con->query($query);

$rows = [];
while ($r = $q->fetch_assoc()) {
    $rows[] = $r;
}

echo json_encode([
    "status" => "success",
    "categories" => $rows
]);
?>