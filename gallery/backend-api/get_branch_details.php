<?php
include '../include/connect.php';

// Set the header to return JSON content
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$response = [];

// Check if all required GET parameters are set
if (isset($_GET['academicId']) && isset($_GET['educationId']) && isset($_GET['branchId'])) {

    $academicId = $_GET['academicId'];
    $educationId = $_GET['educationId'];
    $branchId = $_GET['branchId'];

    // The query you provided
    $sql = "SELECT
                gbd.id,
                gbd.ac_level_id,
                gal.name AS academic_name,
                gbd.ed_level_id,
                gel.name AS education_name,
                gbd.branch_id,
                gb.branch_name,
                gbd.about,
                gbd.image,
                gbd.registered_students,
                gbd.placed_students,
                gbd.placement_rate,
                gbd.highest_package,
                gbd.average_package,
                gbd.companies_visited
            FROM
                `gallery_branch_details` AS gbd
            JOIN gallery_branches AS gb ON gbd.branch_id = gb.id
            JOIN gallery_academic_level AS gal ON gbd.ac_level_id = gal.id
            JOIN gallery_education_level AS gel ON gbd.ed_level_id = gel.id
            WHERE
                gbd.ac_level_id = ? 
                AND gbd.ed_level_id = ? 
                AND gbd.branch_id = ? 
                AND gbd.is_active = 1 
                AND gbd.is_delete = 0";

    $stmt = $con->prepare($sql);

    // Bind parameters: 'iii' for three integers
    $stmt->bind_param("iii", $academicId, $educationId, $branchId);

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        // Since we expect only one row
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // --- START: Image URL Modification ---
            // Build the base URL
            $baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
            $baseURL .= "://" . $_SERVER['HTTP_HOST'];

            // Build the full image URL using your provided path structure
            // NOTE: Using the path from your example.
            $imageURL = $baseURL . "/gmiu/gallery/uploads/branch-img/" . $data['image'];

            // Overwrite the 'image' field with the full URL
            $data['image'] = $imageURL;
            // --- END: Image URL Modification ---

            $response['status'] = 'success';
            $response['data'] = $data;
        } else {
            // No data found for these IDs
            http_response_code(404);
            $response['status'] = 'error';
            $response['message'] = 'Branch details not found.';
        }

    } catch (Exception $e) {
        // Handle SQL execution error
        http_response_code(500); // Internal Server Error
        $response['status'] = 'error';
        $response['message'] = 'Database query failed: ' . $e->getMessage();
    }

    $stmt->close();

} else {
    // Missing parameters
    http_response_code(400); // Bad Request
    $response['status'] = 'error';
    $response['message'] = 'Missing required parameters: academicId, educationId, and branchId.';
}

$con->close();

// Encode the final response object and print it
echo json_encode($response);
?>