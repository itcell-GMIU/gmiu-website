<?php
include '../include/connect.php';

// Set the header to return JSON content
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$baseURL .= "://" . $_SERVER['HTTP_HOST'];

// This will be our final JSON response object
$response = [];

// Data payload
$output = [
    'academic_name' => null,
    'education_name' => null,
    'details' => []
];

// Check if the required GET parameters are set
if (isset($_GET['academicId']) && isset($_GET['educationId'])) {

    $academicId = $_GET['academicId'];
    $educationId = $_GET['educationId'];

    $sql = "SELECT 
                d.title, 
                d.description, 
                d.image,
                ac.name AS academic_name, 
                ed.name AS education_name,
                ed.video_link AS video_link
            FROM gallery_education_level_description d
            LEFT JOIN gallery_academic_level ac ON d.ac_level_id = ac.id
            LEFT JOIN gallery_education_level ed ON d.ed_level_id = ed.id
            WHERE d.ac_level_id = ? 
              AND d.ed_level_id = ? 
              AND d.is_active = 1 
              AND d.is_delete = 0
            ORDER BY d.id ASC";

    $stmt = $con->prepare($sql);

    // Bind parameters: 'ii' for two integers
    $stmt->bind_param("ii", $academicId, $educationId);

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $is_first_row = true;

            while ($row = $result->fetch_assoc()) {
                if ($is_first_row) {
                    $output['academic_name'] = $row['academic_name'];
                    $output['education_name'] = $row['education_name'];
                    $output['video_link'] = $row['video_link'];
                    $is_first_row = false;
                }

                $output['details'][] = [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'image' => $baseURL . "/gmiu/gallery/uploads/education-img/" . $row['image']
                ];
            }
        }
        // Note: Even if num_rows is 0, it's a successful query.
        // The 'details' array will just be empty, which is correct.

        // On success, set the response
        $response['status'] = 'success';
        $response['data'] = $output;

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
    $response['message'] = 'Missing required parameters: academicId and educationId.';
}

$con->close();

// Encode the final response object and print it
echo json_encode($response);

?>