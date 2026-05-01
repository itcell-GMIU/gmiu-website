<?php
include '../include/connect.php';

// JSON headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// GET parameters
$categoryId = isset($_GET['categoryId']) ? intval($_GET['categoryId']) : 0;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;

$isMain = isset($_GET['is_main']) ? intval($_GET['is_main']) : 1;

$acId = isset($_GET['ac_level_id']) ? intval($_GET['ac_level_id']) : null;
$edId = isset($_GET['ed_lvel_id']) ? intval($_GET['ed_lvel_id']) : null;
$brId = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : null;


// ==========================
// BASE QUERY
// ==========================
$query = "
    SELECT gi.id, gi.image, gi.alt_keyword, gc.title AS category_name
    FROM gallery_images gi
    LEFT JOIN gallery_images_category gc 
        ON gc.id = gi.category
    WHERE gi.is_active = 1 
      AND gi.is_delete = 0
";


// ==========================
// CASE 1: MAIN GALLERY (show all)
// ==========================
if ($isMain == 1) {

    // If category selected, filter by category
    if ($categoryId > 0) {
        $query .= " AND gi.category = $categoryId ";
    }

}
// ==========================
// CASE 2: FILTERED GALLERY
// ==========================
elseif ($isMain == 0) {

    // Require ALL filters
    if (!empty($acId) && !empty($edId) && !empty($brId)) {

        // Category filter (optional)
        if ($categoryId > 0) {
            $query .= " AND gi.category = $categoryId ";
        }

        // Apply filters
        $query .= "
            AND gi.ac_level_id = $acId
            AND gi.ed_level_id = $edId
            AND FIND_IN_SET($brId, gi.branch_id)
        ";

    } else {
        echo json_encode([
            "status" => "success",
            "images" => []
        ]);
        exit;
    }
}



// Order + Pagination
$query .= " ORDER BY gi.id DESC LIMIT $offset, $limit";


// Execute SQL
$res = $con->query($query);


// Build response
$rows = [];
$baseURL = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/";

while ($r = $res->fetch_assoc()) {
    $r['image_url'] = $baseURL . "gmiu/gallery/uploads/gallery/" . $r['image'];
    $rows[] = $r;
}


// JSON output
echo json_encode([
    "status" => "success",
    "images" => $rows
]);
?>